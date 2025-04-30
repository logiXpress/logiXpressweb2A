<!-- logout.php -->
<?php
session_start();
session_destroy();
header("Location: ../../../View/Acceuil/signin/basic.php");
exit();
?>
