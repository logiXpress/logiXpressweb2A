<?php
session_start();
session_unset();  // Supprimer toutes les variables de session
session_destroy(); // Détruire la session

// Rediriger vers la page de connexion
header("Location: Acceuil/signin/basic.php");
exit();
