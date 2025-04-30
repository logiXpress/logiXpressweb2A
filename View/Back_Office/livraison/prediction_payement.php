<!DOCTYPE html>
<html lang="en">
<?php
require_once '../includes/header.php';

// Start the Python script in the background when the page is accessed
$command = "python3 Project/View/cashflow_prediction/scripts/predict_cashflow.py > /dev/null 2>&1 &";
shell_exec($command);
?>

<body class="">

  <div class="wrapper">
    <?php require_once '../includes/configurator.php'; ?>
    <?php require_once '../includes/sidenav.php'; ?>

    <div class="main-panel">
    <?php require_once '../includes/navbar.php'; ?>

      <!-- Embed the Dash app in an iframe -->
      <div class="container" style="margin-top: 100px;"> <!-- Adds space above the iframe -->
        <iframe src="http://127.0.0.1:8050/" width="100%" height="1000px" style="border:none;"></iframe>
      </div>

    </div>
  </div>
  <?php require_once '../includes/footer.php'; ?>

</body>

</html>
