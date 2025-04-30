<?php
require_once '../../../Model/Vehicule.php';      
require_once '../../../config/config.php'; 
class VehiculeC {
    private $db;

    // Constructeur de la classe qui récupère la connexion de la base de données via Config
    public function __construct() {
        // Utiliser la méthode de Config pour récupérer la connexion à la base de données
        $this->db = Config::getConnexion();
    }
// Dans VehiculeC.php
public function getVehiculeById(string $id_vehicule) {
    // SQL pour récupérer un véhicule par immatriculation
    $sql = "SELECT * FROM vehicules WHERE id_vehicule = :id_vehicule";
    $db = config::getConnexion();
    $query = $db->prepare($sql);
    $query->bindValue(':id_vehicule', $id_vehicule);
    $query->execute();

    // Retourner le résultat sous forme de tableau associatif
    return $query->fetch(PDO::FETCH_ASSOC);
}

    // Méthode pour récupérer la liste des véhicules
    public function Listevehicules() {
        // Requête SQL pour récupérer tous les véhicules
        $sql = "SELECT * FROM vehicules";
    
        try {
            // Exécuter la requête
            $stmt = $this->db->query($sql);
    
            // Retourner tous les résultats sous forme de tableau associatif
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Gérer l'erreur en cas de problème avec la base de données
            echo "Erreur lors de la récupération des véhicules : " . $e->getMessage();
            return [];
        }
    }

    // Méthode pour ajouter un véhicule
    public function ajouterVehicule($vehicule) {
        $db = config::getConnexion();
    
        // Vérifier si l'immatriculation existe déjà
        $checkQuery = $db->prepare("SELECT COUNT(*) FROM vehicules WHERE Immatriculation = :immatriculation");
        $checkQuery->bindValue(':immatriculation', $vehicule->getImmatriculation());
        $checkQuery->execute();
        $count = $checkQuery->fetchColumn();
    
        if ($count > 0) {
            // Gérer le cas de doublon
            echo "<script>alert('Erreur : cette immatriculation existe déjà.');</script>";
            return;
        }
    
        // Sinon on peut insérer
        $query = $db->prepare("INSERT INTO vehicules (Immatriculation, Type, Autonomie, Statut)
                               VALUES (:immatriculation, :type, :autonomie, :statut)");
        $query->bindValue(':immatriculation', $vehicule->getImmatriculation());
        $query->bindValue(':type', $vehicule->getType());
        $query->bindValue(':autonomie', $vehicule->getAutonomie());
        $query->bindValue(':statut', $vehicule->getStatut());
    
        $query->execute();
    }
    
    public function modifierVehicule($id, $vehicule) {
        $sql = "UPDATE vehicules SET Immatriculation=:immatriculation, Type=:type, Autonomie=:autonomie, Statut=:statut WHERE id_vehicule=:id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);
        $req->bindValue(':immatriculation', $vehicule->getImmatriculation());
        $req->bindValue(':type', $vehicule->getType());
        $req->bindValue(':autonomie', $vehicule->getAutonomie());
        $req->bindValue(':statut', $vehicule->getStatut());
        $req->execute();
    }

    // Méthode pour supprimer un véhicule
    public function supprimerVehicule(int $id_vehicule) {
        // Correction du nom de la table : vehicules au lieu de vehicule
        $sql = "DELETE FROM vehicules WHERE id_vehicule = :id_vehicule";
        $query = $this->db->prepare($sql);
        $query->bindValue(':id_vehicule', $id_vehicule);
        return $query->execute();
    }
    public function rechercherVehicule($searchTerm = '') {
        // Préparer la requête de base
        $query = "SELECT * FROM vehicules";
        
        // Ajouter la clause WHERE si le terme de recherche n'est pas vide
        if (!empty($searchTerm)) {
            $query .= " WHERE Immatriculation LIKE :searchTerm";
        }
    
        // Préparer la requête
        $stmt = $this->db->prepare($query);
    
        // Lier le terme de recherche si nécessaire
        if (!empty($searchTerm)) {
            $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%');
        }
    
        // Exécuter la requête
        $stmt->execute();
    
        // Retourner tous les résultats
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Méthode pour modifier un véhicule
    // Méthode pour modifier un véhicule

}    
?>
