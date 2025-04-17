<?php
include '../../../Controller/ReclamationC.php';
include '../../../Model/Reclamation.php';

session_start();

$pc = new ReclamationC();

if (
    isset($_POST['id_client'], $_POST['Categorie'], $_POST['Description']) &&
    !empty($_POST['id_client']) &&
    !empty(trim($_POST['Categorie'])) &&
    !empty(trim($_POST['Description']))
) {
    $idReclam = $_POST['id_reclamation'] ?? null;
    $reclamation = new Reclamation(
        $idReclam ? intval($idReclam) : null,
        intval($_POST['id_client']),
        htmlspecialchars(trim($_POST['Categorie'])),
        htmlspecialchars(trim($_POST['Description']))
    );

    if ($idReclam) {
        // modification
        $pc->updateReclamation($reclamation, intval($idReclam));
    } else {
        // ajout
        $pc->ajouterReclamation($reclamation);
    }

    $_SESSION['id_client'] = $_POST['id_client'];
    header('Location: claim.php');
    exit();
} else {
    echo "<p style='color: red;'>Erreur : Tous les champs sont requis.</p>";
}
?>
