
<?php require_once(__DIR__ . '/../config/config.php');

class MessagesReclamationC {
    public function ajouterMessage($idReclamation, $idUtilisateur, $contenu) {
        $sql = "INSERT INTO messages_reclamation (id_reclamation, id_utilisateur, contenu) VALUES (:id_reclamation, :id_utilisateur, :contenu)";
        $db = config::getConnexion();
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'id_reclamation' => $idReclamation,
            'id_utilisateur' => $idUtilisateur,
            'contenu' => $contenu
        ]);
    }

    public function recupererMessages($idReclamation) {
        $sql = "SELECT m.*, u.nom, u.type FROM messages_reclamation m JOIN utilisateurs u ON m.id_utilisateur = u.id_utilisateur WHERE id_reclamation = :id_reclamation ORDER BY date_envoi ASC";
        $db = config::getConnexion();
        $stmt = $db->prepare($sql);
        $stmt->execute(['id_reclamation' => $idReclamation]);
        return $stmt->fetchAll();
    }
}?>
