<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
echo "<h1>Welcome, Face Verified!</h1>";
