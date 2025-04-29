<?php
require_once '../../../Controller/UtilisateurC.php';
require_once '../../../Model/Utilisateur.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $motDePasse = $_POST['motDePasse'];
    $type = $_POST['type'];

    $utilisateur = new Utilisateur($nom, $prenom, $email, $motDePasse, $type);
    $uc = new UtilisateurC();
    $uc->ajouterUtilisateur($utilisateur);

    header('Location: listeUtilisateurs.php');
    exit();
} else {
    echo "Requête invalide.";
}
?>