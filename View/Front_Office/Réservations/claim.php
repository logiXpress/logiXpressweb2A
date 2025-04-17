<?php
session_start();
require_once '../../../Controller/ReclamationC.php';

$reclamationC = new ReclamationC();
$liste = [];
$editMode = false;
$reclamationToEdit = null;

$sortColumn = $_GET['sort'] ?? 'id_reclamation';
$sortOrder = $_GET['order'] ?? 'asc';

if (!in_array($sortColumn, ['id_reclamation', 'Categorie', 'Description'])) {
  $sortColumn = 'id_reclamation';
}
$sortOrder = ($sortOrder === 'desc') ? 'desc' : 'asc';

if (!empty($_SESSION['id_client'])) {
  $id_client = $_SESSION['id_client'];
  $liste = $reclamationC->getReclamationsByClientId($id_client);

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
}

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

<!DOCTYPE html>
<html lang="en">
<?php require_once '../includes/header.php'; ?>
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
    gap: 20px;
  }

  .form-container {
    flex: 1;
    max-width: 45%;
  }

  .table-container {
    flex: 1;
    max-width: 60%;
    overflow: hidden;
    /* Cache toute débordement */
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

<body>
  <div class="wrapper">
    <?php require_once '../includes/configurator.php'; ?>
    <?php require_once '../includes/sidenav.php'; ?>
    <div class="main-panel">
      <?php require_once '../includes/navbar.php'; ?>
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
                  <form action="Add.php" method="POST">
                    <?php if ($editMode): ?>
                      <input type="hidden" name="id_reclamation" value="<?= $reclamationToEdit['id_reclamation']; ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                      <label for="id_client" class="form-label">ID Client :</label>
                      <input type="number" name="id_client" id="id_client"
                        value="<?= htmlspecialchars($reclamationToEdit['id_client'] ?? $_SESSION['id_client']); ?>"
                        required class="form-control">
                    </div>

                    <div class="mb-3">
                      <label for="Categorie" class="form-label">Category :</label>
                      <input type="text" name="Categorie" id="Categorie" required class="form-control"
                        value="<?= htmlspecialchars($reclamationToEdit['Categorie'] ?? ''); ?>">
                    </div>

                    <div class="mb-3">
                      <label for="Description" class="form-label">Description :</label>
                      <textarea name="Description" id="Description" required
                        class="form-control"><?= htmlspecialchars($reclamationToEdit['Description'] ?? ''); ?></textarea>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                      <button type="submit" class="btn btn-primary btn-lg w-50" value="Submit">
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
                          <a href="claim.php?id_reclamation=<?= $rec['id_reclamation']; ?>" title="Edit">
                            <i class="material-icons" style="color: #3498db; cursor: pointer; font-size: 14px;">edit</i>
                          </a>
                          |
                          <a href="delete.php?id_reclamation=<?= $rec['id_reclamation']; ?>"
                            onclick="return confirm('Are you sure you want to delete your claim?');" title="Delete">
                            <i class="material-icons" style="color: #e74c3c; cursor: pointer; font-size: 14px;">delete</i>
                          </a>
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
      <?php require_once '../includes/footer.php'; ?>
    </div>
  </div>
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

</body>

</html>