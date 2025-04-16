<?php
require "../../../controller/entretienC.php"; 

$entretienC = new EntretienC();

if (isset($_POST["idEntretien"]) && is_numeric($_POST["idEntretien"])) {
    $id = intval($_POST["idEntretien"]); 

   $result=$entretienC->supprimerEntretien($id);
   if($result==true)
   {
        header("Location: TableEntretien.php");
        exit; }
    
}
?>