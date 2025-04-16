<?php
session_start();
require "../../../Controller/candidatC.php";

$CandidatC = new CandidatC();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["idCandidat"])) {
    $id = intval($_POST["idCandidat"]); 
    $nom = $_POST["nom"] ?? '';
    $prenom = $_POST["prenom"] ?? '';
    $email = $_POST["email"] ?? '';
    $telephone = $_POST["telephone"] ?? '';

    // Get existing candidate data
    $existingData = $CandidatC->ChercherCandidatByID($id);
    
    if (empty($existingData)) {
        $_SESSION['error'] = "Candidate not found.";
        header("Location: forumModifierCandidat.php?idCandidat=".$id);
        exit();
    }

    // Keep existing CV by default
    $CV = $existingData[0]['CV'] ?? '';

    // Only update CV if new file is uploaded
    if (!empty($_FILES['CV']['name']) && $_FILES['CV']['error'] === UPLOAD_ERR_OK) {

         // Add the PDF validation check here
    $fileType = strtolower(pathinfo($_FILES['CV']['name'], PATHINFO_EXTENSION));
    if ($fileType !== 'pdf') {
        $_SESSION['error'] = "Only PDF files are allowed for CV upload.";
        header("Location: forumModifierCandidat.php?idCandidat=".$id);
        exit();
    }

        $uploadDir = 'uploads/';
        $destination = $uploadDir . basename($_FILES['CV']['name']);
        
        if (move_uploaded_file($_FILES['CV']['tmp_name'], $destination)) {
            $CV = $destination;
        }
    }

    // Date handling
    $dateInput = trim($_POST['date'] ?? '');
    $date = DateTime::createFromFormat('Y-m-d H:i', $dateInput);
    if ($date) {
        $formattedDate = $date->format('Y-m-d H:i:s');
    } else {
        $formattedDate = date('Y-m-d H:i:s'); // Fallback to current date if invalid
    }

    // Update candidate
    if ($CandidatC->modifierCandidat($id, $nom, $prenom, $email, $telephone, $CV, $formattedDate)) {
        $_SESSION['success'] = "Candidate updated successfully.";
        header("Location: dataTableCandidat.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to update candidate.";
        header("Location: forumModifierCandidat.php?idCandidat=".$id);
        exit();
    }
}