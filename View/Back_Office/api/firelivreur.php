<?php
// Include Firebase SDK and your PDO config class
require_once 'vendor/autoload.php';
require_once '../../../config/config.php';

use Kreait\Firebase\Factory;

// Firebase setup
$serviceAccountPath = __DIR__ . '/vendor/serviceAccount.json'; // Use absolute path for safety
$databaseUrl = 'https://project-1e2f9-default-rtdb.firebaseio.com'; // Correct Firebase URL

$firebase = (new Factory)
    ->withServiceAccount($serviceAccountPath)
    ->withDatabaseUri($databaseUrl);

$database = $firebase->createDatabase();

// Get PDO connection from config class
$pdo = config::getConnexion();

// Fetch all 'Livreur' users
$query = "SELECT id_utilisateur, Mot_de_passe FROM utilisateurs WHERE Type = 'Livreur'";
$stmt = $pdo->query($query);

// Loop through each livreur and insert them into Firebase
$livreurs = $stmt->fetchAll();
if (count($livreurs) > 0) {
    foreach ($livreurs as $livreur) {
        $livreurId = $livreur['id_utilisateur'];
        $password = $livreur['Mot_de_passe'];

        // Store the livreur in Firebase
        $livreurRef = $database->getReference('livreurs/' . $livreurId);
        $livreurRef->set([
            'password' => $password
        ]);

    }
} else {
}
?>
