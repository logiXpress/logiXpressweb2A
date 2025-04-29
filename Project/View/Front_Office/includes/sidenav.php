<?php include '../../../config/path.php'; ?>
<div class="sidebar" data-color="white" data-background-color="rose" data-image="../../../public/assets/img/sidebar-1.jpg">
  <div class="logo" style="display: flex; justify-content: center; align-items: center; height: 100px;">
    <a href="../livraison/dashboard.php" class="simple-text logo-normal">
      <img src="<?php echo BASE_URL; ?>project/public/assets/img/logo.png" alt="LogiXpress Logo" style="width: 150px;"><span>LX</span>
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <!-- Dashboard -->
      <li class="nav-item <?= (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="<?php echo BASE_URL; ?>/View/Front_Office/livraison/dashboard.php">
          <i class="material-icons">dashboard</i>
          <p>Dashboard</p>
        </a>
      </li>

      <!-- Forms (Collapsible) -->
      <?php
      $formPages = ['dashboard.php', 'extended.html', 'validation.html', 'map.php', 'dataTableCandidat.php', 'TableEntretien.php','calendarEntretient'];
      $isFormsActive = in_array(basename($_SERVER['PHP_SELF']), $formPages);
      ?>
      <li class="nav-item <?= $isFormsActive ? 'active' : ''; ?>">
        <a class="nav-link" data-toggle="collapse" href="#formsMenu" <?= $isFormsActive ? 'aria-expanded="true"' : ''; ?>>
          <i class="material-icons">content_paste</i>
          <p>Interviews and Candidates <b class="caret"></b></p>
        </a>
        <div class="collapse <?= $isFormsActive ? 'show' : ''; ?>" id="formsMenu">
          <ul class="nav">
            
            <li class="nav-item <?= (basename($_SERVER['PHP_SELF']) == 'dataTableCandidat.php') ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo BASE_URL; ?>Dynamika_v6\Project\View\Front_Office\entretientRH/TableCandidat.php">
                <i class="material-icons">liste</i>
                <p>Liste Of Candidates</p>
              </a>
            </li>
            <li class="nav-item <?= (basename($_SERVER['PHP_SELF']) == 'TableEntretien.php') ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo BASE_URL; ?>Dynamika_v6\Project\View\Front_Office\entretientRH/TableEntretien.php">
                <i class="material-icons">liste</i>
                <p>Liste Of Interviews</p>
              </a>
            </li>
            <li class="nav-item <?= (basename($_SERVER['PHP_SELF']) == 'calendarEntretient.php') ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo BASE_URL; ?>Dynamika_v6\Project\View\Front_Office\entretientRH/calendarEntretient.php">
                <i class="material-icons">Calendar</i>
                <p>Interviews Calendar</p>
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