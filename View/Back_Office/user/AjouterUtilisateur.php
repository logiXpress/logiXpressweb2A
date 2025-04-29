<?php
require_once '../../../Controller/UtilisateurC.php';
require_once '../../../Model/Utilisateur.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $motDePasse = $_POST['motDePasse'];
    $type = $_POST['type'];

    // Traitement de l'image
    $profilePicture = null;
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $profilePicture = file_get_contents($_FILES['profile_picture']['tmp_name']);
    }

    // Créer l'objet Utilisateur en incluant l'image
    $utilisateur = new Utilisateur($nom, $prenom, $email, $motDePasse, $type, $profilePicture);

    $uc = new UtilisateurC();
    $uc->ajouterUtilisateur($utilisateur);

    header('Location: listeUtilisateurs.php');
    exit();
} else {
    echo "Requête invalide.";
}
?>

