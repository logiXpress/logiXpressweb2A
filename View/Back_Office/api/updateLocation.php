<?php
require_once '../../../config/config.php';

// Your Firebase Realtime Database URL (to RealTimeTracking)
$firebaseUrl = "https://project-1e2f9-default-rtdb.firebaseio.com/RealTimeTracking.json";

// Fetch Firebase data
$response = file_get_contents($firebaseUrl);

if ($response === FALSE) {
    die('Error fetching Firebase data.');
}

// Decode JSON
$data = json_decode($response, true);

if (!$data) {
    die('Invalid JSON received from Firebase.');
}

try {
    $pdo = config::getConnexion();

    foreach ($data as $livreurId => $locations) {
        if (is_array($locations)) {
            $latestLocation = null;
            $latestTimestamp = 0;

            foreach ($locations as $locationData) {
                if (isset($locationData['timestamp'])) {
                    $timestamp = strtotime($locationData['timestamp']);
                    if ($timestamp > $latestTimestamp) {
                        $latestTimestamp = $timestamp;
                        $latestLocation = $locationData;
                    }
                }
            }

            if ($latestLocation) {
                $latitude = $latestLocation['latitude'];
                $longitude = $latestLocation['longitude'];

                $stmt = $pdo->prepare("UPDATE livreurs SET latitude = ?, longitude = ?, last_updated = NOW() WHERE id_livreur = ?");
                $stmt->execute([$latitude, $longitude, $livreurId]);

                echo "Updated Livreur ID $livreurId with lat=$latitude, lon=$longitude<br>";
            }
        }
    }
} catch (Exception $e) {
    echo "Database error: " . $e->getMessage();
}
?>
