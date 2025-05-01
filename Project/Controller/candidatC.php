<?php
require_once 'config.php';

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
    
        // Debugging output
        var_dump($nom, $prenom, $email, $telephone, $CV, $dateCandidature);
    
        
        $requette->bindParam(":nom", $nom);
        $requette->bindParam(":prenom", $prenom);
        $requette->bindParam(":email", $email);
        $requette->bindParam(":telephone", $telephone);
        $requette->bindParam(":CV", $CV);
        $requette->bindParam(":Date_Candidature", $dateCandidature);
        
        
        try {
            if ($requette->execute()) {
                echo "Record inserted successfully.";
            } else {
                echo "Failed to insert record.";
            }
        } catch (PDOException $e) {
            echo "SQL Error: " . $e->getMessage();
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