<?php
session_start();
require_once __DIR__ . '/../../../Controller/candidatC.php';
require_once __DIR__ . '/../../../Model/candidat.php';

try {
    
    if (!isset($_POST['idCandidat']) || !is_numeric($_POST['idCandidat'])) {
        throw new Exception("Invalid candidate ID.");
    }
    $idCandidat = (int)$_POST['idCandidat'];

    
    $candidatC = new CandidatC();
    $result = $candidatC->ChercherCandidatByID($idCandidat);
    if ($result === null) {
        throw new Exception("Candidate not found.");
    }
    $existingCandidate = $result;


    $nom = isset($_POST['nom']) ? trim($_POST['nom']) : $existingCandidate['nom'];
    $prenom = isset($_POST['prenom']) ? trim($_POST['prenom']) : $existingCandidate['prenom'];
    $email = isset($_POST['email']) ? trim($_POST['email']) : $existingCandidate['email'];
    $telephone = isset($_POST['telephone']) ? trim($_POST['telephone']) : $existingCandidate['telephone'];
    $dateCandidature = isset($_POST['date']) ? trim($_POST['date']) : $existingCandidate['Date_Candidature'];

    
    if (empty($nom) || empty($prenom) || empty($email) || empty($telephone)) {
        throw new Exception("All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email format.");
    }

    //cv
    $CV = $existingCandidate['CV'];
    if (isset($_FILES['CV']) && $_FILES['CV']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['CV']['tmp_name'];
        $fileName = $_FILES['CV']['name'];
        $fileSize = $_FILES['CV']['size'];

        $uploadFileDir = 'uploads/';
        if (!file_exists($uploadFileDir)) {
            mkdir($uploadFileDir, 0777, true);
        }

        $dest_path = $uploadFileDir . $fileName;

        $allowedTypes = ['application/pdf'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $fileTmpPath);
        finfo_close($finfo);

        if (!in_array($mime, $allowedTypes)) {
            throw new Exception("Only PDF files are allowed.");
        }

        if ($fileSize > 5000000) {
            throw new Exception("File size exceeds 5MB limit.");
        }

        if (!move_uploaded_file($fileTmpPath, $dest_path)) {
            throw new Exception("Failed to move uploaded file.");
        }

        $CV = $dest_path;
    }

    // Candidat
    $candidat = new Candidat($nom, $prenom, $email, $telephone, $CV, $dateCandidature);
    $candidatC->modifierCandidat($idCandidat, $nom, $prenom, $email, $telephone, $CV, $dateCandidature);
    $_SESSION['success'] = "Candidate updated successfully.";
    header("Location: dataTableCandidat.php");
    exit();

} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: forumModifierCandidat.php?idCandidat=$idCandidat");
    exit();
}
?>