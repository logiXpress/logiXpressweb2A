<?php
require "../../../Controller/candidatC.php"; // Include your controller
session_start();

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $date = $_POST['date']; 
    
    // Initialize $destination variable
    $destination = null;

    // Handle file upload
    var_dump($_FILES);
if (isset($_FILES['CV'])) {
    $file = $_FILES['CV'];

    // Check for errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("Upload failed with error code " . $file['error']);
    }

    // Validate MIME type using finfo
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if ($mime !== 'application/pdf') {
        die("Error: Only PDF files are allowed.");
    }

    // Set upload directory
    $uploadDir = 'uploads/';

    // Create uploads directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Create a unique, sanitized file name
    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
$fileBaseName = pathinfo($file['name'], PATHINFO_FILENAME);
$fileName = $fileBaseName . '_' . time() . '.' . $fileExtension;
    $filePath = $uploadDir . $fileName;

    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        $destination = $filePath; // Relative path to save in the DB
    } else {
        die("Failed to move uploaded file to: $filePath. Check directory permissions.");
    }
} else {
    die("No file uploaded.");
}

var_dump($_POST);
$rawDate = $_POST['date'];
$formattedDate = DateTime::createFromFormat('Y/m/d H:i', $rawDate);
if ($formattedDate) {
    $dateSQL = $formattedDate->format('Y-m-d H:i:s'); // Format for MySQL
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

    
   
    // Create an instance of CandidatC
    $CandidatC = new CandidatC();

    // Add candidate, using the path of the uploaded CV
    try {
        $CandidatC->ajouterCandidat($nom, $prenom, $email, $telephone, $destination, $dateSQL);
        echo "Record inserted successfully.";
    } catch (PDOException $e) {
        echo "Error inserting into database: " . $e->getMessage();
    }

    // Redirect after processing
    header("Location: dataTableCandidat.php");
    exit(); // Good practice to call exit() after a header redirect
}
?>