<?php
include '../Controller/UtilisateurC.php';

// Initialize the controller
$uc = new UtilisateurC();

// Handle adding a new user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect data from the form
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $motDePasse = $_POST['motDePasse'];
    $type = $_POST['type'];

    // Create the utilisateur object
    $utilisateur = new Utilisateur($nom, $prenom, $email, $motDePasse, $type);

    // Call the function to add the user
    $uc->ajouterUtilisateur($utilisateur);

    // Redirect to the current page to update the list
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch all users
$utilisateurs = $uc->getAllUtilisateurs();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Utilisateurs</title>
</head>
<body>
    <h2>Liste des Utilisateurs</h2>
    
    <!-- Form to Add New User -->
    <h3>Ajouter un Nouvel Utilisateur</h3>
    <form method="POST" action="">
        <label for="nom">Nom: </label><br>
        <input type="text" id="nom" name="nom" required><br><br>

        <label for="prenom">Prénom: </label><br>
        <input type="text" id="prenom" name="prenom" required><br><br>

        <label for="email">Email: </label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="motDePasse">Mot de Passe: </label><br>
        <input type="password" id="motDePasse" name="motDePasse" required><br><br>

        <label for="type">Type: </label><br>
        <select name="type" id="type" required>
            <option value="Client">Client</option>
            <option value="Livreur">Livreur</option>
            <option value="Admin">Admin</option>
        </select><br><br>

        <button type="submit">Ajouter l'Utilisateur</button>
    </form>

    <br>

    <!-- Display List of Users -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Mot De Passe</th>
            <th>Type</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($utilisateurs as $utilisateur): ?>
        <tr>
            <td><?= $utilisateur['id_utilisateur'] ?></td>
            <td><?= $utilisateur['Nom'] ?></td>
            <td><?= $utilisateur['Prénom'] ?></td>
            <td><?= $utilisateur['Email'] ?></td>
            <td><?= $utilisateur['Mot_de_passe'] ?></td>
            <td><?= $utilisateur['Type'] ?></td>
            <td>
                <a href="ModifierUtilisateur.php?id=<?= $utilisateur['id_utilisateur'] ?>">Modifier</a>
                <a href="SupprimerUtilisateur.php?id=<?= $utilisateur['id_utilisateur'] ?>" onclick="return confirm('Êtes-vous sûr ?');">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
