<?php
include '../../../Controller/ReclamationC.php';

if (isset($_GET['id_reclamation'])) {
    $pc = new ReclamationC();
    $pc->deleteReclamation(intval($_GET['id_reclamation']));
}

header('Location: claim.php');
exit();
?>
