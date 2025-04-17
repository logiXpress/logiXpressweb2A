<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white my-2" id="sidenav-main" data-color="success">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand px-4 py-3 m-0" href="dashboard.php" target="_blank">
            <img src="../../../Public/assets/img/logo.png" class="navbar-brand-img" width="300" height="100" alt="main_logo">
        </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">

            <!-- Profile Section -->
            <li class="nav-item mb-2 mt-0">
                <a data-bs-toggle="collapse" href="#ProfileNav" class="nav-link text-dark" aria-controls="ProfileNav" role="button" aria-expanded="false">
                    <img src="../../../Public/assets/img/team-3.jpg" class="avatar">
                    <span class="nav-link-text ms-2 ps-1">Brooklyn Alice</span>
                </a>
                <div class="collapse" id="ProfileNav">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="pages/profile/overview.html">
                                <span class="sidenav-mini-icon">MP</span>
                                <span class="sidenav-normal ms-3 ps-1">My Profile</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="pages/account/settings.html">
                                <span class="sidenav-mini-icon">S</span>
                                <span class="sidenav-normal ms-3 ps-1">Settings</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="../../Acceuil/signin/basic.php">
                                <span class="sidenav-mini-icon">L</span>
                                <span class="sidenav-normal ms-3 ps-1">Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Dashboards Section -->
            <?php
            $dashboardPages = ['dashboard.php', 'discover.php'];
            $isDashboardActive = in_array($currentPage, $dashboardPages);
            ?>
            <li class="nav-item <?= $isDashboardActive ? 'active' : ''; ?>">
                <a data-bs-toggle="collapse" href="#dashboardsExamples" class="nav-link text-dark <?= $isDashboardActive ? 'active' : ''; ?>" aria-controls="dashboardsExamples" role="button" aria-expanded="<?= $isDashboardActive ? 'true' : 'false'; ?>">
                    <i class="material-symbols-rounded opacity-5">space_dashboard</i>
                    <span class="nav-link-text ms-1 ps-1">Dashboards</span>
                </a>
                <div class="collapse <?= $isDashboardActive ? 'show' : ''; ?>" id="dashboardsExamples">
                    <ul class="nav">
                        <li class="nav-item <?= ($currentPage == 'dashboard.php') ? 'active' : ''; ?>">
                            <a class="nav-link text-dark <?= ($currentPage == 'dashboard.php') ? 'active' : ''; ?>" href="dashboard.php">
                                <span class="sidenav-mini-icon">A</span>
                                <span class="sidenav-normal ms-1 ps-1">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item <?= ($currentPage == 'discover.php') ? 'active' : ''; ?>">
                            <a class="nav-link text-dark <?= ($currentPage == 'discover.php') ? 'active' : ''; ?>" href="discover.php">
                                <span class="sidenav-mini-icon">D</span>
                                <span class="sidenav-normal ms-1 ps-1">Discover</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Vehicle Management Section -->
            <?php
            $vehiclePages = ['add.php','Listevehicules.php'];
            $isVehicleActive = in_array($currentPage, $vehiclePages);
            ?>
            <li class="nav-item <?= $isVehicleActive ? 'active' : ''; ?>">
                <a data-bs-toggle="collapse" href="#vehicleMenu" class="nav-link text-dark <?= $isVehicleActive ? 'active' : ''; ?>" aria-controls="vehicleMenu" role="button" aria-expanded="<?= $isVehicleActive ? 'true' : 'false'; ?>">
                    <i class="material-symbols-rounded opacity-5">directions_car</i>
                    <span class="nav-link-text ms-1 ps-1">Vehicle Management</span>
                </a>
                <div class="collapse <?= $isVehicleActive ? 'show' : ''; ?>" id="vehicleMenu">
                    <ul class="nav">
                        <li class="nav-item <?= ($currentPage == 'Listevehicules.php') ? 'active' : ''; ?>">
                            <a class="nav-link text-dark <?= ($currentPage == 'Listevehicules.php') ? 'active' : ''; ?>" href="../vehicule/Listevehicules.php">
                                <span class="sidenav-mini-icon">VM</span>
                                <span class="sidenav-normal ms-1 ps-1">View Vehicles</span>
                            </a>
                        </li>
                        <li class="nav-item <?= ($currentPage == 'add.php') ? 'active' : ''; ?>">
                            <a class="nav-link text-dark <?= ($currentPage == 'add.php') ? 'active' : ''; ?>" href="../vehicule/add.php">
                                <span class="sidenav-mini-icon">AV</span>
                                <span class="sidenav-normal ms-1 ps-1">Add a Vehicle</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

        </ul>
    </div>
</aside>
