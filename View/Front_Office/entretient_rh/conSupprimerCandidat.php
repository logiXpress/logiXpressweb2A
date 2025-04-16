<?php
require "../../../Controller/candidatC.php";

$CandidatC = new CandidatC();

if (isset($_POST["idCandidat"]) && is_numeric($_POST["idCandidat"])) {
    $id = intval($_POST["idCandidat"]); 

    if ($CandidatC->supprimerCandidat($id)) {
        header("Location: dataTableCandidat.php");
        exit; 
    } else {
        echo "Error: Candidate could not be deleted.";
    }
} else {
    echo "Error: Invalid candidate ID.";
}
?>