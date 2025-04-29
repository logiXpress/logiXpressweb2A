<?php
require_once '../../../config/config.php';
require_once '../../../Model/Livraison.php';
require_once '../../../Controller/LivraisonC.php';
if (isset($_GET['id_livraison'])) {
    $livraisonC = new LivraisonC();
    $livraisonC->supprimerLivraison($_GET['id_livraison']);
    header("Location: ListeLiv.php");
}
?>
