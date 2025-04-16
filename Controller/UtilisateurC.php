<?php
require_once '../config/config.php'; // Connexion à la base de données
require_once '../Model/Utilisateur.php';

class UtilisateurC {
    private $pdo;

    public function __construct() {
        // Initialize the PDO instance
        $this->pdo = config::getConnexion();
    }

    // Public method to access the PDO instance
    public function getPDO() {
        return $this->pdo;
    }

   public function ajouterUtilisateur($utilisateur) {
    // Construct the SQL query with string concatenation
    $sql = "INSERT INTO Utilisateurs (Nom, Prénom, Email, Mot_de_passe, Type) 
            VALUES ('" . $utilisateur->getNom() . "',
                    '" . $utilisateur->getPrenom() . "',
                    '" . $utilisateur->getEmail() . "',
                    '" . $utilisateur->getMotDePasse() . "',
                    '" . $utilisateur->getType() . "')";
    
    // Execute the query directly
    $this->pdo->query($sql);
}

    public function getUtilisateur($id) {
        $sql = "SELECT * FROM Utilisateurs WHERE id_utilisateur = :id_utilisateur";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_utilisateur' => $id]); // ✅ $id in PHP, but id_utilisateur in SQL
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function updateUserType($id, $utilisateur) {
        try {
            // Start a transaction
            $this->pdo->beginTransaction();
    
            // Step 1: Get the current user type
            $currentTypeQuery = "SELECT Type FROM Utilisateurs WHERE id_utilisateur = :id";
            $stmt = $this->pdo->prepare($currentTypeQuery);
            $stmt->execute([':id' => $id]);
            $currentType = $stmt->fetchColumn();
    
            if ($currentType === false) {
                throw new Exception("User not found.");
            }
    
            // Step 2: Update the Utilisateur table with new details
            $updateQuery = "UPDATE Utilisateurs 
                            SET Nom = :nom,
                                Prénom = :prenom,
                                Email = :email,
                                Mot_de_passe = :mot_de_passe,
                                Type = :type
                            WHERE id_utilisateur = :id_utilisateur";
            $stmt = $this->pdo->prepare($updateQuery);
            $stmt->execute([
                ':nom' => $utilisateur->getNom(),
                ':prenom' => $utilisateur->getPrenom(),
                ':email' => $utilisateur->getEmail(),
                ':mot_de_passe' => $utilisateur->getMotDePasse(),
                ':type' => $utilisateur->getType(),
                ':id_utilisateur' => $id
            ]);
    
            // Step 3: Delete the user from the current child table based on their old type
            if ($currentType === 'Client') {
                $deleteQuery = "DELETE FROM Clients WHERE id_client = :id";
            } elseif ($currentType === 'Livreur') {
                $deleteQuery = "DELETE FROM Livreurs WHERE id_livreur = :id";
            } elseif ($currentType === 'Admin') {
                $deleteQuery = "DELETE FROM Admins WHERE id_admin = :id";
            }
    
            // Delete the user from the previous type's table
            $deleteStmt = $this->pdo->prepare($deleteQuery);
            $deleteStmt->execute([':id' => $id]);
    
            // Step 4: Insert the user into the appropriate child table based on the new type
            if ($utilisateur->getType() === 'Client') {
                $insertQuery = "INSERT INTO Clients (id_client) VALUES (:id)";
            } elseif ($utilisateur->getType() === 'Livreur') {
                // Assuming 'Statut' is a required field for the 'Livreur' table
                $insertQuery = "INSERT INTO Livreurs (id_livreur, Statut) VALUES (:id, 'Disponible')";
            } elseif ($utilisateur->getType() === 'Admin') {
                $insertQuery = "INSERT INTO Admins (id_admin) VALUES (:id)";
            }
    
            // Insert into the new child table
            $insertStmt = $this->pdo->prepare($insertQuery);
            $insertStmt->execute([':id' => $id]);
    
            // Commit the transaction
            $this->pdo->commit();
    
            return true; // Successfully updated
        } catch (Exception $e) {
            // Rollback the transaction if an error occurs
            $this->pdo->rollBack();
            throw $e; // Rethrow the exception
        }
    }
    
    public function deleteUtilisateur($id) {
        $sql = "DELETE FROM Utilisateurs WHERE id_utilisateur = :id_utilisateur";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_utilisateur' => $id]);
    }

    public function getAllUtilisateurs() {
        $sql = "SELECT * FROM Utilisateurs";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
