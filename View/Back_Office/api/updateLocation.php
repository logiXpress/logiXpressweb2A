<?php
// updateLocation.php

// Firebase configuration
$firebaseUrl = "https://project-1e2f9-default-rtdb.firebaseio.com/locations.json";  // Replace with your Firebase URL

// MySQL configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db"; // Replace with your database name

// Create MySQL connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check MySQL connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch last location from Firebase
function getLastLocationFromFirebase($firebaseUrl)
{
    // Get the latest data from Firebase
    $json = file_get_contents($firebaseUrl);
    $data = json_decode($json, true);

    // Check if data exists and retrieve the last location
    if ($data) {
        // Sort the data by timestamp and get the last entry
        $lastLocation = end($data);
        return $lastLocation;
    }

    return null; // Return null if no data
}

$lastLocation = getLastLocationFromFirebase($firebaseUrl);

if ($lastLocation) {
    $latitude = $lastLocation['latitude'];
    $longitude = $lastLocation['longitude'];
    $livreurId = 245; // Use your logic to set the livreur ID dynamically (e.g., 245 for testing)

    // SQL query to update the location in MySQL
    $sql = "UPDATE livreurs SET latitude = ?, longitude = ?, last_updated = NOW() WHERE id_livreur = ?";

    // Prepare and bind
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ddi", $latitude, $longitude, $livreurId);

    if ($stmt->execute()) {
        echo "Location updated successfully.";
    } else {
        echo "Error updating location: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "No location data found in Firebase.";
}

$conn->close();
