<?php include '../../../config/path.php'; ?>
<div class="sidebar" data-color="white" data-background-color="rose" data-image="../../../public/assets/img/sidebar-1.jpg">
  <div class="logo" style="display: flex; justify-content: center; align-items: center; height: 100px;">
    <a href="../livraison/dashboard.php" class="simple-text logo-normal">
      <img src="<?php echo BASE_URL; ?>/public/assets/img/logo.png" alt="LogiXpress Logo" style="width: 150px;"><span>LX</span>
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <!-- Dashboard -->
      <li class="nav-item <?= (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="<?php echo BASE_URL; ?>/View/Back_Office/livraison/dashboard.php">
          <i class="material-icons">dashboard</i>
          <p>Dashboard</p>
        </a>
      </li>

      <!-- Forms (Collapsible) -->
      <?php
      $formPages = ['dashboard.php', 'ajouterlivraison.php', 'extended.html', 'validation.html', 'map.php', 'ListeLiv.php'];
      $isFormsActive = in_array(basename($_SERVER['PHP_SELF']), $formPages);
      ?>
      <li class="nav-item <?= $isFormsActive ? 'active' : ''; ?>">
        <a class="nav-link" data-toggle="collapse" href="#formsMenu" <?= $isFormsActive ? 'aria-expanded="true"' : ''; ?>>
          <i class="material-icons">content_paste</i>
          <p>Delivery Management <b class="caret"></b></p>
        </a>
        <div class="collapse <?= $isFormsActive ? 'show' : ''; ?>" id="formsMenu">
          <ul class="nav">
            <li class="nav-item <?= (basename($_SERVER['PHP_SELF']) == 'ajouterlivraison.php') ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo BASE_URL; ?>/View/Back_Office/livraison/ajouterlivraison.php">
                <i class="material-icons">local_shipping</i>
                <p>Add a Delivery</p>
              </a>
            </li>
            <li class="nav-item <?= (basename($_SERVER['PHP_SELF']) == 'ListeLiv.php') ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo BASE_URL; ?>/View/Back_Office/livraison/ListeLiv.php">
                <i class="material-icons">liste</i>
                <p>Liste Of Delivaries</p>
              </a>
            </li>
            <li class="nav-item <?= (basename($_SERVER['PHP_SELF']) == 'map.php') ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo BASE_URL; ?>/View/Back_Office/livraison/map.php">
                <i class="material-icons">map</i>
                <p>Deliveries Route</p>
              </a>
            </li>
            <!-- More form links here -->
          </ul>
        </div>
      </li>
      <?php
      $userPages = ['client_management.php', 'Couriers_Management.php'];
      $isUserActive = in_array(basename($_SERVER['PHP_SELF']), $userPages);
      ?>
      <li class="nav-item <?= $isUserActive ? 'active' : ''; ?>">
        <a class="nav-link" data-toggle="collapse" href="#userMenu" <?= $isUserActive ? 'aria-expanded="true"' : ''; ?>>
          <i class="material-icons">group</i>
          <p>User Management <b class="caret"></b></p>
        </a>
        <div class="collapse <?= $isUserActive ? 'show' : ''; ?>" id="userMenu">
          <ul class="nav">
            <li class="nav-item <?= (basename($_SERVER['PHP_SELF']) == 'client_management.php') ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo BASE_URL; ?>/View/Back_Office/user/client_management.php">
                <i class="material-icons">person</i>
                <p>Client Management</p>
              </a>
            </li>
            <li class="nav-item <?= (basename($_SERVER['PHP_SELF']) == 'Couriers_Management.php') ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo BASE_URL; ?>/View/Back_Office/user/Couriers_Management.php">
                <i class="material-icons">two_wheeler</i>
                <p>Drivers Management</p>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <?php
      $vehiclePages = ['add.php', 'listevehicules.php'];
      $isVehicleActive = in_array(basename($_SERVER['PHP_SELF']), $vehiclePages);
      ?>
      <li class="nav-item <?= $isVehicleActive ? 'active' : ''; ?>">
        <a class="nav-link" data-toggle="collapse" href="#vehicleMenu" <?= $isVehicleActive ? 'aria-expanded="true"' : ''; ?>>
          <i class="material-icons">directions_car</i>
          <p>Vehicle Management <b class="caret"></b></p>
        </a>
        <div class="collapse <?= $isVehicleActive ? 'show' : ''; ?>" id="vehicleMenu">
          <ul class="nav">
            <li class="nav-item <?= (basename($_SERVER['PHP_SELF']) == 'add.php') ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo BASE_URL; ?>/View/Back_Office/vehicule/add.php">
                <i class="material-icons">add_circle</i>
                <p>Add a Vehicle</p>
              </a>
            </li>
            <li class="nav-item <?= (basename($_SERVER['PHP_SELF']) == 'listevehicules.php') ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo BASE_URL; ?>/View/Back_Office/vehicule/listevehicules.php">
                <i class="material-icons">list</i>
                <p>Liste of Vehicles</p>
              </a>


          </ul>
        </div>
      </li>
      <?php
      $maintenancePages = ['addE.php', 'listeentretiens.php','sms.php'];
      $isMaintenanceActive = in_array(basename($_SERVER['PHP_SELF']), $maintenancePages);
      ?>
      <li class="nav-item <?= $isMaintenanceActive ? 'active' : ''; ?>">
        <a class="nav-link" data-toggle="collapse" href="#maintenanceMenu" <?= $isMaintenanceActive ? 'aria-expanded="true"' : ''; ?>>
          <i class="material-icons">build</i>
          <p>Maintenance Management <b class="caret"></b></p>
        </a>
        <div class="collapse <?= $isMaintenanceActive ? 'show' : ''; ?>" id="maintenanceMenu">
          <ul class="nav">
            <li class="nav-item <?= (basename($_SERVER['PHP_SELF']) == 'addE.php') ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo BASE_URL; ?>/View/Back_Office/Entretien/addE.php">
                <i class="material-icons">add_circle</i>
                <p>Add a Maintenance</p>
              </a>
            </li>
            <li class="nav-item <?= (basename($_SERVER['PHP_SELF']) == 'listeentretiens.php') ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo BASE_URL; ?>/View/Back_Office/entretien/listeentretiens.php">
                <i class="material-icons">list</i>
                <p>List of Maintenances</p>
              </a>
            </li>
            <li class="nav-item <?= (basename($_SERVER['PHP_SELF']) == 'sms.php') ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo BASE_URL; ?>/View/Back_Office/sms/sms.php">
                <i class="material-icons">sms</i>
                <p>SMS</p>
              </a>
            </li>
            
          </ul>
        </div>
      </li>

    </ul>
  </div>
  <div class="sidebar-background"></div>
</div>