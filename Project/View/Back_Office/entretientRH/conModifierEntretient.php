<?php
require "../../../controller/entretienC.php"; 

if (isset($_POST["idEntretien"]) && is_numeric($_POST["idEntretien"])) {
    $id = intval($_POST["idEntretien"]); 
    $lien = $_POST["lien_entretient"];
    $status = $_POST["Status_entretient"];
    $evaluation = $_POST["Evaluation_entretient"];

    
    
    // Validate and format the date
    $date = DateTime::createFromFormat('Y-m-d\TH:i', $_POST['date_entretient']);
    if ($date) {
        $formattedDate = $date->format('Y-m-d H:i'); // Format to Y-m-d H:i
    } else {
        // Handle invalid date case
        echo "Error: Invalid date format.";
        exit();
    }

    // Create an instance of EntretienC
    $EntretienC = new EntretienC();
    $id_candidat = $EntretienC->chercherIdCandidatByIdEntretien($id);
    
    // Update entretien
    $EntretienC->modifierEntretien($id, $id_candidat, $formattedDate, $status, $lien, $evaluation);

    // Redirect after processing
    header("Location: TableEntretien.php");
    exit(); // It's good practice to call exit() after a header redirect
} else {
    // Handle case where idEntretien is not set or invalid
    echo "Error: Invalid entretien ID.";
}
?>