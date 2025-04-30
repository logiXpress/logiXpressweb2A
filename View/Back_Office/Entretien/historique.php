<?php
require_once 'C:/Users/Desktop/PHP/htdocs/Project/Model/Entretien.php';
require_once 'C:/Users/Desktop/PHP/htdocs/Project/Controller/EntretienC.php';

$entretienC = new EntretienC();
$liste = $entretienC->afficherEntretien();

// Vérifiez si l'ID de véhicule a été soumis
$vehicule_id = null; // Initialiser la variable
if (isset($_GET['vehicule_id'])) {
    $vehicule_id = trim($_GET['vehicule_id']);
    $historique = $entretienC->rechercherHistoriqueParIdVehicule($vehicule_id);
} else {
    $historique = $entretienC->getHistorique();
}

// Tri par date décroissante
usort($historique, function ($a, $b) {
    return strtotime($b['date']) - strtotime($a['date']);
});
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
                    <form method="GET" action="" class="mb-4">
                        <div class="mb-3">
                            <label for="vehicule_id" class="form-label">ID Véhicule:</label>
                            <input type="text" class="form-control" id="vehicule_id" name="vehicule_id" required>
                        </div>
                        <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary" style="background-color:rgb(46, 204, 113); border-color:rgb(154, 63, 172); font-weight: bold;">
    Search By Vehicle ID
</button>
                            
<a href="historique.php" class="btn btn-unigreen" style="background-color:rgb(46, 204, 113); border-color:rgb(154, 63, 172); font-weight: bold;">
    <i class="fas fa-sync-alt"></i> Refresh
</a>

<a href="statistiques.php?vehicule_id=<?= htmlspecialchars($vehicule_id) ?>" class="btn btn-unigreen" style="background-color:rgb(46, 204, 113); border-color:rgb(154, 63, 172); font-weight: bold;">
    <i class="fas fa-chart-pie"></i> Statistics
</a>

                        </div>
                    </form>

                    <?php if (empty($historique)): ?>
                        <div class="text-center">No Maintenance Found</div>
                    <?php else: ?>
                        <?php foreach ($historique as $log): ?>
                            <?php if ($log['action'] === 'add' || $log['action'] === 'update'): ?>
                                <div class="book-page">
                                    <h2>Action: <?= htmlspecialchars($log['action']) ?> - Véhicule ID: <?= htmlspecialchars($log['vehicule_id']) ?></h2>
                                    <p><strong>Date:</strong> <?= htmlspecialchars($log['date']) ?></p>
                                    <p><strong>Détails:</strong> <?= htmlspecialchars($log['details']) ?></p>
                                </div>
                                <div class="divider"></div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <!-- Bouton Statistiques global (tous mois confondus) -->
                   

                </div>
            </div>

            <?php require_once '../includes/footer.php'; ?>
        </div>
    </div>
</body>
</html>
