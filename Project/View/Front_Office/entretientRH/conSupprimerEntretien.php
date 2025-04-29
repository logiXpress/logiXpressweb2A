<?php
require "../../../controller/entretienC.php"; 
require_once '../../../controller/config.php'; // path to your config

try {
    $id = isset($_POST['idEntretien']) ? $_POST['idEntretien'] : null;

    if ($id === null) {
        die('Error: No ID provided.');
    }

    $entretienC = new EntretienC(); // <-- create object
    $success = $entretienC->supprimerEntretien($id); // <-- call your controller function

    if ($success) {
        header("Location: TableEntretien.php");
        exit();
    } else {
        die('Error: Failed to delete entretien.');
    }

} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}
?>
