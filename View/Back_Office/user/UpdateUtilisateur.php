<?php
require_once '../Controller/UtilisateurC.php';
require_once '../Model/Utilisateur.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user data from the POST request
    $id = (int)$_POST['id'];  // User ID from POST request
    $nom = $_POST['nom'];  // User's last name
    $prenom = $_POST['prenom'];  // User's first name
    $email = $_POST['email'];  // User's email
    $mot_de_passe = $_POST['motDePasse'];  // User's password
    $type = $_POST['type'];  // New type of the user (Client, Livreur, Admin)

    // Ensure that the MotDePasse key is defined
    if (!isset($mot_de_passe)) {
        echo "Mot de passe manquant!";
        exit();
    }

    // Create an instance of the Utilisateur class and pass all required parameters
    $utilisateur = new Utilisateur($nom, $prenom, $email, $mot_de_passe, $type, $id);

    // Create an instance of UtilisateurC
    $uc = new UtilisateurC();

    try {
        // Use the public getPDO() method to access the PDO instance
        $pdo = $uc->getPDO();

        // Call the updateUserType method with the PDO instance, user ID, and the updated utilisateur object
        $uc->updateUserType($id, $utilisateur);

        // Redirect to the user list page after a successful update
        header('Location: listeUtilisateurs.php');
        exit();
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage(); // Handle errors if any
    }
} else {
    echo "Requête invalide !";
}
?>
