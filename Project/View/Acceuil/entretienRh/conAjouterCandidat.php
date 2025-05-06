<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "../../../Controller/candidatC.php";
require_once '../../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    
    // Updated: Use correct datetime format
    $rawDate = $_POST['date'];
    $formattedDate = DateTime::createFromFormat('Y-m-d\TH:i', $rawDate);
    $dateSQL = $formattedDate ? $formattedDate->format('Y-m-d H:i:s') : null;

    $destination = null;

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
            die("Failed to move uploaded file to: $filePath.");
        }
    } else {
        die("No file uploaded.");
    }

    $CandidatC = new CandidatC();

    try {
        $CandidatC->ajouterCandidat($nom, $prenom, $email, $telephone, $destination, $dateSQL);

        // Send welcome email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.office365.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'messaoudiAsmaa@outlook.com'; // your Outlook email
            $mail->Password = 'jifidagrgklluqyz'; // App Password from Outlook
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Optional debug
            //$mail->SMTPDebug = 2;
            //$mail->Debugoutput = 'html';

            $mail->setFrom('messaoudiAsmaa@outlook.com', 'Logixpress HR');
            $mail->addAddress($email, "$prenom $nom");

            $mail->isHTML(true);
            $mail->Subject = 'Welcome to Logixpress!';
            $mail->Body = "
                <p>Dear $prenom $nom,</p>
                <p>Thank you for applying to Logixpress. We have received your application.</p>
                <p>If selected, you'll receive interview details soon.</p>
                <br><p>Best regards,<br>Logixpress HR Team</p>
            ";

            $mail->send();
        } catch (Exception $e) {
            echo "Email error: " . $mail->ErrorInfo;
        }

        header("Location: dataTableCandidat.php");
        exit();

    } catch (PDOException $e) {
        echo "Error inserting into database: " . $e->getMessage();
    }
}
?>
