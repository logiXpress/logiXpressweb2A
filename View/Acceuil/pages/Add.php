<?php
session_start();
include '../../../Controller/ReclamationC.php';
include '../../../Model/Reclamation.php';

$pc = new ReclamationC();
function contains_profanity($text) {
    $api_key = "673a0cb62e1c472928f0e8e0f0a77b7a";
    $encoded_text = urlencode($text);
    $url = "https://api1.webpurify.com/services/rest/?method=webpurify.live.check&api_key=$api_key&text=$encoded_text&lang=fr&format=json";

    $response = @file_get_contents($url); // utiliser @ pour éviter warnings
    if ($response === FALSE) {
        echo "<p style='color: red;'>Erreur : Impossible de vérifier le contenu (problème API).</p>";
        exit();
    }

    $data = json_decode($response, true);
    return $data['rsp']['found'] != "0";
}


if (
    isset($_SESSION['id_client'], $_POST['Categorie'], $_POST['Description']) &&
    !empty(trim($_POST['Categorie'])) &&
    !empty(trim($_POST['Description']))
) {
    $id_client = intval($_SESSION['id_client']);
    $idReclam = $_POST['id_reclamation'] ?? null;

    $reclamation = new Reclamation(
        $idReclam ? intval($idReclam) : null,
        $id_client,
        htmlspecialchars(trim($_POST['Categorie'])),
        htmlspecialchars(trim($_POST['Description']))
    );

    if ($idReclam) {
        $pc->updateReclamation($reclamation, intval($idReclam));
    } else {
        $pc->ajouterReclamation($reclamation);
    }

    header('Location: claim.php');
    exit();
} else {
    echo "<p style='color: red;'>Erreur : Catégorie et description requises.</p>";
}
?>
