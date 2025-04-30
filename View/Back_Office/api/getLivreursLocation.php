<?php
require_once '../../../config/config.php'; // Include the database connection

header('Content-Type: application/json');

try {
    $pdo = config::getConnexion();
    $sql = "SELECT id_livreur, Statut, latitude, longitude FROM Livreurs WHERE latitude IS NOT NULL AND longitude IS NOT NULL";
    $stmt = $pdo->query($sql);
    $livreurs = $stmt->fetchAll();

    echo json_encode($livreurs);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
