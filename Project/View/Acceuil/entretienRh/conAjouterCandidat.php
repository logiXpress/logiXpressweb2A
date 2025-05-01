<?php
require "../../../Controller/candidatC.php";
session_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $date = $_POST['date']; 
    
    $destination = null;

    //var_dump($_FILES);
if (isset($_FILES['CV'])) {
    $file = $_FILES['CV'];
    
    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("Upload failed with error code " . $file['error']);
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if ($mime !== 'application/pdf') {
        die("Error: Only PDF files are allowed.");
    }

    $uploadDir = 'uploads/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
$fileBaseName = pathinfo($file['name'], PATHINFO_FILENAME);
$fileName = $fileBaseName . '_' . time() . '.' . $fileExtension;
    $filePath = $uploadDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        $destination = $filePath;
    } else {
        die("Failed to move uploaded file to: $filePath. Check directory permissions.");
    }
} else {
    die("No file uploaded.");
}

//var_dump($_POST);
$rawDate = $_POST['date'];
$formattedDate = DateTime::createFromFormat('Y/m/d H:i', $rawDate);
if ($formattedDate) {
    $dateSQL = $formattedDate->format('Y-m-d H:i:s');
} else {
    // Handle invalid date input (optional)
    $dateSQL = null; // or set an error message
}
/*$dateInput = $_POST['date'] ?? null;
if ($dateInput) {
    $date = DateTime::createFromFormat('Y-m-d\TH:i', $dateInput);
    if ($date === false) {
        echo "Error parsing date.";
        exit;
    }
    $formattedDate = $date->format('Y-m-d H:i');
} else {
    echo "Date is missing from form.";
    exit;
}*/

    
   
    
    $CandidatC = new CandidatC();

    
    try {
        $CandidatC->ajouterCandidat($nom, $prenom, $email, $telephone, $destination, $dateSQL);
        echo "Record inserted successfully.";
    } catch (PDOException $e) {
        echo "Error inserting into database: " . $e->getMessage();
    }

    
    header("Location: dataTableCandidat.php");
    exit();
}
?>