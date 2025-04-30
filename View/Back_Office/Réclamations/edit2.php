<?php
include '../../../Controller/ReponsesAdminC.php';

if (isset($_POST['id_reponse'], $_POST['Reponse'])) {
    $rc = new ReponsesAdminC();
    $id = $_POST['id_reponse'];
    $newResponse = $_POST['Reponse'];
    $rc->modifierReponse($id, $newResponse);
}

header('Location: claims.php');
exit;
