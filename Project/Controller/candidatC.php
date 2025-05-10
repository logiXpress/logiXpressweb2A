<?php
require_once 'config.php';
require_once '../../../Model/candidat.php';
require_once '../../../vendor/autoload.php';  

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

    
    $requette->bindParam(":nom", $nom);
    $requette->bindParam(":prenom", $prenom);
    $requette->bindParam(":email", $email);
    $requette->bindParam(":telephone", $telephone);
    $requette->bindParam(":CV", $CV);
    $requette->bindParam(":Date_Candidature", $dateCandidature);

    try {
        
        if ($requette->execute()) {
            echo "Record inserted successfully.";

            
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
    $mail->SMTPDebug = 2;
    try {
        $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'messaoudiasma60@gmail.com'; 
$mail->Password   = 'foyu admn gjhq wzys'; 
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = 587;

           
            $mail->setFrom('messaoudiasma60@gmail.com', 'Logixpress HR');
            $mail->addAddress($email, "$prenom $nom");
        $mail->isHTML(true);
            $mail->Subject = 'Welcome to Logixpress!';
            $mail->Body = "
                <p>Dear $prenom $nom,</p>
                <p>Thank you for applying to Logixpress. We have received your application.</p>
                <p>If selected, you'll receive interview details soon.</p>
                <br><p>Best regards,<br>Logixpress HR Team</p>
            ";
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