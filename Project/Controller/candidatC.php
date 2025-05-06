<?php
require_once 'config.php';
require_once '../../../vendor/autoload.php';  // Adjust path as needed

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class candidatC
{
    public function listeCandidat()
    {
        $conn = config::getConnexion();
        $requette = $conn->prepare("SELECT id_candidat,nom, prenom, email, telephone, CV, Date_Candidature FROM CANDIDATS");
        $requette->execute(); 
        $result = $requette->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function ajouterCandidat($nom, $prenom, $email, $telephone, $CV, $dateCandidature)
{
    $conn = config::getConnexion();
    $requette = $conn->prepare("INSERT INTO CANDIDATS (nom, prenom, email, telephone, CV, Date_Candidature) VALUES (:nom, :prenom, :email, :telephone, :CV, :Date_Candidature)");

    // Bind the input parameters to prevent SQL injection
    $requette->bindParam(":nom", $nom);
    $requette->bindParam(":prenom", $prenom);
    $requette->bindParam(":email", $email);
    $requette->bindParam(":telephone", $telephone);
    $requette->bindParam(":CV", $CV);
    $requette->bindParam(":Date_Candidature", $dateCandidature);

    try {
        // Execute the SQL query
        if ($requette->execute()) {
            echo "Record inserted successfully.";

            // Send welcome email
            $this->sendWelcomeEmail($email, $nom);
        } else {
            echo "Failed to insert record.";
        }
    } catch (PDOException $e) {
        echo "SQL Error: " . $e->getMessage();
    }
}

public function sendWelcomeEmail($email, $name)
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.office365.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'messaoudiAsmaa@outlook.com'; // your Outlook/Office365 email
        $mail->Password = 'jifidagrgklluqyz';     // Use your app password here
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('messaoudiAsmaa@outlook.com', 'Your Name or Company');
        $mail->addAddress($email, $name);
        $mail->isHTML(true);
        $mail->Subject = 'Welcome to Our Service';
        $mail->Body    = 'Dear ' . $name . ',<br><br>Welcome! Your application has been successfully received. We will contact you soon with interview details.';

        $mail->send();
        echo 'Confirmation email sent.';
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}


    public function supprimerCandidat($idCandidat)
    {
        $conn = config::getConnexion();
        try {
            $requette = $conn->prepare("DELETE FROM CANDIDATS WHERE id_candidat = :id");
            $requette->bindParam(":id", $idCandidat, PDO::PARAM_INT); 
            $requette->execute();
            
            
            return $requette->rowCount() > 0; 
        } catch (PDOException $e) {
            
            error_log("Error deleting candidate: " . $e->getMessage());
            return false; 
        }
    }
    public function modifierCandidat($idCandidat, $nom, $prenom, $email, $telephone, $CV, $dateCandidature)
    {
        $conn = config::getConnexion();
        try {
            $requette = $conn->prepare("UPDATE CANDIDATS SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone, CV = :CV, Date_Candidature = :Date_Candidature WHERE id_candidat = :id");
            
            $requette->bindParam(":nom", $nom);
            $requette->bindParam(":prenom", $prenom);
            $requette->bindParam(":email", $email);
            $requette->bindParam(":telephone", $telephone);
            $requette->bindParam(":CV", $CV);
            $requette->bindParam(":Date_Candidature", $dateCandidature);
            $requette->bindParam(":id", $idCandidat, PDO::PARAM_INT); 
            
            
            $success = $requette->execute();
            
            
            return $success; 
        } catch (PDOException $e) {
            
            error_log("Error updating candidate: " . $e->getMessage());
            return false; 
        }
    }
    public function ChercherEmailCandidat($email)
    {
        $conn = config::getConnexion();
        $requette = $conn->prepare("SELECT COUNT(*) FROM CANDIDATS WHERE email = :email");
        $requette->bindParam(":email", $email);
        $requette->execute(); 
        return $requette->fetchColumn(); 
    }

    public function ChercherTelephoneCandidat($telephone)
    {
        $conn = config::getConnexion();
        $requette = $conn->prepare("SELECT COUNT(*) FROM CANDIDATS WHERE telephone = :telephone");
        $requette->bindParam(":telephone", $telephone);
        $requette->execute();
        return $requette->fetchColumn();
    }

    public function ChercherIDCandidatByEmail($email,$telephone)
    {
        $conn = config::getConnexion();
        $requette = $conn->prepare("SELECT id_candidat FROM CANDIDATS WHERE email = :email AND telephone=:telephone");
        $requette->bindParam(":email", $email);
        $requette->bindParam(":telephone", $telephone);
        $requette->execute();
        return $requette->fetchColumn();
    }

    public function ChercherCandidatByID($id)
{
    $conn = config::getConnexion();
    $requette = $conn->prepare("SELECT id_candidat, nom, prenom, email, telephone, CV, Date_Candidature FROM CANDIDATS WHERE id_candidat = :id");
    $requette->bindParam(":id", $id, PDO::PARAM_INT);
    $requette->execute();
    return $requette->fetch(PDO::FETCH_ASSOC) ?: null;
}

        
}