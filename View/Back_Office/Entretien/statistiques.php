<?php
require_once 'C:/Users/Desktop/PHP/htdocs/Project/Controller/EntretienC.php';
$entretienC = new EntretienC();
$liste = $entretienC->afficherEntretien(); // Tous les entretiens

// Répartition par mois
$parMois = [];
foreach ($liste as $entretien) {
    $mois = date('F', strtotime($entretien['Date'])); // Exemple : "April"
    if (!isset($parMois[$mois])) {
        $parMois[$mois] = 0;
    }
    $parMois[$mois]++;
}

// Répartition par véhicule

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Maintenances Statistics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            width: 80%;
            margin: auto;
            text-align: center;
        }
        canvas {
            margin: 40px auto;
        }
    </style>
</head>
<body>

    <h1 class="text-center">📊 Maintenances Statistics</h1>

    <div class="chart-container">
        <h2>Monthly Distribution of Maintenances</h2>
        <canvas id="pieChartMois" width="400" height="400"></canvas>
    </div>

   

    <script>
        // Camembert par mois
        const dataMois = {
            labels: <?= json_encode(array_keys($parMois)) ?>,
            datasets: [{
                label: 'Entretiens par mois',
                data: <?= json_encode(array_values($parMois)) ?>,
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                    '#9966FF', '#FF9F40', '#C9CBCF', '#FF6384',
                    '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'
                ]
            }]
        };
        new Chart(document.getElementById('pieChartMois'), {
            type: 'pie',
            data: dataMois
        });

        // Camembert par véhicule
       
    </script>

</body>
</html>
