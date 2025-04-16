<?php
require_once '../../../config/config.php'; // Include the database connection

header('Content-Type: application/json');

try {
    $conn = config::getConnexion();
    $sql = "SELECT id_livraison, id_livreur, Adresse_livraison, latitude, longitude FROM livraisons";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $livraisonData = $stmt->fetchAll();

    echo json_encode($livraisonData ?: ["message" => "No data found"]);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
