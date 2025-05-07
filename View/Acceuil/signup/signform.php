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
    $motDePasse = $_POST['mot_de_passe']; 
    $type = $_POST['type']; 
    $phone_number = $_POST['phone_number']; 

    // Handle profile picture upload
    $profile_picture;
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $profile_picture = file_get_contents($_FILES['profile_picture']['tmp_name']);
    }

    // Validate form inputs
    if (empty($nom) || empty($prenom) || empty($email) || empty($motDePasse) || empty($type) || empty($phone_number)) {
        echo "Please fill in all the fields.";
        exit;
    }

    // Create a new Utilisateur object
    $utilisateur = new Utilisateur($nom, $prenom, $email, $motDePasse, $type, $phone_number, $profile_picture);
    header("Location: ../signin/basic.php"); // Replace with the actual sign-in page URL

    // Add the user to the database using the controller
    try {
        $utilisateurC->ajouterUtilisateur($utilisateur);
        echo "User registered successfully!";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
