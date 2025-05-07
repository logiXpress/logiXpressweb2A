<?php
include '../Controller/UtilisateurC.php';

if (isset($_GET["id"])) {
    $uc = new UtilisateurC();
    $uc->deleteUtilisateur($_GET["id"]);
}

header('Location: listeUtilisateurs.php');
exit();
?>
