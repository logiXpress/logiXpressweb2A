<?php
require_once '../../../Model/Vehicule.php';      
require_once '../../../config/config.php'; 

class EntretienC {
    private $db;

    public function __construct() {
        $this->db = Config::getConnexion();
    }

   public function getEntretienById(int $id): ?array {
    $sql = "SELECT * FROM entretiens_vehicules WHERE id_entretien = :id AND is_deleted = 0";
    try {
        $query = $this->db->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC) ?: null;
    } catch (PDOException $e) {
        error_log('Erreur dans getEntretienById: ' . $e->getMessage());
        return null; // Retourne null en cas d'erreur
    }
}

    public function ajouterEntretien($entretien): void {
        $sql = "INSERT INTO entretiens_vehicules (id_vehicule, Date, Type_intervention, statut) 
                VALUES (:id_vehicule, :date, :type_intervention, :statut)";
        try {
            $this->db->beginTransaction();
            $req = $this->db->prepare($sql);
            $req->bindValue(':id_vehicule', $entretien->getIdVehicule());
            $req->bindValue(':date', $entretien->getDate());
            $req->bindValue(':type_intervention', $entretien->getTypeIntervention());
            $req->bindValue(':statut', $entretien->getStatut());
            $req->execute();
            
            $this->ajouterHistorique('add', $entretien->getIdVehicule(), $entretien->getTypeIntervention());
            $this->db->commit();
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log('Erreur dans ajouterEntretien: ' . $e->getMessage());
            die('Erreur: ' . $e->getMessage());
        }
    }

    public function modifierEntretien(int $id, $entretien): void {
        $sql = "UPDATE entretiens_vehicules 
                SET id_vehicule = :id_vehicule, Date = :date, Type_intervention = :type_intervention, statut = :statut 
                WHERE id_entretien = :id";
        try {
            $this->db->beginTransaction();
            $req = $this->db->prepare($sql);
            $req->bindValue(':id', $id);
            $req->bindValue(':id_vehicule', $entretien->getIdVehicule());
            $req->bindValue(':date', $entretien->getDate());
            $req->bindValue(':type_intervention', $entretien->getTypeIntervention());
            $req->bindValue(':statut', $entretien->getStatut()); // Assurez-vous que le statut est bien passé ici
            $req->execute();
            $this->db->commit();
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log('Erreur dans modifierEntretien: ' . $e->getMessage());
            die('Erreur: ' . $e->getMessage());
        }
    }

    public function supprimerEntretien(int $id): void {
        $sql = "UPDATE entretiens_vehicules SET is_deleted = 1 WHERE id_entretien = :id";
        try {
            $req = $this->db->prepare($sql);
            $req->bindValue(':id', $id);
            $req->execute();
        } catch (PDOException $e) {
            error_log('Erreur dans supprimerEntretien: ' . $e->getMessage());
            die('Erreur: ' . $e->getMessage());
        }
    }

    public function listeEntretiens(): array {
        $sql = "SELECT * FROM entretiens_vehicules WHERE is_deleted = 0";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function rechercherEntretienParId(string $searchId = ''): array {
        $query = "SELECT * FROM entretiens_vehicules WHERE is_deleted = 0";
        if (!empty($searchId)) {
            $query .= " AND id_vehicule = :searchId";
        }

        $stmt = $this->db->prepare($query);
        if (!empty($searchId)) {
            $stmt->bindValue(':searchId', $searchId, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sortEntretiensByDate(): array {
        $entretiens = $this->listeEntretiens(); 
        usort($entretiens, function($a, $b) {
            return strtotime($b['Date']) - strtotime($a['Date']); // Tri décroissant par date
        });
        return $entretiens; 
    }

    public function getHistorique(): array {
        $stmt = $this->db->prepare("SELECT * FROM historique ORDER BY date DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ajouterHistorique(string $action, int $vehicule_id, string $details): void {
        $sql = "INSERT INTO historique (action, vehicule_id, date, details) VALUES (:action, :vehicule_id, NOW(), :details)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':action' => $action,
            ':vehicule_id' => $vehicule_id,
            ':details' => $details
        ]);
    }

    public function rechercherHistoriqueParIdVehicule($vehicule_id) {
        $historique = [];
        
        try {
            $sql = "SELECT * FROM historique WHERE vehicule_id = :vehicule_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':vehicule_id', $vehicule_id, PDO::PARAM_INT);
            $stmt->execute();
            $historique = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Erreur lors de la récupération des données: " . $e->getMessage());
            return []; // Retourner un tableau vide en cas d'erreur
        }
        
        return $historique;
    }

    public function getHistoriqueSoumis() {
        $sql = "SELECT vehicule_id FROM historique WHERE statut = 'submitted'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNombreEntretiensSoumisParVehicule(int $vehicule_id): int {
        $sql = "SELECT COUNT(*) AS total FROM entretiens_vehicules WHERE id_vehicule = :id_vehicule AND statut = 'submitted' AND is_deleted = 0";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_vehicule', $vehicule_id, PDO::PARAM_INT);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function getStatistiquesSoumisPourTousVehicules(): array {
        $sql = "SELECT id_vehicule, COUNT(*) AS total 
                FROM entretiens_vehicules 
                WHERE statut = 'submitted' AND is_deleted = 0 
                GROUP BY id_vehicule";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEntretiensSoumis(): array {
        $sql = "SELECT id_vehicule FROM entretiens_vehicules WHERE statut = 'submitted'"; 
        try {
            $query = $this->db->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC); 
        } catch (Exception $e) {
            error_log('Erreur : ' . $e->getMessage()); 
            return []; 
        }
    }
}
?>