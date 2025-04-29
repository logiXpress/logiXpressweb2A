<?php
require "../../../Controller/candidatC.php"; // Include your controller
session_start();

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $telephone = $_POST["telephone"];
    
    // Initialize $destination variable
    $destination = null;

    // Handle file upload
    if (isset($_FILES['CV'])) {
        $file = $_FILES['CV'];

        // Check for errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            die("Upload failed with error code " . $file['error']);
        }

        // Validate file type
        $allowedTypes = ['application/pdf'];
        if (!in_array($file['type'], $allowedTypes)) {
            die("Error: Only PDF files are allowed.");
        }

        // Set the upload directory to your specific path
        $uploadDir = 'uploads/'; // Use double backslashes

        // Create the uploads directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); // Create the directory with the appropriate permissions
        }

        $filePath = $uploadDir . basename($file['name']);

        // Move the uploaded file to the desired directory
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            
            // File successfully moved
        } else {
            die("Failed to move uploaded file to: $filePath. Check directory permissions.");
        }

        // Save the destination path for database insertion
        $destination = $filePath;
    } else {
        die("No file uploaded.");
    }

    // Debugging the date input
    $date = DateTime::createFromFormat('Y-m-d H:i', $_POST['date']);
    
    if ($date === false) {
        // Handle error - invalid date format
        echo "Error parsing date.";
        exit; // Stop execution if the date is invalid
    }

    $formattedDate = $date->format('Y-m-d H:i');

    // Create an instance of CandidatC
    $CandidatC = new CandidatC();

    // Add candidate, using the path of the uploaded CV
    try {
        $CandidatC->ajouterCandidat($nom, $prenom, $email, $telephone, $destination, $formattedDate);
        echo "Record inserted successfully.";
    } catch (PDOException $e) {
        echo "Error inserting into database: " . $e->getMessage();
    }

    // Redirect after processing
    header("Location: dataTableCandidat.php");
    exit(); // Good practice to call exit() after a header redirect
}
?>