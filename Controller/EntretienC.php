<?php
require_once '../../../Model/Vehicule.php';      
require_once '../../../config/config.php'; 

class EntretienC {
    private $db;

    public function __construct() {
        $this->db = Config::getConnexion();
    }

    public function getEntretienById($id) {
        $sql = "SELECT * FROM entretiens_vehicules WHERE id_entretien = :id";
        try {
            $query = $this->db->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    public function ajouterEntretien($entretien) {
        $sql = "INSERT INTO entretiens_vehicules (id_vehicule, Date, Type_intervention) 
                VALUES (:id_vehicule, :date, :type_intervention)";
        $req = $this->db->prepare($sql);
        $req->bindValue(':id_vehicule', $entretien->getIdVehicule());
        $req->bindValue(':date', $entretien->getDate());
        $req->bindValue(':type_intervention', $entretien->getTypeIntervention());
        $req->execute();
    }

    public function modifierEntretien($id, $entretien) {
        $sql = "UPDATE entretiens_vehicules 
                SET id_vehicule=:id_vehicule, Date=:date, Type_intervention=:type_intervention 
                WHERE id_entretien=:id";
        $req = $this->db->prepare($sql);
        $req->bindValue(':id', $id);
        $req->bindValue(':id_vehicule', $entretien->getIdVehicule());
        $req->bindValue(':date', $entretien->getDate());
        $req->bindValue(':type_intervention', $entretien->getTypeIntervention());
        $req->execute();
    }

    public function supprimerEntretien($id) {
        $sql = "UPDATE entretiens_vehicules SET is_deleted = 1 WHERE id_entretien = :id";
        $req = $this->db->prepare($sql);
        $req->bindValue(':id', $id);
        $req->execute();
    }

    public function listeEntretiens() {
        $sql = "SELECT * FROM entretiens_vehicules WHERE is_deleted = 0";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function rechercherEntretienParId($searchId = '') {
        $query = "SELECT * FROM entretiens_vehicules";
        
        if (!empty($searchId)) {
            $query .= " WHERE id_vehicule = :searchId";
        }

        $stmt = $this->db->prepare($query);

        if (!empty($searchId)) {
            $stmt->bindValue(':searchId', $searchId, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sortEntretiensByDate() {
        $entretiens = $this->listeEntretiens(); 
        usort($entretiens, function($a, $b) {
            return strtotime($a['Date']) - strtotime($b['Date']); 
        });
        return $entretiens; 
    }

    private function logAction($action, $vehiculeId, $details, $date = null) {
        $stmt = $this->db->prepare("INSERT INTO historique (action, vehicule_id, details, date) VALUES (?, ?, ?, ?)");
        $stmt->execute([$action, $vehiculeId, $details, $date ?? date('Y-m-d H:i:s')]);
    }

    public function getHistorique() {
        $stmt = $this->db->prepare("SELECT * FROM historique ORDER BY date DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ajouterHistorique($action, $vehiculeId, $typeIntervention) {
        try {
            $query = $this->db->prepare("INSERT INTO historique (action, vehicule_id, details, date) VALUES (:action, :vehicule_id, :details, NOW())");
            $details = "Type intervention: " . $typeIntervention;
            $query->execute([
                'action' => $action,
                'vehicule_id' => $vehiculeId,
                'details' => $details
            ]);
        } catch (Exception $e) {
            echo 'Erreur lors de l\'ajout à l\'historique: ' . $e->getMessage();
        }
    }

    public function rechercherHistoriqueParIdVehicule($searchId = '') {
        $query = "SELECT * FROM historique";
        
        if (!empty($searchId)) {
            $query .= " WHERE vehicule_id = :searchId";
        }

        $stmt = $this->db->prepare($query);

        if (!empty($searchId)) {
            $stmt->bindValue(':searchId', $searchId, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStatistiquesParIdVehicule($vehicule_id) {
        $query = "SELECT action, date FROM historique WHERE vehicule_id = :vehicule_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['vehicule_id' => $vehicule_id]);
        $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $total = count($logs);
        $ajouts = count(array_filter($logs, fn($log) => $log['action'] === 'add'));
        $updates = count(array_filter($logs, fn($log) => $log['action'] === 'update'));
        
        return [
            'total' => $total,
            'ajouts' => $ajouts,
            'updates' => $updates,
        ];
    }

    public function getNombreEntretiensParVehicule() {
        $sql = "SELECT vehicule_id, COUNT(*) AS nb FROM entretiens GROUP BY vehicule_id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    
    public function getNombreEntretiensPourVehicule($vehicule_id) {
        $sql = "SELECT COUNT(*) AS total FROM entretiens WHERE vehicule_id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindParam(':id', $vehicule_id);
            $query->execute();
            return $query->fetch()['total'];
        } catch (PDOException $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    public function afficherEntretien() {
        $sql = "SELECT * FROM entretiens_vehicules WHERE is_deleted = 0";
        try {
            $query = $this->db->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    
}