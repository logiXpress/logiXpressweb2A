<?php
  // Include the head section
  require_once '../includes/header.php';
?>
<body class="g-sidenav-show bg-gray-100">
  <?php 
    // Include the sidenav
    require_once '../includes/sidenav.php'; 
  ?>
  
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <?php
      // Include the navbar
      require_once '../includes/navbar.php'; 
    ?>
    
    <!-- Content goes here -->
    <?php 
    // Include the sidenav
    require_once '../includes/configurator.php'; 
  ?>
  </main>
</body>
<?php
  // Include the footer section
  require_once '../includes/footer.php';
?>
</html>
