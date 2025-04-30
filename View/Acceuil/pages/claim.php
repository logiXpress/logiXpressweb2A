<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap"
    rel="stylesheet">

  <title>Secure Checkout | LogiXpress</title>

  <!-- Bootstrap core CSS -->
  <link href="../../../Public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Additional CSS Files -->
  <link rel="stylesheet" href="../../../Public/assets/css/fontawesome.css">
  <link rel="stylesheet" href="../../../Public/assets/css/style.css">
  <link rel="stylesheet" href="../../../Public/assets/css/owl.css">
</head>

<body>

  <!-- ***** Preloader Start ***** -->
  <div id="preloader">
    <div class="jumper">
      <div></div>
      <div></div>
      <div></div>
    </div>
  </div>
  <!-- ***** Preloader End ***** -->

  <!-- Header -->
  <div class="sub-header">
    <div class="container">
      <div class="row">
        <div class="col-md-8 col-xs-12">
          <ul class="left-info">
            <li><a href="#"><i class="fa fa-envelope"></i>logixpress@gmail.com</a></li>
            <li><a href="#"><i class="fa fa-phone"></i>+216 56 207 742</a></li>
          </ul>
        </div>
        <div class="col-md-4">
          <ul class="right-icons">
            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <header class="">
    <nav class="navbar navbar-expand-lg">
      <div class="container">
        <a class="navbar-brand" href="../index.php">
          <h2>LogiXpress<em> Website</em></h2>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
          aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="../index.php">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="products.html">Products</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="claim.php">Claims</a>
            </li>
            <li class="nav-item dropdown">
              <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                aria-expanded="false">About</a>

              <div class="dropdown-menu">
                <a class="dropdown-item" href="about.html">About Us</a>
                <a class="dropdown-item" href="blog.html">Blog</a>
                <a class="dropdown-item" href="testimonials.html">Testimonials</a>
                <a class="dropdown-item" href="terms.html">Terms</a>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.html">Contact Us</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <div class="page-heading header-text">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1>Your Claims</h1>
          <span>If there's any issue, issue your claim here</span>
        </div>
      </div>
    </div>
  </div>


  <!-- Page Content -->
  <?php

  session_start();
  include '../../../Controller/ReclamationC.php';
  include '../../../Controller/ReponsesAdminC.php';
  include '../../../Model/ReponsesAdmin.php';


  $reclamationC = new ReclamationC();
  $liste = [];
  $editMode = false;
  $reclamationToEdit = null;

  $sortColumn = $_GET['sort'] ?? 'id_reclamation';
  $sortOrder = $_GET['order'] ?? 'asc';
  $statusFilter = $_GET['status_filter'] ?? null;

  if (!empty($_SESSION['id_client'])) {
    $id_client = $_SESSION['id_client'];
    $liste = $reclamationC->getReclamationsByClientId($id_client, $sortColumn, $sortOrder, $statusFilter);
  }
  $reponsesAdminC = new ReponsesAdminC();
  $reponses = $reponsesAdminC->getAllReponsesAdmin();
  $reponsesByReclamation = [];
  foreach ($reponses as $reponse) {
    $reponsesByReclamation[$reponse['id_reclamation']] = $reponse;
  }




  // Filter by status if requested
  if (!empty($_GET['status_filter'])) {
    $statusFilter = $_GET['status_filter'];
    $liste = array_filter($liste, function ($rec) use ($statusFilter) {
      return strtolower($rec['Statut']) === strtolower($statusFilter);
    });
  }

  usort($liste, function ($a, $b) use ($sortColumn, $sortOrder) {
    $valA = strtolower($a[$sortColumn]);
    $valB = strtolower($b[$sortColumn]);


    if (is_numeric($valA) && is_numeric($valB)) {
      return ($sortOrder === 'asc') ? $valA - $valB : $valB - $valA;
    } else {
      return ($sortOrder === 'asc') ? strcmp($valA, $valB) : strcmp($valB, $valA);
    }
  });


  if (isset($_GET['id_reclamation'])) {
    $editMode = true;
    $idReclam = intval($_GET['id_reclamation']);
    foreach ($liste as $rec) {
      if ($rec['id_reclamation'] == $idReclam) {
        $reclamationToEdit = $rec;
        break;
      }
    }
  }

  function renderSortIcons($column, $currentSort, $currentOrder)
  {
    $ascUrl = "?sort=$column&order=asc";
    $descUrl = "?sort=$column&order=desc";
    $ascColor = ($currentSort === $column && $currentOrder === 'asc') ? '#f1c40f' : 'white';
    $descColor = ($currentSort === $column && $currentOrder === 'desc') ? '#f1c40f' : 'white';

    return <<<HTML
    <span style="float: right;">
      <a href="$ascUrl" class="sort-arrow" data-sort="$column" data-order="asc" style="color: $ascColor; text-decoration: none;">↑</a>
      <a href="$descUrl" class="sort-arrow" data-sort="$column" data-order="desc" style="color: $descColor; text-decoration: none; margin-left: 5px;">↓</a>
    </span>
  HTML;
  }
  ?>
  <?php require_once '../../../View/Back_Office/includes/header.php'; ?>
  <style>
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

    .btn-primary {
      background-color: #2ecc71;
      border-color: #2ecc71;
    }

    .btn-primary:hover {
      background-color: #27ae60;
      border-color: #27ae60;
    }

    .content-wrapper {
      display: flex;
      justify-content: space-between;
      gap: 40px;
      padding: 70 70px;
      /* Ajoute un padding sur les côtés */
    }


    .form-container {
      flex: 0.4;
      max-width: 40%;
    }

    .table-container {
      flex: 0.8;
      max-width: 80%;
    }



    .table-container h1 {
      text-align: center;
      font-weight: bold;
      font-size: 32px;
      margin-bottom: 20px;
    }

    .scrollable-table {
      overflow-x: auto;
      /* Active le défilement horizontal */
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      background-color: #ffffff;
      padding: 20px;
    }

    .scrollable-table::-webkit-scrollbar {
      width: 8px;
      height: 8px;
    }

    .scrollable-table::-webkit-scrollbar-thumb {
      background-color: #3498db;
      border-radius: 10px;
    }

    .scrollable-table::-webkit-scrollbar-track {
      background-color: #f1f1f1;
    }

    .scrollable-table::-webkit-scrollbar-thumb:hover {
      background-color: #2980b9;
    }

    .scrollable-table::-webkit-scrollbar-track:hover {
      background-color: #e0e0e0;
    }

    .scrollable-table::-webkit-scrollbar-corner {
      background-color: #f1f1f1;
    }

    .scrollable-table::-webkit-scrollbar-button {
      background-color: #3498db;
      border-radius: 10px;
    }

    .scrollable-table::-webkit-scrollbar-button:hover {
      background-color: #2980b9;
    }

    .scrollable-table::-webkit-scrollbar-button:vertical:decrement {
      background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white"><path d="M7 10l5 5 5-5H7z"/></svg>');
      background-repeat: no-repeat;
      background-position: center;
      background-size: 12px;
    }

    .scrollable-table::-webkit-scrollbar-button:vertical:increment {
      background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white"><path d="M7 14l5-5 5 5H7z"/></svg>');
      background-repeat: no-repeat;
      background-position: center;
      background-size: 12px;
    }

    .scrollable-table::-webkit-scrollbar-button:horizontal:decrement {
      background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white"><path d="M10 7l5 5-5 5V7z"/></svg>');
      background-repeat: no-repeat;
      background-position: center;
      background-size: 12px;
    }

    .scrollable-table::-webkit-scrollbar-button:horizontal:increment {
      background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white"><path d="M14 7l-5 5 5 5V7z"/></svg>');
      background-repeat: no-repeat;
      background-position: center;
      background-size: 12px;
    }

    .scrollable-table::-webkit-scrollbar-button:vertical:decrement:hover {
      background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white"><path d="M7 10l5 5 5-5H7z"/></svg>');
      background-repeat: no-repeat;
      background-position: center;
      background-size: 12px;
    }

    .scrollable-table::-webkit-scrollbar-button:vertical:increment:hover {
      background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white"><path d="M7 14l5-5 5 5H7z"/></svg>');
      background-repeat: no-repeat;
      background-position: center;
      background-size: 12px;
    }

    .scrollable-table::-webkit-scrollbar-button:horizontal:decrement:hover {
      background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white"><path d="M10 7l5 5-5 5V7z"/></svg>');
      background-repeat: no-repeat;
      background-position: center;
      background-size: 12px;
    }

    .scrollable-table::-webkit-scrollbar-button:horizontal:increment:hover {
      background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white"><path d="M14 7l-5 5 5 5V7z"/></svg>');
      background-repeat: no-repeat;
      background-position: center;
      background-size: 12px;
    }

    .scrollable-table::-webkit-scrollbar-button:vertical:decrement:hover {
      background-color: #2980b9;
    }

    .scrollable-table::-webkit-scrollbar-button:vertical:increment:hover {
      background-color: #2980b9;
    }

    .scrollable-table::-webkit-scrollbar-button:horizontal:decrement:hover {
      background-color: #2980b9;
    }

    .scrollable-table::-webkit-scrollbar-button:horizontal:increment:hover {
      background-color: #2980b9;
    }

    .scrollable-table::-webkit-scrollbar-thumb:hover {
      background-color: #2980b9;
    }

    .scrollable-table::-webkit-scrollbar-track:hover {
      background-color: #e0e0e0;
    }

    .scrollable-table::-webkit-scrollbar-corner:hover {
      background-color: #f1f1f1;
    }

    .scrollable-table::-webkit-scrollbar-button:hover {
      background-color: #2980b9;
    }

    .scrollable-table {
      max-height: 500px;
      /* Ajustez la hauteur selon vos besoins */
      overflow-y: auto;
      /* Active le défilement vertical */
      margin-top: 10px;
      /* Optionnel : espace au-dessus du tableau */
    }

    table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0 10px;
      font-size: 14px;
    }

    table th {
      background-color: #9b59b6;
      color: white;
      text-align: left;
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


    .text-center {
      text-align: center;
    }
  </style>
  <div class="wrapper">



    <div class="main-panel">

      <div class="content">
        <div class="container-fluid">
          <div class="content-wrapper">
            <div class="form-container">
              <div class="card">
                <div class="card-header">
                  <div class="icon"><i class="material-icons">contacts</i></div>
                  <h3 class="card-title">Add a Claim</h3>
                </div>
                <div class="card-body">
                  <!-- Formulaire -->
                  <form id="reclamationForm" action="Add.php" method="POST" onsubmit="return validateForm();">
                    <?php if ($editMode): ?>
                      <input type="hidden" name="id_reclamation" value="<?= $reclamationToEdit['id_reclamation']; ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                      <label for="id_client" class="form-label">ID Client :</label>
                      <input type="text" name="id_client" id="id_client"
                        value="<?= htmlspecialchars($reclamationToEdit['id_client'] ?? ($_SESSION['id_client'] ?? '')); ?>"
                        class="form-control">

                      <small id="idClientError" class="text-danger"></small>
                    </div>

                    <div class="mb-3">
                      <label for="Categorie" class="form-label">Category :</label>
                      <input type="text" name="Categorie" id="Categorie" class="form-control"
                        value="<?= htmlspecialchars($reclamationToEdit['Categorie'] ?? ''); ?>">
                      <small id="categorieError" class="text-danger"></small>
                    </div>

                    <div class="mb-3">
                      <label for="Description" class="form-label">Description :</label>
                      <input type="text" name="Description" id="Description" class="form-control"
                        value="<?= htmlspecialchars($reclamationToEdit['Description'] ?? ''); ?>">
                      <small id="descriptionError" class="text-danger"></small>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                      <button type="submit" class="btn btn-primary btn-lg w-50">
                        <i class="material-icons">send</i> <?= $editMode ? 'Edit' : 'Submit' ?>
                      </button>
                    </div>
                  </form>

                </div>
              </div>
            </div>

            <div class="table-container">
              <div class="scrollable-table">

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                  <h3 class="card-title" style="margin: 0;">My Claims</h3>
                  <form method="GET" action="claim.php" style="display: flex; align-items: center; gap: 10px;">
                    <select name="status_filter" class="form-control" style="padding: 6px 12px; border-radius: 6px;">
                      <option value="">-- Filter by Status --</option>
                      <option value="In Progress" <?= (($_GET['status_filter'] ?? '') === 'In Progress') ? 'selected' : ''; ?>>In Progress</option>
                      <option value="Resolved" <?= (($_GET['status_filter'] ?? '') === 'Resolved') ? 'selected' : ''; ?>>
                        Resolved
                      </option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary" style="padding: 6px 12px;">
                      <i class="material-icons">search</i>
                    </button>
                  </form>
                </div>


                <?php if (!empty($liste)): ?>
                  <table>
                    <tr>
                      <th>ID Claim <?= renderSortIcons('id_reclamation', $sortColumn, $sortOrder); ?></th>
                      <th>ID Client</th>
                      <th>Category <?= renderSortIcons('Categorie', $sortColumn, $sortOrder); ?></th>
                      <th>Description <?= renderSortIcons('Description', $sortColumn, $sortOrder); ?></th>
                      <th>Status</th>
                      <th>Response</th>

                      <th>Actions</th>
                    </tr>
                    <?php foreach ($liste as $rec): ?>
                      <tr>
                        <td><?= htmlspecialchars($rec['id_reclamation']); ?></td>
                        <td><?= htmlspecialchars($rec['id_client']); ?></td>
                        <td><?= htmlspecialchars($rec['Categorie']); ?></td>
                        <td><?= htmlspecialchars($rec['Description']); ?></td>
                        <td><?= htmlspecialchars($rec['Statut']); ?></td>
                        <td>
                          <?php if (isset($reponsesByReclamation[$rec['id_reclamation']])): ?>
                            <?= htmlspecialchars($reponsesByReclamation[$rec['id_reclamation']]['Reponse']) ?>
                          <?php else: ?>
                            <em>No Response Yet !</em>
                          <?php endif; ?>
                        </td>

                        <td>
                          <a href="claim.php?id_reclamation=<?= $rec['id_reclamation']; ?>" title="Edit">
                            <i class="material-icons" style="color: #3498db; cursor: pointer; font-size: 14px;">edit</i>
                          </a>
                          |
                          <a href="delete.php?id_reclamation=<?= $rec['id_reclamation']; ?>"
                            onclick="return confirm('Are you sure you want to delete your claim?');" title="Delete">
                            <i class="material-icons" style="color: #e74c3c; cursor: pointer; font-size: 14px;">delete</i>
                          </a>

                          <button class="btn btn-info open-thread" data-id="<?= $rec['id_reclamation'] ?>"
                            style="border-radius: 50%; padding: 4px; width: 25px; height: 25px;">
                            <i class="fas fa-comment-dots" style="font-size: 10px;"></i>
                          </button>




                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </table>
                <?php else: ?>
                  <p>No claim found! <?= htmlspecialchars($_SESSION['id_client'] ?? ''); ?>.</p>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <!-- Modal UNIQUE pour tous -->
  <div id="threadModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Conversation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" id="threadContent"></div>
        <div class="modal-footer">
          <form id="messageForm">
            <input type="hidden" name="id_reclamation" id="idReclamationInput">
            <textarea name="contenu" class="form-control" required></textarea>
            <button type="submit" class="btn btn-primary mt-2">Send</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      document.querySelectorAll('.open-thread').forEach(button => {
        button.addEventListener('click', () => {
          const idReclamation = button.dataset.id;
          document.getElementById('idReclamationInput').value = idReclamation;

          fetch(`load_thread.php?id_reclamation=${idReclamation}`)
            .then(response => response.text())
            .then(data => {
              document.getElementById('threadContent').innerHTML = data;
              new bootstrap.Modal(document.getElementById('threadModal')).show();
            });
        });
      });

      document.getElementById('messageForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        const id = document.getElementById('idReclamationInput').value;

        fetch('send_message.php', {
          method: 'POST',
          body: formData
        }).then(() => {
          return fetch(`load_thread.php?id_reclamation=${id}`);
        }).then(response => response.text())
          .then(data => {
            document.getElementById('threadContent').innerHTML = data;
            document.getElementById('messageForm').reset();
          });
      });
    });
  </script>


  <script>
    document.querySelectorAll('.sort-arrow').forEach(link => {
      link.addEventListener('click', function (e) {
        e.preventDefault();
        const url = new URL(window.location.href);
        url.searchParams.set('sort', this.dataset.sort);
        url.searchParams.set('order', this.dataset.order);

        window.history.pushState({}, '', url);

        // Rafraîchir uniquement la table (tu peux améliorer avec AJAX plus tard)
        window.location.reload();
      });
    });
  </script>


  <script>
    function validateForm() {
      let isValid = true;

      // Récupérer les valeurs
      const idClient = document.getElementById('id_client').value.trim();
      const categorie = document.getElementById('Categorie').value.trim();
      const description = document.getElementById('Description').value.trim();

      // Cacher les anciens messages
      document.getElementById('idClientError').textContent = '';
      document.getElementById('categorieError').textContent = '';
      document.getElementById('descriptionError').textContent = '';

      // ID Client : Numérique
      if (idClient === '') {
        document.getElementById('idClientError').textContent = 'Veuillez renseigner ce champ.';
        isValid = false;
      } else if (!/^\d+$/.test(idClient)) {
        document.getElementById('idClientError').textContent = 'Le champ doit être numérique.';
        isValid = false;
      }

      // Categorie : Alphabétique
      if (categorie === '') {
        document.getElementById('categorieError').textContent = 'Veuillez renseigner ce champ.';
        isValid = false;
      } else if (!/^[a-zA-ZÀ-ÿ\s]+$/.test(categorie)) {
        document.getElementById('categorieError').textContent = 'La catégorie doit être alphabétique.';
        isValid = false;
      }

      // Description : Alphabétique (avec accents, espaces autorisés)
      if (description === '') {
        document.getElementById('descriptionError').textContent = 'Veuillez renseigner ce champ.';
        isValid = false;
      } else if (!/^[a-zA-ZÀ-ÿ\s]+$/.test(description)) {
        document.getElementById('descriptionError').textContent = 'La catégorie doit être alphabétique.';
        isValid = false;
      }


      return isValid;
    }
  </script>

  <!-- Footer Starts Here -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-3 footer-item">
          <h4>LogiXpress</h4>
          <p>Vivamus tellus mi. Nulla ne cursus elit,vulputate. Sed ne cursus augue hasellus lacinia sapien vitae.</p>
          <ul class="social-icons">
            <li><a rel="nofollow" href="#" target="_blank"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
          </ul>
        </div>
        <div class="col-md-3 footer-item">
          <h4>Useful Links</h4>
          <ul class="menu-list">
            <li><a href="#">Vivamus ut tellus mi</a></li>
            <li><a href="#">Nulla nec cursus elit</a></li>
            <li><a href="#">Vulputate sed nec</a></li>
            <li><a href="#">Cursus augue hasellus</a></li>
            <li><a href="#">Lacinia ac sapien</a></li>
          </ul>
        </div>
        <div class="col-md-3 footer-item">
          <h4>Additional Pages</h4>
          <ul class="menu-list">
            <li><a href="#">Products</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">Terms</a></li>
          </ul>
        </div>
        <div class="col-md-3 footer-item last-item">
          <h4>Contact Us</h4>
          <div class="contact-form">
            <form id="contact footer-contact" action="" method="post">
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <fieldset>
                    <input name="name" type="text" class="form-control" id="name" placeholder="Full Name" required="">
                  </fieldset>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <fieldset>
                    <input name="email" type="text" class="form-control" id="email" pattern="[^ @]*@[^ @]*"
                      placeholder="E-Mail Address" required="">
                  </fieldset>
                </div>
                <div class="col-lg-12">
                  <fieldset>
                    <textarea name="message" rows="6" class="form-control" id="message" placeholder="Your Message"
                      required=""></textarea>
                  </fieldset>
                </div>
                <div class="col-lg-12">
                  <fieldset>
                    <button type="submit" id="form-submit" class="filled-button">Send Message</button>
                  </fieldset>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <div class="sub-footer">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <p>
            Copyright © 2020 Company Name
            - Template by: <a href="https://www.phpjabbers.com/">PHPJabbers.com</a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript -->
  <script src="../../../Public/vendor/jquery/jquery.min.js"></script>
  <script src="../../../Public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Additional Scripts -->
  <script src="../../../Public/assets/js/custom.js"></script>
  <script src="../../../Public/assets/js/owl.js"></script>
  <script src="../../../Public/assets/js/slick.js"></script>
  <script src="../../../Public/assets/js/accordions.js"></script>

  <script language="text/Javascript">
    cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
    function clearField(t) {                   //declaring the array outside of the
      if (!cleared[t.id]) {                      // function makes it static and global
        cleared[t.id] = 1;  // you could use true and false, but that's more typing
        t.value = '';         // with more chance of typos
        t.style.color = '#fff';
      }
    }
  </script>

</body>

</html>