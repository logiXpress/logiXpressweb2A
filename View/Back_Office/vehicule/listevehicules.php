<?php
require_once '../../../Model/Vehicule.php';
require_once '../../../Controller/VehiculeC.php';

$VehiculeC = new VehiculeC();

if (isset($_POST['add'])) {
    $VehiculeC->ajouterVehicule(new Vehicule($_POST['immatriculation'], $_POST['type'], $_POST['autonomie'], $_POST['statut']));
    header('Location: listevehicules.php');
    exit();
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($VehiculeC->supprimerVehicule($id)) {
        error_log("Véhicule avec ID $id supprimé avec succès.");
    } else {
        error_log("Échec de la suppression du véhicule avec ID $id.");
    }
    header('Location: listevehicules.php');
    exit();
}

$vehicule = null;
if (isset($_GET['id'])) {
    $vehicule = $VehiculeC->getVehiculeById($_GET['id']);
}

if (isset($_POST['update']) && $vehicule) {
    $VehiculeC->modifierVehicule($_POST['id_vehicule'], new Vehicule($_POST['immatriculation'], $_POST['type'], $_POST['autonomie'], $_POST['statut']));
    header('Location: listevehicules.php');
    exit();
}

$searchTerm = '';
if (isset($_POST['search_btn'])) {
    $searchTerm = $_POST['search'];
}

$vehicules = $VehiculeC->rechercherVehicule($searchTerm);
$statistiques = $VehiculeC->obtenirStatistiques();
?>

<!DOCTYPE html>
<html lang="fr">
<?php require_once '../includes/header.php'; ?>

<style>
    body {
        background-color: #f4f6f8;
        overflow-x: hidden;
    }

    .card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin: 20px auto;
        width: calc(100% - 40px);
        max-width: 100%;
    }

    .form-label {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .form-control {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        width: 100%;
    }

    .btn-unigreen {
        background-color: #2ecc71;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .btn-unigreen:hover {
        background-color: #27ae60;
    }

    .card-header {
        display: flex;
        align-items: center;
        background-color: #2ecc71;
        color: white;
        padding: 15px;
        border-radius: 10px;
        position: absolute;
        top: -35px;
        left: 2px;
        width: calc(100% - 10px);
    }

    .icon {
        background: #2ecc71;
        color: white;
        border-radius: 5px;
        padding: 20px;
        margin-right: 10px;
        margin-bottom: 15px;
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
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-unigreen card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">assignment</i>
                                    </div>
                                    <h1 class="mb-0 text-center">List Of Vehicules</h1>
                                </div>
                                <div class="card-body">
                                    <button id="showStatisticsBtn" class="btn btn-warning mb-1">
                                        <i class="material-icons">analytics</i>
                                    </button>
                                    <table id="datatablesSimple" class="table table-hover table-bordered text-center">
                                        <thead style="background-color: #2ecc71; color: white;">
                                            <tr>
                                                <th>ID</th>
                                                <th>Immatriculation</th>
                                                <th>Type</th>
                                                <th>Autonomie</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($vehicules as $veh): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($veh['id_vehicule']) ?></td>
                                                    <td><?= htmlspecialchars($veh['Immatriculation']) ?></td>
                                                    <td><?= htmlspecialchars($veh['Type']) ?></td>
                                                    <td><?= htmlspecialchars($veh['Autonomie']) ?> km</td>
                                                    <td><?= htmlspecialchars($veh['Statut']) ?></td>
                                                    <td>
                                                        <a href="listevehicules.php?id=<?= htmlspecialchars($veh['id_vehicule']) ?>" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modifierModal">✏️</a>
                                                        <a href="listevehicules.php?delete=<?= htmlspecialchars($veh['id_vehicule']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce véhicule ?');">🗑️</a>
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
        </div>

        <!-- Modal pour modifier un véhicule -->
        <div class="modal fade" id="modifierModal" tabindex="-1" aria-labelledby="modifierModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modifierModalLabel">Modifier un véhicule</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <input type="hidden" name="id_vehicule" value="<?= htmlspecialchars($vehicule['id_vehicule'] ?? '') ?>">
                            <div class="mb-3">
                                <label class="form-label" for="immatriculation">Immatriculation *</label>
                                <input type="text" id="immatriculation" name="immatriculation" class="form-control" required value="<?= htmlspecialchars($vehicule['Immatriculation'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="type">Type *</label>
                                <input type="text" id="type" name="type" class="form-control" required value="<?= htmlspecialchars($vehicule['Type'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="autonomie">Autonomie (km) *</label>
                                <input type="number" id="autonomie" name="autonomie" class="form-control" required value="<?= htmlspecialchars($vehicule['Autonomie'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="statut">Statut *</label>
                                <select class="form-control" name="statut" id="statut">
                                    <option value="In Maintenance" <?= (isset($vehicule['Statut']) && $vehicule['Statut'] === 'In Maintenance') ? 'selected' : '' ?>>In Maintenance</option>
                                    <option value="In Service" <?= (isset($vehicule['Statut']) && $vehicule['Statut'] === 'In Service') ? 'selected' : '' ?>>In Service</option>
                                    <option value="Available" <?= (isset($vehicule['Statut']) && $vehicule['Statut'] === 'Available') ? 'selected' : '' ?>>Available</option>
                                </select>
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" name="update" class="btn btn-sm btn-unigreen">Modifier</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modale pour les statistiques -->
        <div class="modal fade" id="statisticsModal" tabindex="-1" role="dialog" aria-labelledby="statisticsModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="statisticsModalLabel">Vehicules Statistics</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <canvas id="statistiquesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        new DataTable('#datatablesSimple');
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.getElementById('showStatisticsBtn').addEventListener('click', function() {
            const statistiques = <?= json_encode($statistiques) ?>;
            const ctx = document.getElementById('statistiquesChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: Object.keys(statistiques),
                    datasets: [{
                        label: 'Vehicules Status',
                        data: Object.values(statistiques),
                        backgroundColor: ['#2ecc71', '#f39c12', '#e74c3c'],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Distribution of Vehicles by Status'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    const total = tooltipItem.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((tooltipItem.raw / total) * 100).toFixed(2);
                                    return `${tooltipItem.label}: ${tooltipItem.raw} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
            $('#statisticsModal').modal('show');
        });
    </script>

    <?php if ($vehicule): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modifierModal = new bootstrap.Modal(document.getElementById('modifierModal'));
                modifierModal.show();
            });
        </script>
    <?php endif; ?>
</body>
<?php require_once '../includes/footer.php'; ?>

</html>