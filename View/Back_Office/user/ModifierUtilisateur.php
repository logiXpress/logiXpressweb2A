<?php
require_once '../../../Controller/UtilisateurC.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID utilisateur manquant !");
}

$uc = new UtilisateurC();
$utilisateurData = $uc->getUtilisateur($id);

if (!$utilisateurData) {
    die("Utilisateur non trouvé !");
}

$utilisateur = new Utilisateur(
    $utilisateurData['Nom'],
    $utilisateurData['Prénom'],
    $utilisateurData['Email'],
    $utilisateurData['Mot_de_passe'],
    $utilisateurData['Type'],
    $utilisateurData['id_utilisateur']
);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Utilisateur</title>
</head>
<body>
    <h2>Modifier Utilisateur</h2>
    <form action="updateUtilisateur.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($utilisateur->getId()) ?>">
        <input type="text" name="nom" value="<?= htmlspecialchars($utilisateur->getNom()) ?>" required>
        <input type="text" name="prenom" value="<?= htmlspecialchars($utilisateur->getPrenom()) ?>" required>
        <input type="email" name="email" value="<?= htmlspecialchars($utilisateur->getEmail()) ?>" required>
        <input type="text" name="motDePasse" value="<?= htmlspecialchars($utilisateur->getMotDePasse()) ?>" required>

        <select name="type">
            <option value="Client" <?= $utilisateur->getType() == 'Client' ? 'selected' : '' ?>>Client</option>
            <option value="Livreur" <?= $utilisateur->getType() == 'Livreur' ? 'selected' : '' ?>>Livreur</option>
            <option value="Admin" <?= $utilisateur->getType() == 'Admin' ? 'selected' : '' ?>>Admin</option>
        </select>
        <input type="submit" value="Modifier">
    </form>
</body>
</html>
