<?php
require_once '../config.php'; // Include the database connection

header('Content-Type: application/json');

// Include your config.php for the PDO connection

// Get the database connection using the getConnexion method
$conn = config::getConnexion();

// Query to get the livraison data
$sql = "SELECT id_livraison,id_livreur,Adresse_livraison, latitude, longitude FROM livraisons"; // Replace 'livraison' with your table name
$stmt = $conn->prepare($sql);
$stmt->execute();

// Fetch the results
$livraisonData = $stmt->fetchAll();

// Check if there is any livraison data
if ($livraisonData) {
    // Output the livraison data as JSON
    echo json_encode($livraisonData);
} else {
    echo json_encode(array("message" => "No data found"));
}
?>
