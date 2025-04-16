<?php
require_once '../config.php';
require_once "../Model/Livraison.php";

class LivraisonC {
    private $pdo;

    public function __construct() {
        $this->pdo = config::getConnexion();
    }

    // Ajouter une livraison
    public function ajouterLivraison($livraison) {
        $sql = "INSERT INTO Livraisons (id_client, id_livreur, Adresse_livraison, Etat, Montant, Statut_paiement, Mode_paiement, Description) 
                VALUES (:id_client, :id_livreur, :adresse_livraison, :etat, :montant, :statut_paiement, :mode_paiement ,:description)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id_client' => $livraison->getIdClient(),
            ':id_livreur' => $livraison->getIdLivreur(),
            ':adresse_livraison' => $livraison->getAdresseLivraison(),
            ':etat' => $livraison->getEtat(),
            ':montant' => $livraison->getMontant(),
            ':statut_paiement' => $livraison->getStatutPaiement(),
            ':mode_paiement' => $livraison->getModePaiement(),
            ':description' => $livraison->getdescription()

        ]);
    }

    // Afficher toutes les livraisons
    public function afficherLivraisons() {
        $sql = "SELECT * FROM Livraisons";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer une seule livraison
    public function getLivraison($id_livraison) {
        $sql = "SELECT * FROM Livraisons WHERE id_livraison = :id_livraison";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_livraison' => $id_livraison]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Modifier une livraison
    public function modifierLivraison($livraison, $id_livraison) {
        $sql = "UPDATE Livraisons SET id_client=:id_client, id_livreur=:id_livreur, Adresse_livraison=:adresse_livraison, 
                Etat=:etat, Montant=:montant, Statut_paiement=:statut_paiement, Mode_paiement=:mode_paiement,Description=:description
                WHERE id_livraison=:id_livraison";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id_client' => $livraison->getIdClient(),
            ':id_livreur' => $livraison->getIdLivreur(),
            ':adresse_livraison' => $livraison->getAdresseLivraison(),
            ':etat' => $livraison->getEtat(),
            ':montant' => $livraison->getMontant(),
            ':statut_paiement' => $livraison->getStatutPaiement(),
            ':mode_paiement' => $livraison->getModePaiement(),
            ':description' => $livraison->getdescription(),
            ':id_livraison' => $id_livraison
        ]);
    }

    public function modifierLivraisonClient($id_livraison, $adresse_livraison, $mode_paiement, $description) {
        $sql = "UPDATE Livraisons 
                SET Adresse_livraison = :adresse_livraison, 
                    Mode_paiement = :mode_paiement, 
                    Description = :description
                WHERE id_livraison = :id_livraison";
    
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id_livraison' => $id_livraison,
            ':adresse_livraison' => $adresse_livraison,
            ':mode_paiement' => $mode_paiement,
            ':description' => $description
        ]);
    }
    

    // Supprimer une livraison
    public function supprimerLivraison($id_livraison) {
        $sql = "DELETE FROM Livraisons WHERE id_livraison=:id_livraison";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_livraison' => $id_livraison]);
    }
    public function getLivraisonDetails($id_livraison) {
        $sql = "SELECT * FROM livraisons WHERE id_livraison = :id_livraison";
        $db = config::getConnexion();
        $query = $db->prepare($sql);
        $query->bindValue(":id_livraison", $id_livraison);
        $query->execute();
        return $query->fetch();
    }
}
?>
