<?php
require_once '../../../Model/Vehicule.php';      
require_once '../../../config/config.php'; 

class VehiculeC {
    private $db;

    // Constructeur de la classe qui récupère la connexion de la base de données via Config
    public function __construct() {
        $this->db = Config::getConnexion();
    }
    public function getDbConnection() {
        return $this->db;
    }
    public function getVehiculeById(string $id_vehicule) {
        $sql = "SELECT * FROM vehicules WHERE id_vehicule = :id_vehicule";
        $query = $this->db->prepare($sql);
        $query->bindValue(':id_vehicule', $id_vehicule);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function listeVehicules($column = 'id_vehicule', $order = 'ASC') {
        $sql = "SELECT * FROM vehicules ORDER BY $column $order";
        try {
            $stmt = $this->db->prepare($sql); // Utilisez $this->db ici
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des véhicules : " . $e->getMessage();
            return [];
        }
    }
    public function ajouterVehicule($vehicule) {
        $checkQuery = $this->db->prepare("SELECT COUNT(*) FROM vehicules WHERE Immatriculation = :immatriculation");
        $checkQuery->bindValue(':immatriculation', $vehicule->getImmatriculation());
        $checkQuery->execute();
        $count = $checkQuery->fetchColumn();

        if ($count > 0) {
            echo "<script>alert('Erreur : cette immatriculation existe déjà.');</script>";
            return;
        }

        $query = $this->db->prepare("INSERT INTO vehicules (Immatriculation, Type, Autonomie, Statut)
                                      VALUES (:immatriculation, :type, :autonomie, :statut)");
        $query->bindValue(':immatriculation', $vehicule->getImmatriculation());
        $query->bindValue(':type', $vehicule->getType());
        $query->bindValue(':autonomie', $vehicule->getAutonomie());
        $query->bindValue(':statut', $vehicule->getStatut());
        $query->execute();
    }

    public function modifierVehicule($id, $vehicule) {
        // Check for duplicate immatriculation
        $checkSql = "SELECT COUNT(*) FROM vehicules WHERE Immatriculation = :immatriculation AND id_vehicule != :id";
        $checkReq = $this->db->prepare($checkSql);
        $checkReq->bindValue(':immatriculation', $vehicule->getImmatriculation());
        $checkReq->bindValue(':id', $id);
        $checkReq->execute();
        $count = $checkReq->fetchColumn();
    
        if ($count > 0) {
            throw new Exception("L'immatriculation existe déjà.");
        }
    
        // Proceed with the update if no duplicates are found
        $sql = "UPDATE vehicules SET Immatriculation=:immatriculation, Type=:type, Autonomie=:autonomie, Statut=:statut WHERE id_vehicule=:id";
        $req = $this->db->prepare($sql);
        $req->bindValue(':id', $id);
        $req->bindValue(':immatriculation', $vehicule->getImmatriculation());
        $req->bindValue(':type', $vehicule->getType());
        $req->bindValue(':autonomie', $vehicule->getAutonomie());
        $req->bindValue(':statut', $vehicule->getStatut());
        $req->execute();
    }

    public function supprimerVehicule($id) {
        try {
            // Supprimer d'abord les enregistrements associés
            $deleteEntretienSql = "DELETE FROM entretien_vehicules WHERE id_vehicule = :id";
            $stmt = $this->db->prepare($deleteEntretienSql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
    
            // Ensuite, supprimer le véhicule
            $sql = "DELETE FROM vehicules WHERE id_vehicule = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return true; // Retourne vrai si la suppression a réussi
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression : " . $e->getMessage());
            return false; // Retourne faux en cas d'erreur
        }
    }

    public function rechercherVehicule($searchTerm = '') {
        $query = "SELECT * FROM vehicules";
        if (!empty($searchTerm)) {
            $query .= " WHERE Immatriculation LIKE :searchTerm";
        }
        $stmt = $this->db->prepare($query);
        if (!empty($searchTerm)) {
            $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%');
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenirStatistiques() {
        $sql = "SELECT Statut, COUNT(*) as count FROM vehicules GROUP BY Statut";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $statistiques = [
            'Available' => 0,
            'In Service' => 0,
            'In Maintenance' => 0
        ];

        foreach ($resultats as $row) {
            $statistiques[$row['Statut']] = (int)$row['count'];
        }

        return $statistiques;
    }
}
?>