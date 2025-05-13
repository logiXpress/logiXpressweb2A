<?php
require_once '../../../Model/Entretien.php';
require_once '../../../Controller/EntretienC.php';

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
    usort($entretiens, function ($a, $b) {
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
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


<style>
    .card-header {
        display: flex;
        align-items: center;
        background-color: #2ecc71;
        /* Unigreen color */
        color: white;
        padding: 15px;
        border-radius: 10px;
        /* Rounded edges for the header */
        position: absolute;
        top: -35px;
        left: 2px;
        width: calc(100% - 10px);
        /* To fit with the card width */
    }

    .icon {
        background: #2ecc71;
        /* Unigreen color */
        color: white;
        border-radius: 5px;
        /* Now it's rectangular */
        padding: 20px;
        margin-right: 10px;
        margin-bottom: 15px;
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

    body {
        font-family: 'Poppins', sans-serif;
    }

    table.dataTable {
        font-size: 15px;
        font-weight: 400;
    }

    table.dataTable thead {
        background-color: #2ecc71;
        color: white;
        font-weight: 600;
        font-size: 16px;
    }

    table.dataTable tbody td {
        vertical-align: middle;
        padding: 12px 10px;
    }

    table.dataTable tbody tr:hover {
        background-color: #f9f9f9;
        cursor: pointer;
    }

    .btn-sm i {
        margin-right: 5px;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background:rgb(255, 225, 248) !important; /* Your unigreen */
    color: white !important;
    border: 1px solid transparent;
    border-radius: 5px;
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

                    <div class="row">
                        <!-- Maintenance List -->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-unigreen card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">build</i>
                                    </div>

                                </div>
                                <h1 class="mb-0 text-center">List of Maintenance</h1>
                                <div class="card-body">
                                    <div class="d-flex justify-content-end mb-3">
                                        <a href="statisques.php" class="btn btn-warning me-2">
                                            <i class="material-icons">analytics</i>
                                        </a>
                                        <a href="historique.php" class="btn btn-info">
                                            <i class="material-icons">history</i>
                                        </a>
                                    </div>

                                    <table class="table table-hover table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Vehicle ID</th>
                                                <th>Date</th>
                                                <th>Type</th>
                                                <th>Status</th>
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
                                                        <a href="listeentretiens.php?id=<?= $ent['id_entretien'] ?>" class="btn btn-warning btn-sm">✏️</a>
                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmDeleteModal" data-id="<?= $ent['id_entretien'] ?>">🗑️</button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card">

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
                                            <button type="submit" name="update" class="btn btn-warning btn-lg">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                        </div>
                                    </form>
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
        <!-- jQuery (Required by DataTables) -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.table').DataTable({
                    "language": {
                        "search": "Search:",
                        "lengthMenu": "Display _MENU_ entries per page",
                        "zeroRecords": "No matching records found",
                        "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                        "infoEmpty": "No entries available",
                        "infoFiltered": "(filtered from _MAX_ total entries)",
                        "paginate": {
                            "first": "First",
                            "last": "Last",
                            "next": "Next",
                            "previous": "Previous"
                        }
                    },
                    "pageLength": 10 // Default entries per page
                });
            });
        </script>

    </div>
</body>

</html>