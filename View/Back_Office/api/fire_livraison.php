<?php
// Include Firebase SDK and your PDO config class
require_once 'vendor/autoload.php';
require_once '../../../config/config.php';

use Kreait\Firebase\Factory;

// Firebase setup
$serviceAccountPath = __DIR__ . '/vendor/serviceAccount.json'; // Use absolute path
$databaseUrl = 'https://project-1e2f9-default-rtdb.firebaseio.com'; // Your Firebase DB URL

$firebase = (new Factory)
    ->withServiceAccount($serviceAccountPath)
    ->withDatabaseUri($databaseUrl);

$database = $firebase->createDatabase();

// Get PDO connection
$pdo = config::getConnexion();

// Fetch all 'Livraisons'
$query = "SELECT id_livraison, Adresse_livraison, longitude, latitude,id_livreur FROM livraisons"; 
$stmt = $pdo->query($query);

// Loop through each livraison and insert into Firebase
$livraisons = $stmt->fetchAll();
if (count($livraisons) > 0) {
    foreach ($livraisons as $livraison) {
        $idLivraison = $livraison['id_livraison'];
        $adresse = $livraison['Adresse_livraison'];
        $longitude = $livraison['longitude'];
        $latitude = $livraison['latitude'];
        $id_livreur = $livraison['id_livreur'];

        // Store the livraison in Firebase
        $livraisonRef = $database->getReference('livraisons/' . $idLivraison);
        $livraisonRef->set([
            'adresse' => $adresse,
            'longitude' => $longitude,
            'id_livreur' => $id_livreur,
            'latitude' => $latitude
        ]);
    }
} else {
    // No livraisons found
}
?>
