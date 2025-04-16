<?php
// Set response type to JSON
header('Content-Type: application/json');

// Database connection (replace with your own database credentials)
$host = 'localhost'; // Database host
$dbname = 'db'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

// Create a new PDO instance for the database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Get raw POST data
$data = file_get_contents('php://input');

// Log the raw data received for debugging
error_log("Received data: " . $data);

// Decode JSON data
$locationData = json_decode($data, true);

// Log the decoded data to check structure
error_log("Decoded data: " . print_r($locationData, true));

// Check if the necessary fields are present
if (isset($locationData['id_livreur'], $locationData['latitude'], $locationData['longitude'])) {
    $id_livreur = $locationData['id_livreur'];
    $latitude = $locationData['latitude'];
    $longitude = $locationData['longitude'];

    // Prepare SQL query to insert the data into the database
    $sql = "INSERT INTO livreurs (id_livreur, latitude, longitude) 
            VALUES (:id_livreur, :latitude, :longitude)";
    
    // Prepare the statement
    $stmt = $pdo->prepare($sql);
    
    // Bind the values
    $stmt->bindParam(':id_livreur', $id_livreur, PDO::PARAM_INT);
    $stmt->bindParam(':latitude', $latitude, PDO::PARAM_STR);
    $stmt->bindParam(':longitude', $longitude, PDO::PARAM_STR);
    
    // Execute the query and check for success
    if ($stmt->execute()) {
        echo json_encode(['message' => 'Location data inserted successfully']);
    } else {
        echo json_encode(['error' => 'Failed to insert location data']);
    }
} else {
    echo json_encode(['error' => 'Invalid input data']);
}
?>
