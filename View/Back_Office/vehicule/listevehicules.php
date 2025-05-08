<?php
require_once 'C:/Users/Desktop/PHP/htdocs/Project/Model/Vehicule.php';
require_once 'C:/Users/Desktop/PHP/htdocs/Project/Controller/VehiculeC.php';

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

// Tri par autonomie décroissante
if (isset($_POST['sort_autonomie'])) {
    usort($vehicules, function($a, $b) {
        return $b['Autonomie'] <=> $a['Autonomie'];
    });
}

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
    .content-container {
        margin-top: 50px;
    }
    .btn-sm {
        padding: 5px 10px;
        font-size: 0.9em;
    }
</style>

<body>
    <div class="wrapper">
        <?php require_once '../includes/configurator.php'; ?>
        <?php require_once '../includes/sidenav.php'; ?>

        <div class="main-panel">
            <?php require_once '../includes/navbar.php'; ?>
            <div class="container-fluid content-container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title mb-0">List of vehicles</h3>
                            </div>
                            <div class="card-body">
                                <form method="post" class="input-group mb-3">
                                    <input type="text" id="search" name="search" class="form-control" placeholder="Entrez l'immatriculation" value="<?= htmlspecialchars($searchTerm) ?>" oninput="limitInput(this)" onblur="validateSearch()">
                                    
                                    <button type="submit" name="search_btn" class="btn btn-unigreen btn-sm" style="margin-left: 10px;">
                                        <i class="fas fa-search"></i> Search by immatriculation
                                    </button>
                                    <small id="searchError" class="text-danger"></small>
                                </form>

                                <div class="d-flex align-items-center">
                                    <button id="showStatisticsBtn" class="btn btn-unigreen btn-sm" style="margin-right: 10px;">
                                        <i class="fas fa-chart-bar"></i> Statistics
                                    </button>
                                    <button id="refreshBtn" class="btn btn-unigreen btn-sm">
                                        <i class="fas fa-sync-alt"></i> Refresh
                                    </button>
                                </div>

                                <form method="post" class="mb-3">
                                    <button type="submit" name="sort_autonomie" class="btn btn-unigreen btn-sm" style="margin-top: 10px;">
                                        <i class="fas fa-sort-amount-down"></i> Sort by autonomy (descending)
                                    </button>
                                </form>

                                <table class="table table-hover table-bordered text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Immatriculation</th>
                                            <th>Type</th>
                                            <th>Autonomie</th>
                                            <th>Statut</th>
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
                                                    <a href="listevehicules.php?id=<?= htmlspecialchars($veh['id_vehicule']) ?>" class="btn btn-warning btn-sm">✏️</a>
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

            <!-- Modale pour les statistiques -->
            <div class="modal fade" id="statisticsModal" tabindex="-1" role="dialog" aria-labelledby="statisticsModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="statisticsModalLabel">Vehicle Statistics</h5>
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

            <?php require_once '../includes/footer.php'; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function limitInput(input) {
            let value = input.value;
            value = value.replace(/[^0-9TUNIS ]/gi, '');
            if (!value.includes('TUNIS')) {
                value = value.replace(/[^0-9]/g, '');
                if (value.length > 3) {
                    value = value.substring(0, 3);
                }
                if (value.length === 3) {
                    value += ' TUNIS ';
                }
            } else {
                let parts = value.split('TUNIS');
                let before = parts[0].replace(/[^0-9]/g, '').substring(0, 3);
                let after = (parts[1] || '').replace(/[^0-9]/g, '').substring(0, 4);
                value = before + ' TUNIS ' + after;
            }
            input.value = value;
        }

        function validateForm() {
            const registrationInput = document.getElementById('immatriculation').value.trim();
            const regexRegistration = /^[0-9]{3} TUNIS [0-9]{4}$/;

            if (!regexRegistration.test(registrationInput)) {
                document.getElementById('immatriculationError').textContent = 'Format invalide. Ex: 123 TUNIS 4567';
                return false;
            }

            document.getElementById('immatriculationError').textContent = '';
            return true;
        }

        function validateSearch() {
            const searchInput = document.getElementById('search').value.trim();
            const regexRegistration = /^[0-9]{3} TUNIS [0-9]{4}$/;

            if (!regexRegistration.test(searchInput)) {
                document.getElementById('searchError').textContent = 'Format invalide. Ex: 123 TUNIS 4567';
                return false;
            }

            document.getElementById('searchError').textContent = '';
            return true;
        }

        function isLetter(event) {
            const char = String.fromCharCode(event.which);
            const isValid = /^[a-zA-Z\s]$/.test(char);
            const typeError = document.getElementById('typeError');

            if (!isValid) {
                typeError.textContent = 'Veuillez entrer des caractères uniquement.';
                event.preventDefault();
                return false;
            } else {
                typeError.textContent = '';
            }

            return true;
        }

        document.querySelector('form').addEventListener('submit', function(e) {
            if (!validateForm() || !validateSearch() || !validateType()) {
                e.preventDefault();
            }
        });

        function validateType() {
            const typeInput = document.getElementById('type').value.trim();
            const regexType = /^[a-zA-Z\s]*$/;

            if (!regexType.test(typeInput)) {
                document.getElementById('typeError').textContent = 'Veuillez entrer des caractères uniquement.';
                return false;
            }

            document.getElementById('typeError').textContent = '';
            return true;
        }

        // Ouvrir la modale et afficher le graphique
        document.getElementById('showStatisticsBtn').addEventListener('click', function () {
            const statistiques = <?= json_encode($statistiques) ?>;
            
            const ctx = document.getElementById('statistiquesChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['In Maintenance', 'In Service', 'Available'],
                    datasets: [{
                        label: 'Nombre de Véhicules',
                        data: [
                            statistiques['In Maintenance'] || 0,
                            statistiques['In Service'] || 0,
                            statistiques['Available'] || 0
                        ],
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
                            text: 'Répartition des Véhicules par Statut'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Nombre de Véhicules'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Statut'
                            }
                        }
                    }
                }
            });
            
            $('#statisticsModal').modal('show');
        });

        // Refresh button functionality
        document.getElementById('refreshBtn').addEventListener('click', function() {
            location.reload(); // Reload the current page
        });
    </script>
</body>
</html>