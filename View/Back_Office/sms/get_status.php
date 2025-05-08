<?php

// Fetch the latest status or log messages (from the log file or a database)

$logFile = 'sms_log.txt';  // This should be the log file that the monitor script writes to

// Read last 10 lines from the log file
$lines = array_slice(file($logFile), -10);
echo json_encode($lines);
?>
