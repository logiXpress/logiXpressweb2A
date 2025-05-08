<?php
require_once 'C:/Users/Desktop/PHP/htdocs/Project/Model/Entretien.php';
require_once 'C:/Users/Desktop/PHP/htdocs/Project/Controller/EntretienC.php';

$EntretienC = new EntretienC();

// Gestion des actions
if (isset($_POST['add'])) {
    $nouvelEntretien = new Entretien($_POST['id_vehicule'], $_POST['date'], $_POST['type_intervention'], isset($_POST['statut']) ? 'soumis' : 'non soumis');
    $EntretienC->ajouterEntretien($nouvelEntretien);
    $EntretienC->ajouterHistorique('add', $_POST['id_vehicule'], $_POST['type_intervention']);
    header('Location: listeentretiens.php');
    exit();
}

$entretien = null;
if (isset($_GET['id'])) {
    $entretien = $EntretienC->getEntretienById($_GET['id']);
}

if (isset($_POST['update']) && $entretien) {
    $statut = isset($_POST['statut']) ? 'soumis' : 'non soumis'; // Détermine le statut
    $EntretienC->modifierEntretien($_POST['id_entretien'], new Entretien($_POST['id_vehicule'], $_POST['date'], $_POST['type_intervention'], $statut));
    $EntretienC->ajouterHistorique('update', $_POST['id_vehicule'], $_POST['type_intervention']);
    header('Location: listeentretiens.php');
    exit();
}

// Gestion de la suppression
if (isset($_GET['delete'])) {
    $idToDelete = $_GET['delete'];
    $EntretienC->supprimerEntretien($idToDelete);
    header('Location: listeentretiens.php'); // Redirigez vers la même page pour mettre à jour le tableau
    exit();
}

// Appel de la méthode pour lister les entretiens
$searchId = '';
$entretiens = []; 

if (isset($_POST['search_btn'])) {
    $searchId = $_POST['search_id'] ?? '';
    $entretiens = $EntretienC->rechercherEntretienParId($searchId);
} else {
    $entretiens = $EntretienC->listeentretiens(); 
}

// Vérifiez si le tri par date est demandé
if (isset($_POST['sort_date'])) {
    usort($entretiens, function($a, $b) {
        return strtotime($b['Date']) - strtotime($a['Date']); // Tri décroissant par date
    });
}

$vehicule_id = isset($_GET['vehicule_id']) ? trim($_GET['vehicule_id']) : '';
$historique = [];

if (!empty($vehicule_id)) {
    $historique = $EntretienC->rechercherHistoriqueParIdVehicule($vehicule_id);
}

// Statistiques
$statistiquesSoumises = $EntretienC->getStatistiquesSoumisPourTousVehicules(); // Récupération des statistiques
?>

<!DOCTYPE html>
<html lang="fr">

<?php require_once '../includes/header.php'; ?>

<style>
    /* Styles ici */
    /* ... */
</style>

<body>
    <div class="wrapper">
        <?php require_once '../includes/configurator.php'; ?>
        <?php require_once '../includes/sidenav.php'; ?>

        <div class="main-panel">
            <?php require_once '../includes/navbar.php'; ?>

            <div class="content">
                <div class="container-fluid">
                    <div class="row justify-content-center">

                        <!-- Formulaire de modification -->
                        <div class="col-md-12"> 
                            <div class="card">
                                <div class="card-header">
                                    <div class="add-icon">
                                        <i class="fas fa-pencil-alt"></i> 
                                    </div>
                                    <h3 class="card-title mb-0">Modify A Maintenance</h3>
                                </div>
                                <div class="card-body">
                                    <form method="post" class="form-ajout"> 
                                        <input type="hidden" name="id_entretien" value="<?= htmlspecialchars($entretien['id_entretien'] ?? '') ?>">

                                        <div class="form-group-row">
                                            <label class="form-label" for="id_vehicule">Vehicle ID *</label>
                                            <input type="number" id="id_vehicule" name="id_vehicule" class="form-control" 
                                                value="<?= htmlspecialchars($entretien['id_vehicule'] ?? '') ?>">
                                        </div>

                                        <div class="form-group-row">
                                            <label class="form-label" for="date">Date *</label>
                                            <input type="date" id="date" name="date" class="form-control" 
                                                value="<?= htmlspecialchars($entretien['Date'] ?? '') ?>">
                                        </div>

                                        <div class="form-group-row">
                                            <label class="form-label" for="type_intervention">Type of Intervention *</label>
                                            <input type="text" id="type_intervention" name="type_intervention" class="form-control" 
                                                onkeypress="validateInput(event)" value="<?= htmlspecialchars($entretien['Type_intervention'] ?? '') ?>" required>
                                            <div id="typeError" style="color: red;"></div>
                                        </div>

                                        <div class="form-group-row">
                                            <label class="form-label">Statut *</label>
                                            <div>
                                                <input type="checkbox" id="statut" name="statut" <?= (isset($entretien['statut']) && $entretien['statut'] === 'soumis') ? 'checked' : '' ?>>
                                                <label for="statut">Submiteed</label>
                                            </div>
                                        </div>

                                        <div class="text-center mt-4">
                                            <button type="submit" name="update" class="btn btn-unigreen btn-lg">
                                                <i class="fas fa-pencil-alt"></i> Modify
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Formulaire de recherche -->
                        <div class="col-md-8">
                            <div class="form-container">
                                <form method="post" class="input-group" style="display: flex; align-items: center;">
                                    <input type="text" id="search_id" name="search_id" class="form-control" 
                                        placeholder="Entrez l'ID véhicule" value="<?= htmlspecialchars($searchId ?? '') ?>" 
                                        style="flex: 1; margin-right: 10px;" 
                                        onkeypress="validateNumericInput(event)" required>
                                    <button type="submit" name="search_btn" class="btn btn-unigreen">
                                        <i class="fas fa-search"></i> Search By <br>Vehicle ID
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Liste des entretiens -->
                        <div class="col-md-12"> 
                            <div class="card-liste">
                                <div class="card-header-liste">
                                    <h3 class="card-title mb-0">List of Maintenance</h3>
                                    <div>
                                        <form method="post" style="display:inline;">
                                            <button type="submit" name="sort_date" class="btn btn-unigreen">
                                                <i class="fas fa-sort-amount-down"></i> Sort by Date (Descending)
                                            </button>
                                        </form>
                                        <a href="statisques.php" class="btn btn-unigreen">
                                            <i class="fas fa-chart-pie"></i> Statistics
                                        </a>
                                        <a href="historique.php" class="btn btn-unigreen">
                                            <i class="fas fa-history"></i> Historic
                                        </a>
                                        <a href="listeentretiens.php" class="btn btn-unigreen">
                                            <i class="fas fa-sync-alt"></i> Refresh
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-hover table-bordered text-center">
                                        <thead class="table-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Vehicle ID</th>
                                                <th>Date</th>
                                                <th>Type of Intervention</th>
                                                <th>Statut</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($entretiens as $ent): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($ent['id_entretien']) ?></td>
                                                    <td><?= htmlspecialchars($ent['id_vehicule']) ?></td>
                                                    <td><?= htmlspecialchars(date('Y-m-d', strtotime($ent['Date']))) ?></td>
                                                    <td><?= htmlspecialchars($ent['Type_intervention']) ?></td>
                                                    <td><?= htmlspecialchars($ent['statut']) ?></td>
                                                    <td>
                                                        <a href="listeentretiens.php?id=<?= htmlspecialchars($ent['id_entretien']) ?>" class="btn btn-warning btn-sm">✏️</a>
                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmDeleteModal" data-id="<?= htmlspecialchars($ent['id_entretien']) ?>">
                                                            🗑️
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <?php require_once '../includes/footer.php'; ?>
        </div>

        <!-- Modal de confirmation de suppression -->
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">Deletion confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    Are you sure you want to delete this maintenance?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        <a href="#" class="btn btn-danger" id="confirmDeleteBtn">Yes</a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var confirmDeleteModal = document.getElementById('confirmDeleteModal');
                var confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

                $('#confirmDeleteModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var id = button.data('id'); 
                    confirmDeleteBtn.href = "listeentretiens.php?delete=" + id;
                });
            });

            function validateInput(event) {
                const char = String.fromCharCode(event.which);
                const isValid = /^[a-zA-Z\s]*$/.test(char); // Allow letters and spaces
                const typeError = document.getElementById('typeError');

                if (!isValid) {
                    typeError.textContent = 'Please enter only characters.';
                    event.preventDefault(); 
                } else {
                    typeError.textContent = ''; 
                }
            }

            function validateNumericInput(event) {
                const char = String.fromCharCode(event.which);
                const isValid = /^[0-9]*$/.test(char); // Allow only digits (0-9)

                if (!isValid) {
                    event.preventDefault(); // Prevent the input of non-numeric characters
                    alert('Please enter numbers only.'); // Show alert message
                }
            }
        </script>

    </div>
</body>

</html>