<?php include '../../../config/path.php'; ?>
<div class="sidebar" data-color="white" data-background-color="rose" data-image="../../../public/assets/img/sidebar-1.jpg">
  <div class="logo" style="display: flex; justify-content: center; align-items: center; height: 100px;">
    <a href="../Réclamations/dashboard.php" class="simple-text logo-normal">
    <img src="<?php echo BASE_URL; ?>/public/assets/img/logo.png" alt="LogiXpress Logo" style="width: 150px;">
    </a> 
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <!-- Dashboard -->
      <li class="nav-item <?= (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="<?php echo BASE_URL; ?>/View/Back_Office/Réclamations/dashboard.php">
          <i class="material-icons">dashboard</i>
          <p>Dashboard</p>
        </a>
      </li>

      <!-- Forms (Collapsible) -->
      <?php
      $formPages = ['dashboard.php','claims.php', 'extended.html', 'validation.html', 'wizard.html'];
      $isFormsActive = in_array(basename($_SERVER['PHP_SELF']), $formPages);
      ?>
      <li class="nav-item <?= $isFormsActive ? 'active' : ''; ?>">
        <a class="nav-link" data-toggle="collapse" href="#formsMenu" <?= $isFormsActive ? 'aria-expanded="true"' : ''; ?>>
          <i class="material-icons">content_paste</i>
          <p>Claim Management <b class="caret"></b></p>
        </a>
        <div class="collapse <?= $isFormsActive ? 'show' : ''; ?>" id="formsMenu">
          <ul class="nav">
            <li class="nav-item <?= (basename($_SERVER['PHP_SELF']) == 'claims.php') ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo BASE_URL; ?>/View/Back_Office/Réclamations/claims.php">
                <i class="material-icons">local_shipping</i>
                <p>Check All Claims</p>
              </a>
            </li>
          
            <!-- More form links here -->
          </ul>
        </div>
      </li>
    </ul>
  </div>
  <div class="sidebar-background"></div>
</div>