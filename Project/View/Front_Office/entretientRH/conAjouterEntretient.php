<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../../../controller/entretienC.php";
require_once "../../../controller/candidatC.php"; // Needed to get candidate info
require_once '../../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    $id_candidat = trim($_POST['idCandidat1'] ?? '');
    $rawDate = $_POST['date_entretient'] ?? '';
    $lien = trim($_POST['lien_entretient'] ?? '');

    $formattedDate = DateTime::createFromFormat('Y-m-d H:i', $rawDate);
    $dateSQL = $formattedDate ? $formattedDate->format('Y-m-d H:i:s') : null;

    // Server-side validation
    if (empty($id_candidat)) $errors['idCandidat1'] = "ID du candidat manquant.";
    if (empty($lien)) $errors['lien_entretient'] = "Lien d'entretien requis.";
    if (!$formattedDate) $errors['date_entretient'] = "Date invalide.";

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $_POST;
        header("Location: forumEntretien.php");
        exit();
    }

    $entretienC = new EntretienC();
    $candidatC = new CandidatC();

    try {
        // Get candidate info for email
        $candidat = $candidatC->ChercherCandidatByID($id_candidat);
        if (!$candidat) {
            $_SESSION['errors']['idCandidat1'] = "Candidat introuvable.";
            header("Location: forumEntretien.php");
            exit();
        }

        $email = $candidat['email'];
        $nom = $candidat['nom'];
        $prenom = $candidat['prenom'];

        // Add interview to DB
        $entretienC->ajouterEntretien($id_candidat, $dateSQL, "Planifié", $lien, "");

        // Send interview email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'messaoudiasma60@gmail.com';
            $mail->Password = 'foyu admn gjhq wzys';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('messaoudiasma60@gmail.com', 'Logixpress HR');
            $mail->addAddress($email, "$prenom $nom");

            $mail->isHTML(true);
            $mail->Subject = 'Logixpress Interview Invitation';
            $mail->Body = "
                <p>Dear $prenom $nom,</p>
                <p>Congratulations! You've been selected to attend an interview with Logixpress.</p>
                <p><strong>Date & Time:</strong> {$formattedDate->format('Y-m-d H:i')}<br>
                <strong>Interview Link:</strong> <a href='$lien'>$lien</a></p>
                <br><p>We look forward to speaking with you.</p>
                <p>Best regards,<br>Logixpress HR Team</p>
            ";

            $mail->send();
        } catch (Exception $e) {
            error_log("Email error: " . $mail->ErrorInfo);
        }

        unset($_SESSION['old']);
        header("Location: TableEntretien.php?success=1&mail=sent");
        exit();

    } catch (PDOException $e) {
        $_SESSION['errors']['db'] = "Erreur serveur: " . $e->getMessage();
        header("Location: forumEntretien.php");
        exit();
    }
}
?>
