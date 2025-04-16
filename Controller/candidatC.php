<?php
require 'config.php'; 

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
    
        
    
        // Bind parameters
        $requette->bindParam(":nom", $nom);
        $requette->bindParam(":prenom", $prenom);
        $requette->bindParam(":email", $email);
        $requette->bindParam(":telephone", $telephone);
        $requette->bindParam(":CV", $CV);
        $requette->bindParam(":Date_Candidature", $dateCandidature);
        
        // Execute the query with error handling
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
            $requette = $conn->prepare("DELETE FROM CANDIDATS WHERE id_candidat = :id"); // Check column name
            $requette->bindParam(":id", $idCandidat, PDO::PARAM_INT); // Use appropriate parameter type
            $requette->execute();
            
            // Optionally return the number of affected rows
            return $requette->rowCount() > 0; // Returns true if deletion was successful
        } catch (PDOException $e) {
            // Handle exception (log it, rethrow it, etc.)
            error_log("Error deleting candidate: " . $e->getMessage());
            return false; // Return false on error
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
            $requette->bindParam(":id", $idCandidat, PDO::PARAM_INT); // Specify parameter type
            
            // Execute the statement and check for success
            $success = $requette->execute();
            
            // Optionally return whether the update was successful
            return $success; // Returns true if the update was successful
        } catch (PDOException $e) {
            // Handle exception (log it, rethrow it, etc.)
            error_log("Error updating candidate: " . $e->getMessage());
            return false; // Return false on error
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
        $requette = $conn->prepare("SELECT id_candidat,nom, prenom, email, telephone, CV, Date_Candidature  FROM CANDIDATS WHERE id_candidat = :id");
        $requette->bindParam(":id", $id, PDO::PARAM_INT); // Specify parameter type
        $requette->execute();
        $result = $requette->fetchAll(PDO::FETCH_ASSOC);

        return $result;    }

        
}