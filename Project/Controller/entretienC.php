<?php
require_once 'config.php';
require_once '../../../Model/entretien.php';
require 'candidatC.php';
class entretienC
{
    public function listeEntretien()
    {
        $conn = config::getConnexion();
        $requette = $conn->prepare("SELECT id_entretien, date_entretien, Statut, lien_entretien, evaluation, 
               c.nom, c.prenom, c.email, c.telephone 
        FROM ENTRETIENS_RH E 
        JOIN Candidats C ON E.id_candidat = C.id_candidat
    ");
        $requette->execute();
        return $requette->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ajouterEntretien($id_candidat, $Date_Entretien, $Statut, $lien_entretien, $evaluation)
{
    $conn = config::getConnexion();
    $requette = $conn->prepare("INSERT INTO ENTRETIENS_RH (id_candidat, date_entretien, Statut, lien_entretien, evaluation) VALUES (:id_candidat, :date_entretien, :statut, :lien_entretien, :evaluation)");
    
    $requette->bindParam(":id_candidat", $id_candidat, PDO::PARAM_INT);
    $requette->bindParam(":date_entretien", $Date_Entretien); 
    $requette->bindParam(":statut", $Statut); 
    $requette->bindParam(":lien_entretien", $lien_entretien);
    $requette->bindParam(":evaluation", $evaluation);

    try {
        return $requette->execute();
    } catch (PDOException $e) {
        error_log("Error inserting interview: " . $e->getMessage());
        return false;
    }
}

    public function supprimerEntretien($idEntretien)
{
    $conn = config::getConnexion();
    if ($conn === null) {
        error_log("Error deleting interview: Database connection failed");
        return false;
    }

    try {
        $requette = $conn->prepare("DELETE FROM ENTRETIENS_RH WHERE id_entretien = :id");
        $requette->bindParam(":id", $idEntretien, PDO::PARAM_INT);
        $requette->execute();
        $rowCount = $requette->rowCount();
        if ($rowCount === 0) {
            error_log("Error deleting interview: No record found with id_entretien = $idEntretien");
        }
        return $rowCount > 0;
    } catch (PDOException $e) {
        error_log("Error deleting interview: " . $e->getMessage());
        return false;
    }
}

    public function modifierEntretien($id_entretien, $id_candidat, $date_entretien, $statut, $lien_entretien, $evaluation)
    {
        $conn = config::getConnexion();
        try {
            $requette = $conn->prepare("UPDATE ENTRETIENS_RH SET id_candidat = :id_candidat, date_entretien = :date_entretien, statut = :statut, lien_entretien = :lien_entretien, evaluation = :evaluation WHERE id_entretien = :id");
            
            $requette->bindParam(":id_candidat", $id_candidat, PDO::PARAM_INT);
            $requette->bindParam(":date_entretien", $date_entretien);
            $requette->bindParam(":statut", $statut);
            $requette->bindParam(":lien_entretien", $lien_entretien);
            $requette->bindParam(":evaluation", $evaluation);
            $requette->bindParam(":id", $id_entretien, PDO::PARAM_INT);

            return $requette->execute();
        } catch (PDOException $e) {
            error_log("Error updating interview: " . $e->getMessage());
            return false;
        }
    }

    public function ListeCandidatParNomPrenomEmail()
    {
        $conn = config::getConnexion();
        try {
            $requette = $conn->prepare("SELECT nom || ' ' || prenom || ' ' || email AS info FROM CANDIDATS");
            $requette->execute();
            return $requette->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching candidates info: " . $e->getMessage());
            return [];
        }
    }

    public function chercherIdCandidatByIdEntretien($id)
    {
        $conn = config::getConnexion();
        try {
            $requette = $conn->prepare("SELECT id_candidat FROM ENTRETIENS_RH WHERE id_entretien = :id");
            $requette->bindParam(':id', $id, PDO::PARAM_INT);
            $requette->execute();
            $result = $requette->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['id_candidat'] : null;
        } catch (PDOException $e) {
            error_log("Error fetching candidate ID by interview ID: " . $e->getMessage());
            return null;
        }
    }

    public function ChercherEntretientByID($id)
    {
        $conn = config::getConnexion();
        try {
            $requette = $conn->prepare("SELECT date_entretien, statut, lien_entretien, evaluation FROM ENTRETIENS_RH WHERE id_entretien = :id");
            $requette->bindParam(':id', $id, PDO::PARAM_INT);
            $requette->execute();
            return $requette->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching interview by ID: " . $e->getMessage());
            return [];
        }
    }

    public function getCandidateEmail($id)
    {
        $conn = config::getConnexion();
        try {
            $requette = $conn->prepare("SELECT email FROM CANDIDATS WHERE id_candidat = :id");
            $requette->bindParam(':id', $id, PDO::PARAM_INT);
            $requette->execute();
            $result = $requette->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['email'] : false;
        } catch (PDOException $e) {
            error_log("Error fetching candidate email: " . $e->getMessage());
            return false;
        }
    }
}
?>
