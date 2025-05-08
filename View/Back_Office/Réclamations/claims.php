<?php
include '../../../Controller/ReclamationC.php';
include '../../../Controller/ReponsesAdminC.php';
include '../../../Model/ReponsesAdmin.php';

$rc = new ReponsesAdminC();
$reclamations = (new ReclamationC())->listeReclamations();
$reponses = $rc->listeReponses();
$editMode = false;
$reponseToEdit = null;

if (isset($_GET['id_reponse'])) {
  $editMode = true;
  $reponseToEdit = $rc->getReponseById($_GET['id_reponse']);
}

$sortColumn = $_GET['sort'] ?? '';
$sortOrder = $_GET['order'] ?? 'asc';
$filterStatus = $_GET['status_filter'] ?? '';
$currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 5;

// Filtrage
$filteredReclamations = array_filter($reclamations, function ($rec) use ($filterStatus) {
  return empty($filterStatus) || $rec['Statut'] === $filterStatus;
});

// Tri
if ($sortColumn) {
  usort($filteredReclamations, function ($a, $b) use ($sortColumn, $sortOrder) {
    if (!isset($a[$sortColumn], $b[$sortColumn]))
      return 0;
    return ($sortOrder === 'asc')
      ? strcasecmp($a[$sortColumn], $b[$sortColumn])
      : strcasecmp($b[$sortColumn], $a[$sortColumn]);
  });
}

// Pagination
$totalItems = count($filteredReclamations);
$totalPages = ceil($totalItems / $perPage);
$offset = ($currentPage - 1) * $perPage;
$pagedReclamations = array_slice($filteredReclamations, $offset, $perPage);

function renderSortIcons($column, $currentColumn, $currentOrder)
{
  $order = ($currentColumn === $column && $currentOrder === 'asc') ? 'desc' : 'asc';
  $arrow = ($currentColumn === $column) ? ($currentOrder === 'asc' ? '▲' : '▼') : '↕';
  return "<a href=\"?sort=$column&order=$order\" class='sort-arrow' data-sort='$column' data-order='$order'>$arrow</a>";
}

$categoryStats = [];
foreach ($reclamations as $rec) {
  $cat = $rec['Categorie'];
  $categoryStats[$cat] = ($categoryStats[$cat] ?? 0) + 1;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once '../includes/header.php'; ?>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <style>
    .icon-link {
      font-size: 1.2em;
      text-decoration: none;
      margin-right: 5px;
    }

    .icon-link.edit {
      color: #007bff;
    }

    .icon-link.delete {
      color: #dc3545;
    }

    .card-header {
      display: flex;
      align-items: center;
      background-color: #2ecc71;
      color: white;
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 20px;
    }

    .icon {
      background: #2ecc71;
      color: white;
      border-radius: 5px;
      padding: 10px;
      margin-right: 10px;
    }

    .card {
      border: none;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      border-radius: 12px;
      margin-bottom: 30px;
    }

    .form-label {
      font-weight: 600;
    }

    .btn-unigreen {
      background-color: #2ecc71;
      border-color: #2ecc71;
    }

    .btn-unigreen:hover {
      background-color: #27ae60;
      border-color: #27ae60;
    }

    .content-wrapper {
      display: flex;
      justify-content: space-between;
      gap: 20px;
    }

    .form-container {
      flex: 1;
      max-width: 45%;
    }

    .table-container {
      flex: 1;
      height: auto;
      max-width: 100%;
      overflow: hidden;
      /* Cache toute débordement */
    }

    .table-container h1 {
      text-align: center;
      font-weight: bold;
      font-size: 32px;
      margin-bottom: 20px;
    }



    table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0 10px;
      font-size: 14px;
    }

    table th {
      background-color: #2ecc71;
      color: white;
      text-align: center;
      /* Corrigé pour "left" uniquement */
      vertical-align: middle;
      padding: 10px;
      border: none;
      border-radius: 10px 10px 0 0;
      font-size: 14px;
    }

    table tbody tr {
      background: #ffffff;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
      text-align: left;
    }

    table tbody tr:hover {
      transform: scale(1.02);
    }

    table td {
      padding: 15px;
      vertical-align: middle;
      text-align: center;
      border: none;
      font-size: 14px;
    }

    .sort-arrow {
      font-size: 16px;
      cursor: pointer;
    }

    .modal.modal-top .modal-dialog {
      margin-top: 50px;
    }

    .text-center {
      text-align: center;
    }

    .modal-content {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      transition: all 0.3s ease;
    }

    .modal-body {
      padding: 35px;
    }
  </style>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<body>
  <div class="wrapper">
    <?php require_once '../includes/configurator.php'; ?>
    <?php require_once '../includes/sidenav.php'; ?>
    <div class="main-panel">
      <?php require_once '../includes/navbar.php'; ?>
      <div class="content">
        <div class="container-fluid">
          <div class="table-container">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
              <div class="icon"><i class="material-icons">contacts</i></div>
              <h3 class="card-title">All Clients Claims</h3>
              <form method="GET" action="claims.php" style="display: flex; align-items: center; gap: 10px;">
                <select name="status_filter" class="form-control" style="padding: 6px 12px; border-radius: 6px;">
                  <option value="">-- Filter by Status --</option>
                  <option value="In Progress" <?= ($filterStatus === 'In Progress') ? 'selected' : ''; ?>>In Progress
                  </option>
                  <option value="Resolved" <?= ($filterStatus === 'Resolved') ? 'selected' : ''; ?>>Resolved</option>
                </select>
                <button type="submit" class="btn btn-sm btn-unigreen" style="padding: 6px 12px;">
                  <i class="material-icons">search</i>
                </button>
              </form>
            </div>
            <!-- Dans le div avec style="display: flex; ..." -->
            <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#statsModal">
              <i class="material-icons">bar_chart</i> Statistics
            </button>


            <table>
              <tr>
                <th>Claim ID<?= renderSortIcons('id_reclamation', $sortColumn, $sortOrder); ?></th>
                <th>Client ID</th>
                <th>Category<?= renderSortIcons('Categorie', $sortColumn, $sortOrder); ?></th>
                <th>Description<?= renderSortIcons('Description', $sortColumn, $sortOrder); ?></th>
                <th>Status</th>
                <th>Response</th>
                <th>New Response</th>
              </tr>

              <?php
              $reclamationsAvecReponses = [];

              foreach ($pagedReclamations as $rec):

                $idRec = htmlspecialchars($rec['id_reclamation']);
                $hasResponse = false;
                ?>
                <tr>
                  <td><?= $idRec ?></td>
                  <td><?= htmlspecialchars($rec['id_client']); ?></td>
                  <td><?= htmlspecialchars($rec['Categorie']); ?></td>
                  <td><?= htmlspecialchars($rec['Description']); ?></td>
                  <td><?= htmlspecialchars($rec['Statut']); ?></td>
                  <td>
                    <?php foreach ($reponses as $rep): ?>
                      <?php if ($rep['id_reclamation'] == $rec['id_reclamation']): ?>
                        <?php $hasResponse = true; ?>
                        <p><strong><?= htmlspecialchars($rep['Reponse']) ?></strong></p>
                        <small><?= htmlspecialchars($rep['Date_reponse']) ?></small><br>
                        <div class="button-container d-flex justify-content-start">
                          <a href="claims.php?id_reponse=<?= $rep['id_reponse'] ?>" class="material-icons icon-link edit"
                            title="Edit">edit</a>
                          <a href="delete2.php?id_reponse=<?= $rep['id_reponse'] ?>" class="material-icons icon-link delete"
                            title="Delete" onclick="return confirm('Do you want to delete your response ?');">delete</a>
                          <button class="btn btn-info open-thread d-flex align-items-center justify-content-center"
                            data-id="<?= $rec['id_reclamation'] ?>" data-bs-toggle="modal"
                            data-bs-target="#threadModal<?= $rec['id_reclamation'] ?>"
                            style="border-radius: 50%; width: 25px; height: 25px; padding: 0;">
                            <i class="fas fa-comment-dots" style="font-size: 14px;"></i>
                          </button>

                        </div>


                        <?php ?>
                      <?php endif; ?>
                    <?php endforeach; ?>

                    <?php if (!$hasResponse): ?>
                      <p style="color: red;">No Responses Yet</p>
                    <?php endif; ?>
                  </td>

                  <td>
                    <?php $isEditingThis = $editMode && $reponseToEdit && $reponseToEdit['id_reclamation'] == $rec['id_reclamation']; ?>
                    <form action="<?= $isEditingThis ? 'edit2.php' : 'Add2.php' ?>" method="POST">
                      <input type="hidden" name="id_reclamation" value="<?= $idRec ?>">
                      <?php if ($isEditingThis): ?>
                        <input type="hidden" name="id_reponse"
                          value="<?= htmlspecialchars($reponseToEdit['id_reponse']); ?>">
                      <?php endif; ?>
                      <label for="Reponse">Your Response :</label>
                      <textarea name="Reponse"
                        required><?= $isEditingThis ? htmlspecialchars($reponseToEdit['Reponse']) : '' ?></textarea><br>
                      <div class="d-flex justify-content-center mt-2">
                        <button type="submit" class="btn btn-unigreen btn-sm px-3">
                          <i class="material-icons">send</i> <?= $isEditingThis ? 'Edit' : 'Answer' ?>
                        </button>
                      </div>
                    </form>
                  </td>
                </tr>

                <?php if ($hasResponse):
                  $reclamationsAvecReponses[] = $idRec;
                endif; ?>
              <?php endforeach; ?>
            </table>
            <!-- Pagination Controls -->
            <div class="pagination d-flex justify-content-center mt-3">
              <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a class="mx-1 btn btn-sm <?= ($i == $currentPage) ? 'btn-primary' : 'btn-outline-secondary' ?>"
                  href="?page=<?= $i ?>&sort=<?= urlencode($sortColumn) ?>&order=<?= urlencode($sortOrder) ?>&status_filter=<?= urlencode($filterStatus) ?>">
                  <?= $i ?>
                </a>
              <?php endfor; ?>
            </div>
            <?php foreach ($reclamationsAvecReponses as $idRec): ?>
              <div id="threadModal<?= $idRec ?>" class="modal fade modal-top" tabindex="-1">

                <div class="modal-dialog modal-dialog-scrollable modal-lg" style="margin-top: 50px;">

                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Conversation</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="threadContent<?= $idRec ?>">Chargement...</div>
                    <div class="modal-footer">
                      <form id="messageForm<?= $idRec ?>" class="messageForm" data-thread="<?= $idRec ?>">
                        <input type="hidden" name="id_reclamation" value="<?= $idRec ?>">
                        <textarea name="contenu" class="form-control" required></textarea>
                        <button type="submit" class="btn btn-unigreen mt-2">Send</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>



          </div>
        </div>
      </div>
      <?php require_once '../includes/footer.php'; ?>
    </div>
  </div>
  <!-- Modal Statistiques -->
  <!-- Modal Statistiques (compact et stylisé) -->
  <!-- Modal Statistiques (compact et stylisé) -->
  <div class="modal fade" id="statsModal" tabindex="-1" aria-labelledby="statsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content shadow" style="border-radius: 15px;">
        <div class="modal-header bg-primary text-white"
          style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
          <h5 class="modal-title" id="statsModalLabel">
            <i class="material-icons">insights</i> Claim Category Trends
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <canvas id="categoryChart" style="max-height: 300px;"></canvas>
        </div>
      </div>
    </div>
  </div>




  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const ctx = document.getElementById('categoryChart').getContext('2d');

      new Chart(ctx, {
        type: 'line',
        data: {
          labels: <?= json_encode(array_keys($categoryStats)) ?>,
          datasets: [{
            label: 'Number of Claims',
            data: <?= json_encode(array_values($categoryStats)) ?>,
            borderColor: '#007bff',
            backgroundColor: 'rgba(0, 123, 255, 0.1)',
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#007bff',
            pointBorderColor: '#fff',
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: '#007bff',
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false },
            tooltip: {
              callbacks: {
                label: function (context) {
                  return ` ${context.label}: ${context.raw} claims`;
                }
              }
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: { stepSize: 1 }
            }
          }
        }
      });
    });
  </script>










  <script>
    // Gestion du tri
    document.querySelectorAll('.sort-arrow').forEach(link => {
      link.addEventListener('click', function (e) {
        e.preventDefault();
        const url = new URL(window.location.href);
        url.searchParams.set('sort', this.dataset.sort);
        url.searchParams.set('order', this.dataset.order);
        window.location.href = url;
      });
    });
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      // Gestion de l'ouverture de la modale
      document.querySelectorAll('.open-thread').forEach(button => {
        button.addEventListener('click', function () {
          const id = this.dataset.id;
          const modal = document.getElementById("threadModal" + id);
          const contentContainer = document.getElementById("threadContent" + id);

          // Ne pas vider le contenu tant que la nouvelle réponse n'est pas prête
          fetch("../../../View/Acceuil/pages/load_thread.php?id_reclamation=" + encodeURIComponent(id))
            .then(res => res.text())
            .then(data => {
              // Attendre un tout petit délai pour éviter les effets visuels
              setTimeout(() => {
                contentContainer.innerHTML = data;
              }, 200); // 200 ms = après l'effet de fade-in Bootstrap
            })
            .catch(error => {
              contentContainer.innerHTML = "<p class='text-danger'>Erreur de chargement...</p>";
              console.error("Erreur lors du chargement du thread :", error);
            });
        });
      });

      // Gestion de l'envoi du message
      document.querySelectorAll('.messageForm').forEach(form => {
        form.addEventListener('submit', function (e) {
          e.preventDefault();
          const id = this.dataset.thread;
          const contentContainer = document.getElementById("threadContent" + id);
          const formData = new FormData(this);

          fetch("../../../View/Acceuil/pages/send_message.php", {
            method: "POST",
            body: formData
          })
            .then(() => {
              return fetch("../../../View/Acceuil/pages/load_thread.php?id_reclamation=" + encodeURIComponent(id));
            })
            .then(res => res.text())
            .then(data => {
              contentContainer.innerHTML = data;
              this.reset();
            })
            .catch(error => {
              contentContainer.innerHTML = "<p class='text-danger'>Erreur lors de l'envoi du message...</p>";
              console.error("Erreur :", error);
            });
        });
      });
    });
  </script>



</body>

</html>