<?php


class UtilisateurC
{
    private $pdo;

    public function __construct()
    {
        // Initialize the PDO instance
        $this->pdo = config::getConnexion();
    }

    // Public method to access the PDO instance
    public function getPDO()
    {
        return $this->pdo;
    }

    public function ajouterUtilisateur($utilisateur) {
        $email = $utilisateur->getEmail();
    
        $checkQuery = $this->pdo->prepare("SELECT COUNT(*) FROM Utilisateurs WHERE Email = :email");
        $checkQuery->bindParam(':email', $email);
        $checkQuery->execute();
    
        if ($checkQuery->fetchColumn() > 0) {
            throw new Exception("Cet email est déjà utilisé !");
        }
    
        $query = "INSERT INTO Utilisateurs (Nom, Prénom, Email, Mot_de_passe, Type, phone_number) 
                  VALUES (:nom, :prenom, :email, :mot_de_passe, :type, :phone_number)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':nom', $utilisateur->getNom());
        $stmt->bindParam(':prenom', $utilisateur->getPrenom());
        $stmt->bindParam(':email', $utilisateur->getEmail());
        $stmt->bindParam(':mot_de_passe', $utilisateur->getMotDePasse());
        $stmt->bindParam(':type', $utilisateur->getType());
        $stmt->bindParam(':phone_number', $utilisateur->getphone());
        $stmt->execute();
    }
    
    
    public function getUtilisateur($id)
    {
        $sql = "SELECT * FROM Utilisateurs WHERE id_utilisateur = :id_utilisateur";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_utilisateur' => $id]); // ✅ $id in PHP, but id_utilisateur in SQL
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function modifierUtilisateur($utilisateur)
    {
        try {
            // Step 1: Start a transaction
            $this->pdo->beginTransaction();
    
            // Step 2: Update the user's details in the Utilisateurs table
            $sql = "UPDATE Utilisateurs SET 
                        Nom = :nom,
                        Prénom = :prenom,
                        Email = :email,
                        Mot_de_passe = :mot_de_passe,
                        phone_number = :phone_number,
                        Type = :type
                    WHERE id_utilisateur = :id_utilisateur";
    
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':nom' => $utilisateur->getNom(),
                ':prenom' => $utilisateur->getPrenom(),
                ':email' => $utilisateur->getEmail(),
                ':mot_de_passe' => $utilisateur->getMotDePasse(),
                ':phone_number' => $utilisateur->getphone(),
                ':type' => $utilisateur->getType(),
                ':id_utilisateur' => $utilisateur->getId()
            ]);
    
            // Step 3: Check if the user type has changed and handle accordingly
            $currentTypeQuery = "SELECT Type FROM Utilisateurs WHERE id_utilisateur = :id";
            $stmt = $this->pdo->prepare($currentTypeQuery);
            $stmt->execute([':id' => $utilisateur->getId()]);
            $currentType = $stmt->fetchColumn();
    
            if ($currentType === false) {
                throw new Exception("User not found.");
            }
    
            // Step 4: If user type has changed, update the associated child table
            if ($utilisateur->getType() !== $currentType) {
                // Delete user from the old table
                if ($currentType === 'Client') {
                    $deleteQuery = "DELETE FROM Clients WHERE id_client = :id";
                } elseif ($currentType === 'Livreur') {
                    $deleteQuery = "DELETE FROM Livreurs WHERE id_livreur = :id";
                } elseif ($currentType === 'Admin') {
                    $deleteQuery = "DELETE FROM Admins WHERE id_admin = :id";
                }
                $deleteStmt = $this->pdo->prepare($deleteQuery);
                $deleteStmt->execute([':id' => $utilisateur->getId()]);
    
                // Insert the user into the new table based on their updated type
                if ($utilisateur->getType() === 'Client') {
                    $insertQuery = "INSERT INTO Clients (id_client) VALUES (:id)";
                } elseif ($utilisateur->getType() === 'Livreur') {
                    $insertQuery = "INSERT INTO Livreurs (id_livreur, Statut) VALUES (:id, 'Disponible')";
                } elseif ($utilisateur->getType() === 'Admin') {
                    $insertQuery = "INSERT INTO Admins (id_admin) VALUES (:id)";
                }
    
                $insertStmt = $this->pdo->prepare($insertQuery);
                $insertStmt->execute([':id' => $utilisateur->getId()]);
            }
    
            // Step 5: Commit the transaction
            $this->pdo->commit();
            return true; // Successfully updated
        } catch (Exception $e) {
            // Step 6: Rollback the transaction if an error occurs
            $this->pdo->rollBack();
            throw $e; // Rethrow the exception for further handling
        }
    }
    
    public function updateUserType($id, $utilisateur)
    {
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
                                phone_number = :phone_number,
                                Type = :type
                            WHERE id_utilisateur = :id_utilisateur";
            $stmt = $this->pdo->prepare($updateQuery);
            $stmt->execute([
                ':nom' => $utilisateur->getNom(),
                ':prenom' => $utilisateur->getPrenom(),
                ':email' => $utilisateur->getEmail(),
                ':mot_de_passe' => $utilisateur->getMotDePasse(),
                ':phone_number' => $utilisateur->getphone(),
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

    public function deleteUtilisateur($id)
    {
        $sql = "DELETE FROM Utilisateurs WHERE id_utilisateur = :id_utilisateur";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_utilisateur' => $id]);
    }

    public function getAllUtilisateurs()
    {
        $sql = "SELECT * FROM Utilisateurs";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
