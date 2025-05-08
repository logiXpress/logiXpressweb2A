<?php
require_once 'C:/Users/Desktop/PHP/htdocs/Project/Controller/EntretienC.php';

$entretienC = new EntretienC();
$vehicule_id = null;
$historique = [];

// Vérifiez si une recherche a été faite
if (!empty($_GET['vehicule_id'])) {
    $vehicule_id = trim($_GET['vehicule_id']);
    $historique = $entretienC->rechercherHistoriqueParIdVehicule($vehicule_id);
} else {
    $historique = $entretienC->getHistorique();
}

if (is_array($historique)) {
    usort($historique, function ($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });
}

$statistiquesSoumises = $entretienC->getHistoriqueSoumis();
?>

<!DOCTYPE html>
<html lang="fr">
<?php require_once '../includes/header.php'; ?>

<style>
    .book-page {
        background: #fff;
        margin: 50px auto;
        padding: 40px;
        width: 80%;
        max-width: 800px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        font-family: 'Georgia', serif;
    }

    .book-page h2 {
        font-size: 28px;
        margin-bottom: 20px;
        border-bottom: 2px solid #ddd;
        padding-bottom: 10px;
    }

    .book-page p {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .divider {
        height: 50px;
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
                    <h1 class="text-center mb-5">📖 Maintenances History</h1>

                    <!-- Formulaire de recherche -->
                    <form id="searchForm" method="GET" action="" class="mb-4">
                        <div class="mb-3">
                            <label for="vehicule_id" class="form-label">Vehicle ID:</label>
                            <input type="text" class="form-control" id="vehicule_id" name="vehicule_id">
                            <small id="vehicule_id_error" style="color:red; display:none;">Please enter only numbers.</small>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-unigreen" style="background-color:rgb(46, 204, 113); border-color:rgb(154, 63, 172); font-weight: bold;">
                                <i class="fas fa-search"></i> Search By <br>Vehicle ID
                            </button>
                            
                            <a href="historique.php" class="btn btn-unigreen" style="background-color:rgb(46, 204, 113); border-color:rgb(154, 63, 172); font-weight: bold;">
                                <i class="fas fa-sync-alt"></i> Refresh
                            </a>
                        </div>
                    </form>

                    <div id="historiqueContainer">
                        <?php if (empty($historique)): ?>
                            <div class="text-center">No Maintenance Found</div>
                        <?php else: ?>
                            <?php foreach ($historique as $log): ?>
                                <div class="book-page">
                                    <h2>Action: <?= htmlspecialchars($log['action']) ?> - Véhicule ID: <?= htmlspecialchars($log['vehicule_id']) ?></h2>
                                    <p><strong>Date:</strong> <?= htmlspecialchars($log['date']) ?></p>
                                    <p><strong>Détails:</strong> <?= htmlspecialchars($log['details']) ?></p>
                                </div>
                                <div class="divider"></div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php require_once '../includes/footer.php'; ?>
        </div>
    </div>

    <!-- Modal pour afficher les statistiques -->
    <div class="modal fade" id="statistiquesModal" tabindex="-1" role="dialog" aria-labelledby="statistiquesModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statistiquesModalLabel">Submitted Maintenance Statistics</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <canvas id="lineChartVehicule" width="600" height="400"></canvas>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Validation de l'ID véhicule
        document.getElementById('vehicule_id').addEventListener('input', function () {
            const input = this.value;
            const onlyDigits = input.replace(/[^0-9]/g, '');
            const errorMsg = document.getElementById('vehicule_id_error');

            if (input !== onlyDigits) {
                errorMsg.style.display = 'inline';
            } else {
                errorMsg.style.display = 'none';
            }

            this.value = onlyDigits;
        });

        // AJAX pour rechercher l'historique
        $('#searchForm').on('submit', function (e) {
            e.preventDefault(); // Empêche le rechargement de la page
            const vehiculeId = $('#vehicule_id').val();

            // Vérification si l'ID véhicule est valide
            if (!vehiculeId) {
                alert('Veuillez entrer un ID véhicule valide.');
                return;
            }

            $.ajax({
                url: 'recherche_historique.php', // Remplacez par le chemin de votre script d'API
                type: 'GET',
                data: { vehicule_id: vehiculeId },
                success: function (data) {
                    $('#historiqueContainer').html(data); // Met à jour le conteneur avec les nouvelles données
                },
                error: function () {
                    alert('Erreur lors de la récupération des données.');
                }
            });
        });

        // Récupérer les données des statistiques soumises
        const statisticsData = <?= json_encode($statistiquesSoumises) ?>;

        const parVehicule = {};
        statisticsData.forEach(log => {
            const vehiculeId = log.vehicule_id;
            const date = new Date(log.date).toLocaleDateString(); // Format de date
            if (!parVehicule[date]) {
                parVehicule[date] = {};
            }
            if (!parVehicule[date][vehiculeId]) {
                parVehicule[date][vehiculeId] = 0;
            }
            parVehicule[date][vehiculeId]++;
        });

        // Préparer les données pour le graphique
        const labels = Object.keys(parVehicule);
        const datasets = Object.keys(parVehicule[labels[0]]).map(vehiculeId => {
            return {
                label: `Véhicule ID: ${vehiculeId}`,
                data: labels.map(date => parVehicule[date][vehiculeId] || 0),
                borderColor: `hsl(${Math.random() * 360}, 70%, 50%)`,
                fill: false,
                tension: 0.1
            };
        });

        // Initialiser le graphique lorsque la modale est ouverte
        $('#statistiquesModal').on('shown.bs.modal', function () {
            const ctx = document.getElementById('lineChartVehicule').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Nombre d\'entretiens',
                                color: '#333',
                                font: {
                                    size: 16,
                                    weight: 'bold'
                                }
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Date',
                                color: '#333',
                                font: {
                                    size: 16,
                                    weight: 'bold'
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `Date: ${context.label}, Nombre: ${context.raw}`;
                                }
                            }
                        },
                        legend: {
                            display: true
                        }
                    },
                    animation: {
                        duration: 1200,
                        easing: 'easeOutBounce'
                    }
                }
            });
        });
    </script>
</body>
</html>