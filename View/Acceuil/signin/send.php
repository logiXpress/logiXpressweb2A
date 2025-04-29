<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

function sendResetCode($recipientEmail, $resetCode) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'tonemail@gmail.com'; // <-- Mets ton adresse Gmail ici
        $mail->Password   = 'bkjj suoj lngh rqae'; // <-- Ton mot de passe d'application ici
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('tonemail@gmail.com', 'Support LogiXpress');
        $mail->addAddress($recipientEmail);

        $mail->isHTML(true);
        $mail->Subject = 'Code de réinitialisation de votre mot de passe';
        $mail->Body    = "
            <div style='font-family: Arial, sans-serif;'>
                <h2 style='color: #4CAF50;'>Réinitialisation du mot de passe</h2>
                <p>Bonjour,</p>
                <p>Voici votre code de réinitialisation :</p>
                <h1 style='color: #333;'>$resetCode</h1>
                <p>Merci de l'utiliser pour réinitialiser votre mot de passe.</p>
                <br><p>— L'équipe LogiXpress</p>
            </div>
        ";
        $mail->AltBody = "Votre code de réinitialisation est : $resetCode";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>
