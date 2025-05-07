<?php
require_once '../../../config/config.php';
require_once '../../../Model/Livraison.php';
require_once '../../../Controller/LivraisonC.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $id_livraison = filter_input(INPUT_POST, 'id_livraison', FILTER_SANITIZE_NUMBER_INT);
        $adresse_livraison = filter_input(INPUT_POST, 'adresse_livraison', FILTER_SANITIZE_STRING);
        $mode_paiement = filter_input(INPUT_POST, 'mode_paiement', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);

        $livraisonC = new LivraisonC();
        $success = $livraisonC->modifierLivraisonClient($id_livraison, $adresse_livraison, $mode_paiement, $description);

        if ($success) {
            header("Location: ListeLiv.php?success=1");
        } else {
            header("Location: modifierlivraison_client.php?id_livraison=$id_livraison&error=1");
        }
        exit();
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
