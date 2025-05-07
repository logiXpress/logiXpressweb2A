<?php
session_start();
require_once '../../../config/config.php';  // Assurez-vous d'avoir la bonne configuration

// Récupération du token envoyé
$data = json_decode(file_get_contents('php://input'), true);
$id_token = $data['token'] ?? '';

if (empty($id_token)) {
    echo json_encode(['success' => false, 'message' => 'Token manquant']);
    exit();
}

// URL pour vérifier le token avec Google
$google_url = 'https://oauth2.googleapis.com/tokeninfo?id_token=' . $id_token;
$response = file_get_contents($google_url);
$response_data = json_decode($response, true);

if (isset($response_data['error'])) {
    echo json_encode(['success' => false, 'message' => 'Erreur d\'authentification Google']);
    exit();
}

// Si l'authentification réussit, on enregistre les informations de l'utilisateur dans la session
$email = $response_data['email'];
$name = $response_data['name'];
$picture = $response_data['picture'];

// Vérification si l'utilisateur existe dans la base de données
try {
    $pdo = config::getConnexion();
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Si l'utilisateur existe, on le connecte
        $_SESSION['user'] = $user;
        echo json_encode(['success' => true, 'redirect' => '/Project/View/Acceuil/clientpage.php']);
    } else {
        // Si l'utilisateur n'existe pas, on crée un nouveau compte
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (email, name, picture) VALUES (:email, :name, :picture)");
        $stmt->execute([':email' => $email, ':name' => $name, ':picture' => $picture]);

        // Crée un nouvel utilisateur
        $user_id = $pdo->lastInsertId();
        $_SESSION['user'] = ['id_utilisateur' => $user_id, 'email' => $email, 'name' => $name, 'picture' => $picture];
        echo json_encode(['success' => true, 'redirect' => '/Project/View/Acceuil/clientpage.php']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur de connexion à la base de données']);
}
?>
