<?php
session_start();
require_once __DIR__ . '/../../../Controller/candidatC.php';
require_once __DIR__ . '/../../../Model/candidat.php'; // Include the Candidat model

$CandidatC = new CandidatC();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["idCandidat"])) {
    try {
        // Validate ID
        $id = filter_input(INPUT_POST, 'idCandidat', FILTER_VALIDATE_INT);
        if ($id === false || $id <= 0) {
            throw new Exception("Invalid candidate ID");
        }

        // Get and sanitize input
        $nom = htmlspecialchars(trim($_POST["nom"] ?? ''));
        $prenom = htmlspecialchars(trim($_POST["prenom"] ?? ''));
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $telephone = preg_replace('/[^0-9]/', '', $_POST["telephone"] ?? '');

        // Validate required fields
        if (empty($nom) || empty($prenom) || empty($email) || empty($telephone)) {
            throw new Exception("All fields except CV are required");
        }

        // Get existing candidate data
        $existingData = $CandidatC->ChercherCandidatByID($id);
        if (empty($existingData)) {
            throw new Exception("Candidate not found");
        }

        // Handle CV upload
        $CV = $existingData[0]['CV'];
        if (!empty($_FILES['CV']['name'])) {
            if ($_FILES['CV']['error'] !== UPLOAD_ERR_OK) {
                throw new Exception("File upload error: " . $_FILES['CV']['error']);
            }

            // Validate PDF
            $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($fileInfo, $_FILES['CV']['tmp_name']);
            finfo_close($fileInfo);
            
            if ($mime !== 'application/pdf') {
                throw new Exception("Only PDF files are allowed for CV upload");
            }

            // Secure upload
            $uploadDir = __DIR__ . '/../../../uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileName = uniqid('cv_', true) . '.pdf';
            $destination = $uploadDir . $fileName;
            
            if (!move_uploaded_file($_FILES['CV']['tmp_name'], $destination)) {
                throw new Exception("Failed to save uploaded file");
            }
            
            $CV = 'uploads/' . $fileName; // Relative path for database
        }

        // Validate and format date
        $dateInput = trim($_POST['date'] ?? '');
        $date = DateTime::createFromFormat('Y-m-d H:i', $dateInput);
        if (!$date) {
            $date = new DateTime(); // Fallback to current date
        }
        $formattedDate = $date->format('Y-m-d H:i:s');

        // Create Candidat object
        $candidat = new Candidat();
        $candidat->setNom($nom)
                ->setPrenom($prenom)
                ->setEmail($email)
                ->setTelephone($telephone)
                ->setCV($CV)
                ->setDateCandidature($formattedDate);

        // Update candidate
        if ($CandidatC->modifierCandidat($candidat, $id)) {
            $_SESSION['success'] = "Candidate updated successfully";
            header("Location: dataTableCandidat.php");
            exit();
        } else {
            throw new Exception("No changes made to candidate record");
        }

    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: forumModifierCandidat.php?idCandidat=" . ($id ?? ''));
        exit();
    }
}