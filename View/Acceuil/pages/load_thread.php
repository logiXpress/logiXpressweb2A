<?php
require '../../../Controller/MessagesReclamationC.php';
$controller = new MessagesReclamationC();
$messages = $controller->recupererMessages($_GET['id_reclamation']);

foreach ($messages as $msg) {
    $from = $msg['type'] === 'Admin' ? '👨‍💼 Admin' : '🧑 Client';
    echo "<p><strong>{$from}</strong>: " . htmlspecialchars($msg['contenu']) . "<br><small>{$msg['date_envoi']}</small></p><hr>";
}
?>