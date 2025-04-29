<?php
require "../../../controller/entretienC.php";
session_start();

// Check if POST variables are set
if (isset($_POST['idCandidat1']) && isset($_POST['date_entretient']) && isset($_POST['lien_entretient'])) {
    $id_candidat = trim($_POST['idCandidat1']);
    $date = DateTime::createFromFormat('Y-m-d H:i', $_POST['date_entretient']);
    $lien = $_POST['lien_entretient'];

    if ($date && $date->format('Y-m-d H:i') === $_POST['date_entretient']) {
        $Entretient = new EntretienC();
        try {
            $result = $Entretient->ajouterEntretien($id_candidat, $date->format('Y-m-d H:i:s'), "Planifié", $lien, "");
            if ($result) {
                header("Location: TableEntretien.php?success=1");
                exit();
            } else {
                echo "Failed to add entretien. Check server logs for details.";
            }
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    } else {
        echo "Invalid date format. Please enter a valid date and time (YYYY-MM-DD HH:mm).";
    }
} else {
    echo "Missing fields: ";
    if (!isset($_POST['idCandidat1'])) echo "idCandidat1, ";
    if (!isset($_POST['date_entretient'])) echo "date_entretient, ";
    if (!isset($_POST['lien_entretient'])) echo "lien_entretient";
}
?>