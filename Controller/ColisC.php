<?php
require_once '../../../Model/Colis.php';  // Include the Colis model    
require_once '../../../config/config.php';  // Include the config file for database connection
class ColisC {

    public function ajouterColis($colis) {
        $pdo = config::getConnexion();  // Get the PDO connection

        $sql = "INSERT INTO colis (nom_destinataire, phone1, phone2, designation, nombre_pieces, poids_kg, type_colis, commentaires) 
                VALUES (:nom_destinataire, :phone1, :phone2, :designation, :nombre_pieces, :poids_kg, :type_colis, :commentaires)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nom_destinataire' => $colis->getNomDestinataire(),
            ':phone1'           => $colis->getPhone1(),
            ':phone2'           => $colis->getPhone2(),
            ':designation'      => $colis->getDesignation(),
            ':nombre_pieces'    => $colis->getNombrePieces(),
            ':poids_kg'         => $colis->getPoidsKg(),
            ':type_colis'       => $colis->getTypeColis(),
            ':commentaires'     => $colis->getCommentaires()
        ]);
    }

    public function afficherColis() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM colis");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function supprimerColis($id_colis) {
        global $pdo;
        $sql = "DELETE FROM colis WHERE id_colis = :id_colis";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_colis' => $id_colis]);
    }

    public function modifierColis($colis, $id_colis) {
        global $pdo;
        $sql = "UPDATE colis SET 
                nom_destinataire = :nom_destinataire,
                phone1 = :phone1,
                phone2 = :phone2,
                designation = :designation,
                nombre_pieces = :nombre_pieces,
                poids_kg = :poids_kg,
                type_colis = :type_colis,
                commentaires = :commentaires
                WHERE id_colis = :id_colis";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nom_destinataire' => $colis->getNomDestinataire(),
            ':phone1'           => $colis->getPhone1(),
            ':phone2'           => $colis->getPhone2(),
            ':designation'      => $colis->getDesignation(),
            ':nombre_pieces'    => $colis->getNombrePieces(),
            ':poids_kg'         => $colis->getPoidsKg(),
            ':type_colis'       => $colis->getTypeColis(),
            ':commentaires'     => $colis->getCommentaires(),
            ':id_colis'         => $id_colis
        ]);
    }
}
?>
