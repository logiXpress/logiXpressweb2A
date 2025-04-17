<?php
include '../../../Controller/ReponsesAdminC.php';
include '../../../Model/ReponsesAdmin.php';

$pc = new ReponsesAdminC();
$reponse = null;

if (isset($_GET['id_reponse']) && !empty($_GET['id_reponse'])) {
    $reponse = $pc->getReponseById(intval($_GET['id_reponse']));
    if (!$reponse) {
        die("<p style='color: red;'>Erreur : Réponse introuvable.</p>");
    }
}

if (isset($_POST['update'])) {
    if (
        isset($_POST['id_reclamation'], $_POST['id_admin'], $_POST['Reponse'], $_POST['Date_reponse']) &&
        !empty($_POST['id_reclamation']) &&
        !empty($_POST['id_admin']) &&
        !empty(trim($_POST['Reponse'])) &&
        !empty(trim($_POST['Date_reponse']))
    ) {
        $p = new ReponsesAdmin(
            intval($_POST['id_reponse']),
            intval($_POST['id_reclamation']),
            intval($_POST['id_admin']),
            htmlspecialchars(trim($_POST['Reponse'])),
            htmlspecialchars(trim($_POST['Date_reponse']))
        );

        $pc->updateReponse($p, $_POST['id_reponse']);
        header('Location: ListeReponses.php');
        exit();
    } else {
        echo "<p style='color: red;'>Erreur : Tous les champs sont requis.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Réponse</title>
</head>
<body>
    <h1>Modifier une Réponse</h1>
    
    <?php if ($reponse): ?>
        <form action="edit2.php" method="POST">
            <input type="hidden" name="id_reponse" value="<?= htmlspecialchars($reponse['id_reponse']); ?>">

            <label>ID Réclamation :</label>
            <input type="number" name="id_reclamation" value="<?= htmlspecialchars($reponse['id_reclamation']); ?>" required><br>

            <label>ID Admin :</label>
            <input type="number" name="id_admin" value="<?= htmlspecialchars($reponse['id_admin']); ?>" required><br>

            <label>Réponse :</label>
            <textarea name="Reponse" required><?= htmlspecialchars($reponse['Reponse']); ?></textarea><br>

            <label>Date de réponse :</label>
            <input type="datetime-local" name="Date_reponse" value="<?= htmlspecialchars($reponse['Date_reponse']); ?>" required><br>

            <input type="submit" name="update" value="Mettre à jour">
        </form>
    <?php else: ?>
        <p>Erreur : Aucune réponse trouvée.</p>
    <?php endif; ?>

</body>
</html>
