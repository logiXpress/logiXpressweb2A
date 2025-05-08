<?php
require_once '../../../vendor/autoload.php'; // Adjust path to Twilio autoload
require_once '../../../config/config.php';   // Adjust path to your config.php
use Twilio\Rest\Client;

date_default_timezone_set('Africa/Tunis');
set_time_limit(0); // ⬅ Add this to remove execution time limit

// Twilio credentials
$sid    = "AC73db6f13fb4bc6f9d471eb7a7e5139af";
$token  = "7bea4fdb57f9e9924117aa064aa0887c";
$twilio = new Client($sid, $token);

// Use your config class to get PDO connection
$pdo = config::getConnexion();

// Function to log messages with timestamp to file
function logMessage($message) {
    file_put_contents('sms_log.txt', "[" . date('Y-m-d H:i:s') . "] " . $message . "\n", FILE_APPEND);
}

// Run the script in an infinite loop
while (true) {
    logMessage("Checking for upcoming entretiens...");

    // Get current time and window for the next 1 minute
    $now = time();
    $windowStart = date('Y-m-d H:i:s', $now + 10); // 10 seconds from now
    $windowEnd   = date('Y-m-d H:i:s', $now + 70); // 70 seconds from now

    // Query entretiens scheduled in this window
    $sql = "SELECT id_vehicule, Date, statut FROM entretiens_vehicules 
            WHERE statut = 'non soumis' AND Date BETWEEN :start AND :end";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['start' => $windowStart, 'end' => $windowEnd]);
    $rows = $stmt->fetchAll();

    if (count($rows) > 0) {
        foreach ($rows as $row) {
            logMessage("Found entretien for vehicle ID {$row['id_vehicule']} scheduled at {$row['Date']}.");

            // Calculate the remaining time before sending the SMS
            $currentTime = time();
            $entretienTime = strtotime($row['Date']);
            $timeRemaining = $entretienTime - $currentTime;

            // If time is less than 1 minute
            if ($timeRemaining > 0 && $timeRemaining <= 60) {
                logMessage("Starting countdown for sending SMS in $timeRemaining seconds...");

                // Countdown timer for SMS
                for ($i = $timeRemaining; $i > 0; $i--) {
                    logMessage("Time remaining: $i seconds");
                    sleep(1);
                }

                // Send the SMS
                $message = $twilio->messages->create(
                    "+21656207742",
                    [
                        "messagingServiceSid" => "MG83273f2a28333e7422f404a604e1b357",
                        "body" => "⏰ Reminder: Entretien vehicle scheduled at {$row['Date']}."
                    ]
                );
                logMessage("✔ SMS sent for entretien vehicle ID {$row['id_vehicule']}: SID {$message->sid}");
            }
        }
    } else {
        logMessage("No entretien found in the next minute.");
    }

    sleep(5); // Delay before next check
}
