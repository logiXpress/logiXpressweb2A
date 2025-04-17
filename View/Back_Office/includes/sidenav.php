<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white my-2" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand px-4 py-3 m-0" href="index.html" target="_blank">
            <img src="../../public/assets/img/logo.png" class="navbar-brand-img" width="300" height="100" alt="main_logo">
        </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <!-- Profile Section -->
            <li class="nav-item mb-2 mt-0">
                <a data-bs-toggle="collapse" href="#ProfileNav" class="nav-link text-dark" aria-controls="ProfileNav" role="button" aria-expanded="false">
                    <img src="../../public/assets/img/team-3.jpg" class="avatar">
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

            <!-- Dashboard Section -->
            <hr class="horizontal dark mt-0">
            <?php
            $dashboardPages = ['index.html', 'analytics.php', 'discover.php'];
            $isDashboardActive = in_array($currentPage, $dashboardPages);
            ?>
            <li class="nav-item <?= $isDashboardActive ? 'active' : ''; ?>">
                <a data-bs-toggle="collapse" href="#dashboardsExamples" class="nav-link text-dark <?= $isDashboardActive ? 'active' : ''; ?>" aria-controls="dashboardsExamples" role="button" aria-expanded="<?= $isDashboardActive ? 'true' : 'false'; ?>">
                    <i class="material-symbols-rounded opacity-5">space_dashboard</i>
                    <span class="nav-link-text ms-1 ps-1">Dashboards</span>
                </a>

                <div class="collapse <?= $isDashboardActive ? 'show' : ''; ?>" id="dashboardsExamples">
                    <ul class="nav">
                        <li class="nav-item <?= ($currentPage == 'index.html') ? 'active' : ''; ?>">
                            <a class="nav-link text-dark <?= ($currentPage == 'index.html') ? 'active' : ''; ?>" href="index.html">
                                <span class="sidenav-mini-icon">A</span>
                                <span class="sidenav-normal ms-1 ps-1">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item <?= ($currentPage == 'analytics.php') ? 'active' : ''; ?>">
                            <a class="nav-link text-dark <?= ($currentPage == 'analytics.php') ? 'active' : ''; ?>" href="analytics.php">
                                <span class="sidenav-mini-icon">A</span>
                                <span class="sidenav-normal ms-1 ps-1">Analytics</span>
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
            <!-- Management Sections -->
            <hr class="horizontal dark mt-0">
            <li class="nav-item">
                <a class="nav-link text-dark" href="delivery_management.php">
                    <i class="material-symbols-rounded opacity-5">delivery_dining</i>
                    <span class="nav-link-text ms-2 ps-1">Delivery Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="user_management.php">
                    <i class="material-symbols-rounded opacity-5">person</i>
                    <span class="nav-link-text ms-2 ps-1">User Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="client_management.php">
                    <i class="material-symbols-rounded opacity-5">business</i>
                    <span class="nav-link-text ms-2 ps-1">Client Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="deliveryman_management.php">
                    <i class="material-symbols-rounded opacity-5">build</i>
                    <span class="nav-link-text ms-2 ps-1">DeliveryMan Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="claim_management.php">
                    <i class="material-symbols-rounded opacity-5">error</i>
                    <span class="nav-link-text ms-2 ps-1">Claim Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="vehicle_management.php">
                    <i class="material-symbols-rounded opacity-5">directions_car</i>
                    <span class="nav-link-text ms-2 ps-1">Vehicle Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="vehicle_maintenance_management.php">
                    <i class="material-symbols-rounded opacity-5">build</i>
                    <span class="nav-link-text ms-2 ps-1">Maintenance Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="interviews_management.php">
                    <i class="material-symbols-rounded opacity-5">business_center</i>
                    <span class="nav-link-text ms-2 ps-1">Interviews Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="order_management.php">
                    <i class="material-symbols-rounded opacity-5">shopping_cart</i>
                    <span class="nav-link-text ms-2 ps-1">Order Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="packaging_management.php">
                    <i class="material-symbols-rounded opacity-5">card_giftcard</i>
                    <span class="nav-link-text ms-2 ps-1">Packaging Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="candidates_management.php">
                    <i class="material-symbols-rounded opacity-5">person_add</i>
                    <span class="nav-link-text ms-2 ps-1">Candidates Management</span>
                </a>
            </li>

        </ul>
    </div>
</aside>