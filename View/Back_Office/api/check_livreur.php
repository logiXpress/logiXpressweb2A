<?php
require_once '../../../config/config.php'; // Adjust to your structure

if (isset($_POST['livreurId'], $_POST['password'])) {
    $id = intval($_POST['livreurId']);
    $password = $_POST['password'];

    try {
        $pdo = config::getConnexion();

        $stmt = $pdo->prepare("SELECT id_utilisateur, Mot_de_passe, Type FROM utilisateurs WHERE id_utilisateur = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch();

        if ($user && $password === $user['Mot_de_passe']) {
            if ($user['Type'] === 'Livreur') {
                $livreurStmt = $pdo->prepare("SELECT id_livreur FROM livreurs WHERE id_livreur = ?");
                $livreurStmt->execute([$id]);
                $livreur = $livreurStmt->fetch();

                if ($livreur) {
                    // ✅ Optionally also notify Firebase from PHP (in case JS fails)
                    sendFirebaseConfirmation($id);

                    echo json_encode(["exists" => true]);
                } else {
                    echo json_encode(["exists" => false, "error" => "Livreur not found"]);
                }
            } else {
                echo json_encode(["exists" => false, "error" => "User is not a Livreur"]);
            }
        } else {
            echo json_encode(["exists" => false, "error" => "Invalid credentials"]);
        }
    } catch (Exception $e) {
        error_log("Erreur: " . $e->getMessage());
        echo json_encode(["exists" => false, "error" => "Server error"]);
    }
} else {
    echo json_encode(["exists" => false, "error" => "Missing ID or password"]);
}

// 🔥 Firebase confirmation via PHP (fallback)
function sendFirebaseConfirmation($livreurId) {
    $firebase_url = "https://project-1e2f9-default-rtdb.firebaseio.com/livreur_status/$livreurId.json";

    $data = [
        "status" => "connected",
        "timestamp" => time()
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'PUT',
            'content' => json_encode($data),
        ]
    ];

    $context  = stream_context_create($options);
    file_get_contents($firebase_url, false, $context);
}
?>
