
<?php
require_once '../../../config/config.php';
require_once '../../../Model/Livraison.php';
require_once '../../../Controller/LivraisonC.php';

$livraisonC = new LivraisonC();
$livraisons = $livraisonC->afficherLivraisons(); 

header("Location: ListeLiv.php");

?>

