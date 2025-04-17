<?php
include '../../../Controller/ReponsesAdminC.php';

if (isset($_GET['id_reponse'])) {
    $pc = new ReponsesAdminC();
    $pc->deleteReponse(intval($_GET['id_reponse']));
}

header('Location: ListeReponses.php');
exit();
?>
