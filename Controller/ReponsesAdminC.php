<?php

require_once '../../config/config.php';
require_once 'ReclamationC.php';

class ReponsesAdminC {
    public function listeReponses(): array {
        $db = config::getConnexion();
        try {
            $liste = $db->query("SELECT * FROM reponses_admin");
            return $liste->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die("Erreur: " . $e->getMessage());
        }
    }

    public function deleteReponse(int $id_reponse): bool {
        $db = config::getConnexion();
        try {
            // Récupérer l'ID de la réclamation avant de supprimer la réponse
            $stmt = $db->prepare("SELECT id_reclamation FROM reponses_admin WHERE id_reponse = :id_reponse");
            $stmt->execute(['id_reponse' => $id_reponse]);
            $reponse = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Supprimer la réponse
            $req = $db->prepare("DELETE FROM reponses_admin WHERE id_reponse = :id_reponse");
            $req->execute(['id_reponse' => $id_reponse]);
    
            // Si la réclamation n'a plus de réponse, mettre son statut à "En cours"
            if ($reponse) {
                $recC = new ReclamationC();
                $recC->changerStatut($reponse['id_reclamation'], 'En cours');
            }
    
            return $req->rowCount() > 0;
        } catch (Exception $e) {
            die("Erreur: " . $e->getMessage());
        }
    }
    

    public function ajouterReponse(ReponsesAdmin $reponse): int {
        $db = config::getConnexion();
        try {
            $req = $db->prepare("
                INSERT INTO reponses_admin (id_reclamation, id_admin, Reponse, Date_reponse) 
                VALUES (:id_reclamation, :id_admin, :Reponse, :Date_reponse)
            ");
            $req->execute([
                'id_reclamation' => $reponse->getIdReclamation(),
                'id_admin'       => $reponse->getIdAdmin(),
                'Reponse'        => $reponse->getReponse(),
                'Date_reponse'   => $reponse->getDateReponse(),
            ]);
            $reclamationC = new ReclamationC();
            $reclamationC->changerStatut($reponse->getIdReclamation(), 'Résolu');
            return $db->lastInsertId();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getReponseById(int $id_reponse): ?array {
        $db = config::getConnexion();
        try {
            $req = $db->prepare("SELECT * FROM reponses_admin WHERE id_reponse = :id_reponse");
            $req->execute(['id_reponse' => $id_reponse]);
            $reponse = $req->fetch(PDO::FETCH_ASSOC);
            return $reponse ?: null;
        } catch (Exception $e) {
            die("Erreur: " . $e->getMessage());
        }
    }

    public function updateReponse(ReponsesAdmin $reponse, int $id_reponse): bool {
        $db = config::getConnexion();
        try {
            // Mettre à jour la réponse
            $req = $db->prepare("
                UPDATE reponses_admin 
                SET id_reclamation = :id_reclamation, id_admin = :id_admin, Reponse = :Reponse, Date_reponse = :Date_reponse
                WHERE id_reponse = :id_reponse
            ");
            $req->execute([
                'id_reclamation' => $reponse->getIdReclamation(),
                'id_admin'       => $reponse->getIdAdmin(),
                'Reponse'        => $reponse->getReponse(),
                'Date_reponse'   => $reponse->getDateReponse(),
                'id_reponse'     => $id_reponse
            ]);
    
            // Si l'ID de la réclamation a changé, mettre son statut à "En cours"
            if ($req->rowCount() > 0) {
                $recC = new ReclamationC();
                $recC->changerStatut($reponse->getIdReclamation(), 'En cours');
            }
    
            return $req->rowCount() > 0;
        } catch (Exception $e) {
            die("Erreur: " . $e->getMessage());
        }
    }
    
}
?>
