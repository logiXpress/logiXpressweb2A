<?php
require_once '../config/config.php';
require_once '../Model/Livreur.php';
require_once '../ControllerUtilisateurC.php';

class LivreurC {
    private $pdo;

    public function __construct() {
        $this->pdo = config::getConnexion();
    }

    public function ajouterLivreur(Livreur $livreur) {
        try {
            // Start a transaction
            $this->pdo->beginTransaction();
    
            // Step 1: Add the user to the 'Utilisateurs' table using the ajouter method
            $utilisateurC = new UtilisateurC(); // Instantiate UtilisateurC to call the ajouter method
            $utilisateurC->ajouterUtilisateur($livreur); // Adds the user to the Utilisateurs table
            
            // Step 2: Get the id_utilisateur (assuming it's auto-generated and we want to get the last inserted id)
            $id_utilisateur = $this->pdo->lastInsertId();
    
            // Step 3: Update the 'Livreurs' table to add the 'Statut' and 'id_vehicule' for this user
            $query = "
                UPDATE Livreurs 
                SET Statut = ?, id_vehicule = ? 
                WHERE id_livreur = ?
            ";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                $livreur->getStatut(),
                $livreur->getIdVehicule() ?: NULL,  // If no id_vehicule is provided, set it to NULL
                $id_utilisateur
            ]);
    
            // Commit the transaction
            $this->pdo->commit();
    
            echo "✅ Livreur ajouté avec succès !";
    
        } catch (Exception $e) {
            // Rollback the transaction if an error occurs
            $this->pdo->rollBack();
            echo "❌ Erreur: " . $e->getMessage();
        }
    }
    
 

    public function getLivreurById($id) {
        $sql = "SELECT * FROM Utilisateurs u INNER JOIN Livreurs l ON u.id_utilisateur = l.id_livreur WHERE u.id_utilisateur = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllLivreurs() {
        $sql = "SELECT Utilisateurs.*, Livreurs.Statut, Livreurs.id_vehicule 
                FROM Utilisateurs 
                INNER JOIN Livreurs ON Utilisateurs.id_utilisateur = Livreurs.id_livreur";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function modifierLivreur($id_livreur, $nom, $prenom, $email, $statut, $id_vehicule, $mot_de_passe) {
        $sql = "UPDATE Utilisateurs u
                INNER JOIN Livreurs l ON u.id_utilisateur = l.id_livreur
                SET u.Nom = :nom, u.Prénom = :prenom, u.Email = :email, u.Mot_de_passe = :mot_de_passe, l.Statut = :statut, l.id_vehicule = :id_vehicule
                WHERE u.id_utilisateur = :id_livreur";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':mot_de_passe' => $mot_de_passe, // Secure password handling
            ':statut' => $statut,
            ':id_vehicule' => $id_vehicule,
            ':id_livreur' => $id_livreur
        ]);
    }
    public function getLivreursLocation() {
        $sql = "SELECT id_livreur, latitude, longitude FROM livreurs";
        $db = config::getConnexion();
        $query = $db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}
?>
