<?php
require_once '../../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = 2; // Enable verbose debug output
    $mail->isSMTP();
    
$mail->Host       = 'smtp.office365.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'messaoudiAsmaa@outlook.com'; // your email
$mail->Password   = 'btfjmkvaqdrdbpig'; // your app password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = 587;

    $mail->setFrom('messaoudiAsmaa@outlook.com', 'Logixpress HR');
    $mail->addAddress('asma.messaoudi@esprit.tn', 'Test Recipient');

    $mail->isHTML(true);
    $mail->Subject = 'Test Email';
    $mail->Body = '<p>This is a test email from PHPMailer using Outlook.</p>';

    $mail->send();
    echo 'Email sent successfully.';
} catch (Exception $e) {
    echo "Email failed. Error: {$mail->ErrorInfo}";
}
?>