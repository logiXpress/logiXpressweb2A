<?php
// Include the required files
require_once '../../../config/config.php';
include_once '../../../Model/Utilisateur.php';
include_once '../../../Controller/UtilisateurC.php';

// Initialize the controller
$utilisateurC = new UtilisateurC();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $motDePasse = $_POST['mot_de_passe']; // Get the password from the form
    $type = $_POST['type']; // Get the user type from the form
    $phone_number = $_POST['phone_number']; // Get the user type from the form

    // Validate form inputs (for simplicity, just checking empty fields)
    if (empty($nom) || empty($prenom) || empty($email) || empty($motDePasse) || empty($type) || empty($phone_number)) {
        echo "Please fill in all the fields.";
        exit;
    }

    // Create a new Utilisateur object
    $utilisateur = new Utilisateur($nom, $prenom, $email, $motDePasse, $type, $phone_number);

    // Add the user to the database using the controller
    try {
        $utilisateurC->ajouterUtilisateur($utilisateur);
        echo "User registered successfully!";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
