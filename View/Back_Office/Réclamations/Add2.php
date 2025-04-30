<?php
session_start();
include '../../../Controller/ReponsesAdminC.php';
include '../../../Model/ReponsesAdmin.php';
require_once '../../../Controller/ReclamationC.php';

if (!isset($_SESSION['id_utilisateur'])) {
    die("<p style='color: red;'>Erreur : Admin non connecté.</p>");
}

if (isset($_POST['id_reclamation'], $_POST['Reponse']) &&
    !empty($_POST['id_reclamation']) &&
    !empty(trim($_POST['Reponse']))
) {
    $db = config::getConnexion();

    $id_admin = $_SESSION['id_utilisateur'];

    // Ajouter la réponse
    $rc = new ReponsesAdminC();
    $reponse = new ReponsesAdmin(
        null,
        intval($_POST['id_reclamation']),
        intval($id_admin),
        htmlspecialchars(trim($_POST['Reponse'])),
        date('Y-m-d H:i:s')
    );

    $rc->ajouterReponse($reponse);

    // 🟢 Mettre à jour le statut de la réclamation en "Resolved"
    $recC = new ReclamationC();
    $recC->changerStatut(intval($_POST['id_reclamation']), 'Resolved');

    header('Location: claims.php');
    exit();
} else {
    echo "<p style='color: red;'>Erreur : La réponse est requise.</p>";
}
?>
