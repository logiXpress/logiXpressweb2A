<?php
session_start();
require '../../../Controller/MessagesReclamationC.php';
$controller = new MessagesReclamationC();

$idUtilisateur = $_SESSION['id_utilisateur']; // récupéré du login
$idReclamation = $_POST['id_reclamation'];
$contenu = $_POST['contenu'];

$controller->ajouterMessage($idReclamation, $idUtilisateur, $contenu);
header('Location: load_thread.php?id_reclamation=' . $idReclamation);
exit;
?>