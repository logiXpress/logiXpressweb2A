<?php
require_once '../../../vendor/autoload.php'; // Adjust path to Twilio autoload
require_once '../../../config/config.php'; // Adjust path to your config.php

use Twilio\Rest\Client;

// Twilio credentials
$sid    = "AC73db6f13fb4bc6f9d471eb7a7e5139af";
$token  = "7bea4fdb57f9e9924117aa064aa0887c";
$twilio = new Client($sid, $token);

// Use your config class to get PDO connection
$pdo = config::getConnexion();

// Monitoring loop
while (true) {
    // Get current time and window for 1 minute from now
    $now = time();
    $windowStart = date('Y-m-d H:i:s', $now); // current time
    $windowEnd   = date('Y-m-d H:i:s', $now + 60); // 1 minute from now

    // Query entretiens scheduled in this window (within the next minute)
    $sql = "SELECT id_vehicule, Date FROM entretiens_vehicules 
            WHERE statut = 'non soumis' AND Date BETWEEN :start AND :end";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['start' => $windowStart, 'end' => $windowEnd]);
    $rows = $stmt->fetchAll();

    if (count($rows) > 0) {
        foreach ($rows as $row) {
            $message = $twilio->messages->create(
                "+21656207742", // Adjust the recipient phone number
                [
                    "messagingServiceSid" => "MG83273f2a28333e7422f404a604e1b357", // Adjust your Twilio Messaging Service SID
                    "body" => "⏰ Rappel: Entretien véhicule prévu à {$row['Date']} dans les prochaines 1 minute."
                ]
            );
            echo "✔ SMS envoyé pour l'entretien véhicule ID {$row['id_vehicule']}: SID {$message->sid}\n";
        }
    } else {
        echo "❌ Aucun entretien prévu dans la prochaine minute.\n";
    }

    // Sleep for 5 seconds before the next check (adjust as needed)
    sleep(5);
}
?>
