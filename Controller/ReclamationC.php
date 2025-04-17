<?php
require_once(__DIR__ . '/../config/config.php');



class ReclamationC {
    public function listeReclamations() {
        $db = config::getConnexion();
        try {
            return $db->query("SELECT * FROM reclamations")->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die("Erreur: " . $e->getMessage());
        }
    }

    public function deleteReclamation(int $id_reclamation): bool {
        $db = config::getConnexion();
        try {
            $req = $db->prepare("DELETE FROM reclamations WHERE id_reclamation = :id_reclamation");
            $req->execute(['id_reclamation' => $id_reclamation]);
            return $req->rowCount() > 0;
        } catch (Exception $e) {
            die("Erreur: " . $e->getMessage());
        }
    }

    public function ajouterReclamation(Reclamation $rec) {
        $db = config::getConnexion();
        try {
            $query = $db->prepare("INSERT INTO reclamations (id_client, Categorie, Description, Statut) VALUES (:id_client, :Categorie, :Description, 'In Progress')");
            $query->execute([
                'id_client' => $rec->getIdClient(),
                'Categorie' => $rec->getCategorie(),
                'Description' => $rec->getDescription()
            ]);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }


  
      public function getReclamationsByClientId($id_client) {
      $sql = "SELECT * FROM reclamations WHERE id_client = :id_client";
      $db = config::getConnexion();
      try {
        $query = $db->prepare($sql);
        $query->execute(['id_client' => $id_client]);
        return $query->fetchAll();
      } catch (Exception $e) {
        die('Erreur: ' . $e->getMessage());
      }
    }

    public function updateReclamation(Reclamation $reclamation, int $id_reclamation): bool {
        $db = config::getConnexion();
        try {
            $req = $db->prepare("
                UPDATE reclamations 
                SET id_client = :id_client, Categorie = :Categorie, Description = :Description, Statut = :Statut 
                WHERE id_reclamation = :id_reclamation
            ");
            $req->execute([
                'id_client'      => $reclamation->getIdClient(),
                'Categorie'      => $reclamation->getCategorie(),
                'Description'    => $reclamation->getDescription(),
                'Statut'         => $reclamation->getStatut(),
                'id_reclamation' => $id_reclamation
            ]);

            return $req->rowCount() > 0;
        } catch (Exception $e) {
            die("Erreur: " . $e->getMessage());
        }
    }
    public function changerStatut(int $id_reclamation, string $nouveauStatut) {
        $db = config::getConnexion();
        try {
            $query = $db->prepare("UPDATE reclamations SET Statut = :Statut WHERE id_reclamation = :id_reclamation");
            $query->execute([
                'Statut' => $nouveauStatut,
                'id_reclamation' => $id_reclamation
            ]);
        } catch (Exception $e) {
            die("Erreur: " . $e->getMessage());
        }
    }
    

public function getReclamationsSortedBy($id_client, $column, $direction) {
    $allowedColumns = ['id_reclamation', 'Categorie', 'Description'];
    $allowedDirections = ['ASC', 'DESC'];

    if (!in_array($column, $allowedColumns) || !in_array($direction, $allowedDirections)) {
        throw new Exception('Paramètres de tri invalides');
    }

    $sql = "SELECT * FROM reclamations WHERE id_client = :id_client ORDER BY $column $direction";
    $db = config::getConnexion();
    try {
        $query = $db->prepare($sql);
        $query->execute(['id_client' => $id_client]);
        return $query->fetchAll();
    } catch (Exception $e) {
        die('Erreur: ' . $e->getMessage());
    }
}}
?>