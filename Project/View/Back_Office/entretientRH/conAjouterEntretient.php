<?php

require "../../../controller/entretienC.php"; 

session_start();

// Check if POST variables are set
if (isset($_POST['idCandidat1']) && isset($_POST['date_entretient']) && isset($_POST['lien_entretient'])) {
    $id_candidat = trim($_POST['idCandidat1']);
    // Create DateTime object from the provided date
    $date = DateTime::createFromFormat('Y-m-d\TH:i', $_POST['date_entretient']);
  
$lien=$_POST['lien_entretient'];
    // Check if the date was created successfully
    if ($date && $date->format('Y-m-d\TH:i') === $_POST['date_entretient']) {
        // Create an instance of EntretienC
        $Entretient = new EntretienC();

        // Attempt to add the candidate
        $result = $Entretient->ajouterEntretien($id_candidat, $date->format('Y-m-d H:i:s'), "Planifié", $lien, "");

        // Check if the operation was successful
        if ($result) {
            // Redirect after successful processing
            header("Location: TableEntretien.php?success=1");
            exit();
        } else {
            // Handle failure to add entretien
            echo "Failed to add entretien. Please try again.";
        }
    } else {
        // Handle invalid date format
        echo "Invalid date format. Please enter a valid date and time.";
    }
} else {
    // Handle missing POST variables
    echo "ID Candidat or Date Entretien is missing. Please fill in all required fields.";
}
?>