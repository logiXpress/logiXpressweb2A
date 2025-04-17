<?php
class Config {
    public static function getConnexion() {
        try {
            $conn = new PDO("mysql:host=localhost;dbname=db", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            die("Erreur: " . $e->getMessage());
        }
    }
}
?>
