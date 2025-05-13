<?php
require_once 'C:/Users/Desktop/PHP/htdocs/Project/Controller/EntretienC.php';

$entretienC = new EntretienC();
$entretiensSoumis = $entretienC->getEntretiensSoumis(); // Nouvelle méthode sur table entretiens

// Compter les entretiens soumis par véhicule
$statsByVehicle = [];
foreach ($entretiensSoumis as $entry) {
    $vehiculeId = $entry['id_vehicule'];
    if (!isset($statsByVehicle[$vehiculeId])) {
        $statsByVehicle[$vehiculeId] = 0;
    }
    $statsByVehicle[$vehiculeId]++;
}

$vehicleIds = array_keys($statsByVehicle);
$submissionCounts = array_values($statsByVehicle);

// Define a specific set of distinct colors
$colors = [
    '#FF5733', // Bright Red
    '#33FF57', // Bright Green
    '#3357FF', // Bright Blue
    '#FF33A1', // Bright Pink
    '#FFDA33', // Bright Yellow
    '#33FFF1', // Bright Cyan
    '#FF8D33', // Bright Coral
    '#DA33FF', // Bright Purple
    '#FF8D33', // Bright Orange
    '#33FF8D'  // Bright Mint
];

// Limit colors to the number of vehicle IDs
$colors = array_slice($colors, 0, count($vehicleIds));
?>

<!DOCTYPE html>
<html lang="fr">

<?php require_once '../includes/header.php'; ?>

<body>
<div class="wrapper">
    <?php require_once '../includes/configurator.php'; ?>
    <?php require_once '../includes/sidenav.php'; ?>

    <div class="main-panel">
        <?php require_once '../includes/navbar.php'; ?>

        <div class="content">
            <div class="container-fluid">
                <h2 class="text-center mb-5">Nombre d'entretiens soumis par ID véhicule</h2>
                <canvas id="submissionChart" style="max-width: 900px; max-height: 700px; margin: 0 auto;"></canvas>
               
                <a href="listeentretiens.php" class="btn btn-unigreen mt-4">⬅ Retour à la liste</a>
            </div>
        </div>

        <?php require_once '../includes/footer.php'; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const vehicleIds = <?= json_encode($vehicleIds) ?>;
    const submissionCounts = <?= json_encode($submissionCounts) ?>;
    const colors = <?= json_encode($colors) ?>;

    const ctx = document.getElementById('submissionChart').getContext('2d');
    const submissionChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: vehicleIds.map(id => "Véhicule " + id),
            datasets: [{
                label: 'Entretiens soumis',
                data: submissionCounts,
                backgroundColor: colors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.label} : ${context.raw} soumis`;
                        }
                    }
                }
            }
        }
    });
</script>
</body>
</html>