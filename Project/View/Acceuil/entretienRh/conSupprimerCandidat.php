<?php
session_start();
require_once __DIR__ . '/../../../Controller/candidatC.php';

try {
    
    error_log("POST data: " . print_r($_POST, true));

    
    if (!isset($_POST['idCandidat']) || !is_numeric($_POST['idCandidat'])) {
        throw new Exception("Invalid candidate ID.");
    }
    $idCandidat = (int)$_POST['idCandidat'];
    

    if ($idCandidat === null) {
        throw new Exception("Invalid candidate ID.");
    }

    
    error_log("Processing deletion for idCandidat: $idCandidat");

    
    $candidatC = new CandidatC();
    $candidate = $candidatC->ChercherCandidatByID($idCandidat);
    if ($candidate === null) {
        throw new Exception("Candidate not found.");
    }

    
    error_log("Candidate data: " . print_r($candidate, true));

    
    if (!empty($candidate['CV']) && file_exists($candidate['CV'])) {
        unlink($candidate['CV']);
    }


    $candidatC->supprimerCandidat($idCandidat);

    $_SESSION['success'] = "Candidate with ID $idCandidat deleted successfully.";
    header("Location: dataTableCandidat.php");
    exit();

} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: dataTableCandidat.php");
    exit();
}
?>