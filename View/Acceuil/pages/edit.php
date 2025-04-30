<?php
include '../../../Controller/ReclamationC.php';
include '../../../Model/Reclamation.php';

$pc = new ReclamationC();
$reclamation = null;

if (isset($_GET['id_reclamation']) && !empty($_GET['id_reclamation'])) {
    $reclamation = $pc->getReclamationById(intval($_GET['id_reclamation']));
    if (!$reclamation) {
        die("<p style='color: red;'>Erreur : Réclamation introuvable.</p>");
    }
}

if (isset($_POST['update'])) {
    if (
        isset($_POST['id_client'], $_POST['Categorie'], $_POST['Description'], $_POST['Statut']) &&
        !empty($_POST['id_client']) &&
        !empty(trim($_POST['Categorie'])) &&
        !empty(trim($_POST['Description'])) &&
        !empty(trim($_POST['Statut']))
    ) {
        $p = new Reclamation(
            intval($_POST['id_reclamation']),
            intval($_POST['id_client']),
            htmlspecialchars(trim($_POST['Categorie'])),
            htmlspecialchars(trim($_POST['Description']))
        );
        $p->setStatut(htmlspecialchars(trim($_POST['Statut'])));
        $pc->updateReclamation($p, $_POST['id_reclamation']);
        header('Location: claim.php');
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
    <title>Modifier Réclamation</title>
</head>
<body>
<h1>Modifier une Réclamation</h1>

<?php if ($reclamation): ?>
    <form action="edit.php" method="POST">
        <input type="hidden" name="id_reclamation" value="<?= htmlspecialchars($reclamation['id_reclamation']); ?>">

        <label>ID Client :</label>
        <input type="number" name="id_client" value="<?= htmlspecialchars($reclamation['id_client']); ?>" required><br>

        <label>Catégorie :</label>
        <input type="text" name="Categorie" value="<?= htmlspecialchars($reclamation['Categorie']); ?>" required><br>

        <label>Description :</label>
        <textarea name="Description" required><?= htmlspecialchars($reclamation['Description']); ?></textarea><br>

        <label>Statut :</label>
        <input type="text" name="Statut" value="<?= htmlspecialchars($reclamation['Statut']); ?>" required><br>

        <label>Réponse (non modifiable) :</label>
        <textarea readonly><?= htmlspecialchars($reclamation['Reponse'] ?? "Pas encore de réponse"); ?></textarea><br>

        <input type="submit" name="update" value="Mettre à jour">
    </form>
<?php else: ?>
    <p>Erreur : Aucune réclamation trouvée.</p>
<?php endif; ?>

</body>
</html>
