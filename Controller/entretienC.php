<?php
require "candidatC.php";

class entretienC
{
    public function listeEntretien()
    {
        try {
            $conn = config::getConnexion();
            $requette = $conn->prepare("SELECT id_entretien,date_entretien, statut, lien_entretien, evaluation, c.nom, c.prenom, c.email, c.telephone FROM ENTRETIENS_RH E JOIN Candidats C ON E.id_candidat = C.id_candidat");
            $requette->execute();
            $result = $requette->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function ajouterEntretien($id_candidat, $date_entretien, $statut, $lien_entretien, $evaluation)
    {
        try {
            $conn = config::getConnexion();
            $requette = $conn->prepare("INSERT INTO ENTRETIENS_RH (id_candidat, date_entretien, statut, lien_entretien, evaluation) VALUES (:id_candidat, :date_entretien, :statut, :lien_entretien, :evaluation)");
            $requette->bindParam(":id_candidat", $id_candidat);
            $requette->bindParam(":date_entretien", $date_entretien);
            $requette->bindParam(":statut", $statut);
            $requette->bindParam(":lien_entretien", $lien_entretien);
            $requette->bindParam(":evaluation", $evaluation);
    
            $requette->execute();
            
            // Return true if the execution was successful
            return true; 
        } catch (PDOException $e) {
            // Optionally log the error message
            echo "Error: " . $e->getMessage();
    
            // Return false if an error occurs
            return false; 
        }
    }

    public function supprimerEntretien($idEntretien)
    {
     
            $conn = config::getConnexion();
            $requette = $conn->prepare("DELETE FROM ENTRETIENS_RH WHERE id_entretien = :id");
            $requette->bindParam(":id", $idEntretien);
            $requette->execute();
            return true;
    
    }

    public function modifierEntretien($id_entretien, $id_candidat, $date_entretien, $statut, $lien_entretien, $evaluation)
    {
        try {
            $conn = config::getConnexion();
            $requette = $conn->prepare("UPDATE ENTRETIENS_RH SET id_candidat = :id_candidat, date_entretien = :date_entretien, statut = :statut, lien_entretien = :lien_entretien, evaluation = :evaluation WHERE id_entretien = :id");
            
            // Binding parameters
            $requette->bindParam(":id_candidat", $id_candidat, PDO::PARAM_INT);
            $requette->bindParam(":date_entretien", $date_entretien);
            $requette->bindParam(":statut", $statut);
            $requette->bindParam(":lien_entretien", $lien_entretien);
            $requette->bindParam(":evaluation", $evaluation);
            $requette->bindParam(":id", $id_entretien, PDO::PARAM_INT); // Ensure id is treated as an integer
    
            // Execute the query
            $requette->execute();
    
            // Optionally return the number of affected rows
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false; // Indicate that there was an error
        }
    }
    public function ListeCandidatParNomPrenomEmail()
    {
        try {
            $conn = config::getConnexion();
            $requette = $conn->prepare("SELECT nom || ' ' || prenom || ' ' || email AS info FROM CANDIDATS");
            $requette->execute();
            $result = $requette->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    public function chercherIdCandidatByIdEntretien($id)
    {
        try {
            $conn = config::getConnexion();
            $requette = $conn->prepare("SELECT id_candidat FROM ENTRETIENS_RH WHERE id_entretien = :id");
            $requette->bindParam(':id', $id, PDO::PARAM_INT); // Use parameter binding for security
            $requette->execute();
    
            // Fetch the result
            $result = $requette->fetch(PDO::FETCH_ASSOC);
    
                return $result['id_candidat'];
           
    
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null; // Return null in case of an error
        }
    }

    public function ChercherEntretientByID($id)
    {
        try {
            $conn = config::getConnexion();
            $requette = $conn->prepare("SELECT date_entretien, statut, lien_entretien, evaluation FROM ENTRETIENS_RH E WHERE  id_entretien = $id");
            $requette->execute();
            $result = $requette->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getCandidateEmail($id) {
        // Assuming you have a database connection established
        $stmt = $this->db->prepare("SELECT email FROM candidates WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['email'];
        }
        return false; // Return false if no email is found
    }

    
    
}
?>