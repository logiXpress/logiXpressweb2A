<?php
session_start();
require_once __DIR__ . '/../../../Controller/candidatC.php';

try {
    // Debug: Log all POST data
    error_log("POST data: " . print_r($_POST, true));

    // Find the idCandidat in POST data (since name is now dynamic)
    $idCandidat = null;
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'idCandidat_') === 0 && is_numeric($value)) {
            $idCandidat = (int)$value;
            break;
        }
    }

    if ($idCandidat === null) {
        throw new Exception("Invalid candidate ID.");
    }

    // Debug: Log the idCandidat being processed
    error_log("Processing deletion for idCandidat: $idCandidat");

    // Fetch the candidate to get the CV path and verify
    $candidatC = new CandidatC();
    $candidate = $candidatC->ChercherCandidatByID($idCandidat);
    if ($candidate === null) {
        throw new Exception("Candidate not found.");
    }

    // Debug: Log the candidate data
    error_log("Candidate data: " . print_r($candidate, true));

    // Delete the CV file if it exists
    if (!empty($candidate['CV']) && file_exists($candidate['CV'])) {
        unlink($candidate['CV']);
    }

    // Delete the candidate from the database
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