<?php
require_once __DIR__ . '/../../../Controller/candidatC.php';


session_start(); // For potential error message passing

try {
    $CandidatC = new CandidatC();
    
    if (!isset($_POST["idCandidat"])) {
        throw new Exception("Missing candidate ID");
    }

    $id = filter_input(INPUT_POST, 'idCandidat', FILTER_VALIDATE_INT);
    
    if ($id === false || $id <= 0) {
        throw new Exception("Invalid candidate ID format");
    }

    if ($CandidatC->supprimerCandidat($id)) {
        $_SESSION['success_message'] = "Candidate deleted successfully";
    } else {
        throw new Exception("No candidate found with that ID");
    }
    
} catch (Exception $e) {
    $_SESSION['error_message'] = $e->getMessage();
} finally {
    header("Location: dataTableCandidat.php");
    exit;
}
?>