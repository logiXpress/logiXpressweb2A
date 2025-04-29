<!--
=========================================================
* Material Dashboard 2 PRO - v3.1.0
=========================================================

* Product Page:  https://www.creative-tim.com/product/material-dashboard-pro 
* Copyright 2024 Creative Tim (https://www.creative-tim.com)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->

<?php

require "../../../Controller/entretienC.php"; // Changed backslashes to forward slashes
$entretienC= new entretienC();
$tab=$entretienC->listeEntretien();



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../../../public/assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../../../public/assets/img/favicon.png">
  <title>
    Welcome To LogiXpress Website
  </title>
  <link rel="canonical" href="https://www.creative-tim.com/product/material-dashboard-pro" />
  <!--  Social tags      -->
  <meta name="keywords" content="creative tim, html dashboard, html css dashboard, web dashboard, bootstrap 5 dashboard, bootstrap 5, css3 dashboard, bootstrap 5 admin, material dashboard bootstrap 5 dashboard, frontend, responsive bootstrap 5 dashboard, material design, material dashboard bootstrap 5 dashboard">
  <meta name="description" content="Material Dashboard PRO is a beautiful Bootstrap 5 admin dashboard with a large number of components, designed to look beautiful, clean and organized. If you are looking for a tool to manage dates about your business, this dashboard is the thing for you.">
  <!-- Twitter Card data -->
  <meta name="twitter:card" content="product">
  <meta name="twitter:site" content="@creativetim">
  <meta name="twitter:title" content="Material Dashboard PRO by Creative Tim">
  <meta name="twitter:description" content="Material Dashboard PRO is a beautiful Bootstrap 5 admin dashboard with a large number of components, designed to look beautiful, clean and organized. If you are looking for a tool to manage dates about your business, this dashboard is the thing for you.">
  <meta name="twitter:creator" content="@creativetim">
  <meta name="twitter:image" content="../../../s3.amazonaws.com/creativetim_bucket/products/51/original/opt_mdp_bs5_thumbnail.jpg">
  <!-- Open Graph data -->
  <meta property="fb:app_id" content="655968634437471">
  <meta property="og:title" content="Material Dashboard PRO by Creative Tim" />
  <meta property="og:type" content="article" />
  <meta property="og:url" content="default.html" />
  <meta property="og:image" content="../../../s3.amazonaws.com/creativetim_bucket/products/51/original/opt_mdp_bs5_thumbnail.jpg" />
  <meta property="og:description" content="Material Dashboard PRO is a beautiful Bootstrap 5 admin dashboard with a large number of components, designed to look beautiful, clean and organized. If you are looking for a tool to manage dates about your business, this dashboard is the thing for you." />
  <meta property="og:site_name" content="Creative Tim" />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="../../../public/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../../../public/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-1zXDjo...correctHash..." crossorigin="anonymous">
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../../../public/assets/css/material-dashboard.mine63c.css?v=3.1.0" rel="stylesheet" />
  <!-- Anti-flicker snippet (recommended)  -->
 <!--   Core JS Files   -->
 <script src="../../../public/assets/js/core/popper.min.js"></script>
  <script src="../../../public/assets/js/core/bootstrap.min.js"></script>
  <script src="../../../public/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../../../public/assets/js/plugins/smooth-scrollbar.min.js"></script>
  <!-- Kanban scripts -->
  <script src="../../../public/assets/js/plugins/dragula/dragula.min.js"></script>
  <script src="../../../public/assets/js/plugins/jkanban/jkanban.min.js"></script>
  <script src="../../../public/assets/js/plugins/chartjs.min.js"></script>
  <script src="../../../public/assets/js/plugins/world.js"></script>
  <style>
    .async-hide {
      opacity: 0 !important
    }
  </style>
  

</head>

<body class="g-sidenav-show  bg-gray-100">
  <!-- Extra details for Live View on GitHub Pages -->
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white my-2" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand px-4 py-3 m-0" href="index.html" target="_blank">
            <img src="../../../public/assets/img/logo.png" class="navbar-brand-img" width="250" height="80" alt="main_logo">
        </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <!-- Profile Section -->
            <li class="nav-item mb-2 mt-0">
                <a data-bs-toggle="collapse" href="#ProfileNav" class="nav-link text-dark" aria-controls="ProfileNav" role="button" aria-expanded="false">
                    <img src="../../../public/assets/img/faces/asma.jpg" class="avatar">
                    <span class="nav-link-text ms-2 ps-1">Asma Messaoudi</span>
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
                            <a class="nav-link text-dark" href="authentication/signin/basic.html">
                                <span class="sidenav-mini-icon">L</span>
                                <span class="sidenav-normal ms-3 ps-1">Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Dashboard Section -->
            <hr class="horizontal dark mt-0">
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#dashboardsExamples" class="nav-link text-dark" aria-controls="dashboardsExamples" role="button" aria-expanded="false">
                    <i class="material-symbols-rounded opacity-5">space_dashboard</i>
                    <span class="nav-link-text ms-1 ps-1">Dashboards</span>
                </a>
                <div class="collapse" id="dashboardsExamples">
                    <ul class="nav">
                        <li class="nav-item ">
                            <a class="nav-link text-dark " href="index.html">
                                <span class="sidenav-mini-icon">A</span>
                                <span class="sidenav-normal ms-1 ps-1">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="analytics.php">
                                <span class="sidenav-mini-icon">A</span>
                                <span class="sidenav-normal ms-1 ps-1">Analytics</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="discover.php">
                                <span class="sidenav-mini-icon">D</span>
                                <span class="sidenav-normal ms-1 ps-1">Discover</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="dashboards/sales.html">
                                <span class="sidenav-mini-icon">S</span>
                                <span class="sidenav-normal ms-1 ps-1">Sales</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="dashboards/automotive.html">
                                <span class="sidenav-mini-icon">A</span>
                                <span class="sidenav-normal ms-1 ps-1">Automotive</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="dashboards/smart-home.html">
                                <span class="sidenav-mini-icon">S</span>
                                <span class="sidenav-normal ms-1 ps-1">Smart Home</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            
        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#InterviewsExamples" class="nav-link text-dark active " aria-controls="InterviewsExamples" role="button" aria-expanded="false">
            <i class="material-symbols-rounded opacity-5 {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">contract</i>
            <span class="nav-link-text ms-1 ps-1">Interviews & Candidates</span>
          </a>
          <div class="collapse show" id="InterviewsExamples">
            <ul class="nav ">
              <li class="nav-item active">
                <a class="nav-link text-dark active " href="TableEntretien.php">
                  <span class="sidenav-mini-icon"> I </span>
                  <span class="sidenav-normal  ms-1  ps-1"> Interview Table </span>
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link text-dark " href="TableCandidat.php">
                  <span class="sidenav-mini-icon"> C </span>
                  <span class="sidenav-normal  ms-1  ps-1"> Candidates Table </span>
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link text-dark " href="calendarEntretient.php">
                  <span class="sidenav-mini-icon"> IC </span>
                  <span class="sidenav-normal  ms-1  ps-1"> Interview Calendar </span>
                </a>
              </li>
            </ul>
          </div>
        </li>

        </ul>
    </div>
</aside>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    
     <!-- Navbar -->
     <nav class="navbar navbar-main navbar-expand-lg position-sticky mt-2 top-1 px-0 py-1 mx-3 shadow-none border-radius-lg z-index-sticky" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-2">
        <div class="sidenav-toggler sidenav-toggler-inner d-xl-block d-none ">
          <a href="javascript:;" class="nav-link text-body p-0">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </a>
        </div>
        <nav aria-label="breadcrumb" class="ps-2">
          <ol class="breadcrumb bg-transparent mb-0 p-0">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active font-weight-bold" aria-current="page">Products List</li>
          </ol>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group input-group-outline">
              <label class="form-label">Search here</label>
              <input type="text" class="form-control">
            </div>
          </div>
          <ul class="navbar-nav  justify-content-end">
            <li class="nav-item">
              <a href="../../authentication/signin/illustration.html" class="px-1 py-0 nav-link line-height-0" target="_blank">
                <i class="material-symbols-rounded">
              account_circle
            </i>
              </a>
            </li>
            <li class="nav-item">
              <a href="javascript:;" class="nav-link py-0 px-1 line-height-0">
                <i class="material-symbols-rounded fixed-plugin-button-nav">
              settings
            </i>
              </a>
            </li>
            <li class="nav-item dropdown py-0 pe-3">
              <a href="javascript:;" class="nav-link py-0 px-1 position-relative line-height-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="material-symbols-rounded">
              notifications
            </i>
                <span class="position-absolute top-5 start-100 translate-middle badge rounded-pill bg-danger border border-white small py-1 px-2">
                  <span class="small">11</span>
                  <span class="visually-hidden">unread notifications</span>
                </span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end p-2 me-sm-n4" aria-labelledby="dropdownMenuButton">
                <li class="mb-2">
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex align-items-center py-1">
                      <span class="material-symbols-rounded">email</span>
                      <div class="ms-2">
                        <h6 class="text-sm font-weight-normal my-auto">
                          Check new messages
                        </h6>
                      </div>
                    </div>
                  </a>
                </li>
                <li class="mb-2">
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex align-items-center py-1">
                      <span class="material-symbols-rounded">podcasts</span>
                      <div class="ms-2">
                        <h6 class="text-sm font-weight-normal my-auto">
                          Manage podcast session
                        </h6>
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex align-items-center py-1">
                      <span class="material-symbols-rounded">shopping_cart</span>
                      <div class="ms-2">
                        <h6 class="text-sm font-weight-normal my-auto">
                          Payment successfully completed
                        </h6>
                      </div>
                    </div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-2">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- Card header -->
            <div class="card-header pb-0">
              <div class="d-lg-flex">
                <div>
                  <h5 class="mb-0">Interview Table</h5>
                </div>
                <div class="ms-auto my-auto mt-lg-0 mt-4">
                  <div class="ms-auto my-auto">
                    <!--<a href="new-product.html" class="btn bg-gradient-dark btn-sm mb-0" target="_blank">+&nbsp; New Product</a>-->
                    <!--<button type="button" class="btn btn-outline-primary btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#import">
                      Import
                    </button>-->
                    <div class="modal fade" id="import" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog mt-lg-10">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="ModalLabel">Import CSV</h5>
                            <i class="material-symbols-rounded ms-3">file_upload</i>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <p>You can browse your computer for a file.</p>
                            <div class="input-group input-group-dynamic mb-3">
                              <label class="form-label">Browse file...</label>
                              <input type="email" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="" id="importCheck" checked="">
                              <label class="custom-control-label" for="importCheck">I accept the terms and conditions</label>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn bg-gradient-dark btn-sm">Upload</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                  </div>
                  <div class="ms-auto my-auto mt-lg-0 mt-4 d-flex">
            <div class="me-2">
                <button class="btn btn-outline-primary btn-sm export mb-0 mt-sm-0" data-type="csv" type="button" name="button">Export</button>
            </div>
            <div>
                <!--<button class="btn bg-gradient-primary mb-0" onClick="window.print()" type="button" name="button">Print</button>-->
            </div>
        </div>
                  

                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-0">
              <div class="table-responsive">
                <table class="table table-flush" id="TableEntretien">
                  <thead class="thead-light">
                    <tr>
                      <th>Interview date</th>
                      <th>Status</th>
                      <th>Interview Link</th>
                      <th>Evaluation</th>
                      <th>Name</th>
                      <th>Last name</th>
                      <th>Email</th>
                      <th>Telephone</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
for ($i = 0; $i < count($tab); $i++) {
    echo "<tr>"; 
    echo "<td>" . $tab[$i]["date_entretien"] . "</td>";
    if ($tab[$i]["statut"] == "Effectué") {
      echo '<td class="align-middle text-center text-sm">';
      echo '<span class="badge badge-sm bg-gradient-success">' . $tab[$i]["statut"] . '</span>';
      echo '</td>';
  } else if ($tab[$i]["statut"] == "Planifié") {
      echo '<td class="align-middle text-center text-sm">';
      echo '<span class="badge badge-sm bg-gradient-secondary">' . $tab[$i]["statut"] . '</span>';
      echo '</td>';
  } else {
      echo '<td class="align-middle text-center text-sm">';
      echo '<span class="badge badge-sm bg-gradient-danger ">' . $tab[$i]["statut"] . '</span>';
      echo '</td>';
  }
    echo "<td>" . $tab[$i]["lien_entretien"] . "</td>";
    echo "<td>" . $tab[$i]["evaluation"] . "</td>";
    echo "<td>" . $tab[$i]["nom"] . "</td>";
    echo "<td>" . $tab[$i]["prenom"] . "</td>";
    echo "<td>" . $tab[$i]["email"] . "</td>";
    echo "<td>" . $tab[$i]["telephone"] . "</td>";

    echo "<td class='text-right'>
    <form action='forumModifierEntretient.php' method='post' style='display: inline;'>
        <input type='hidden' name='idEntretien' value='" . $tab[$i]["id_entretien"] . "'> <!-- Include the candidate ID -->
        <button type='submit' class='btn btn-warning btn btn-warning'>
            <i class='material-icons'>edit</i>
        </button>
    </form>
    <form action='conSupprimerEntretien.php' method='post' style='display: inline;'>
        <input type='hidden' name='idEntretien' value='" . $tab[$i]["id_entretien"] . "'>
        <button type='submit' class='btn btn-link btn-danger btn-just-icon remove'>
            <i class='material-icons'>delete</i>
        </button>
    </form>
  </td>";
    echo "</tr>"; 
}
?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Product</th>
                      <th>Category</th>
                      <th>Price</th>
                      <th>SKU</th>
                      <th>Quantity</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer py-4  ">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script>,
                made with <i class="fa fa-heart"></i> by
                <a href="https://www.creative-tim.com/" class="font-weight-bold" target="_blank">Creative Tim</a>
                for a better web.
              </div>
            </div>
            <div class="col-lg-6">
              <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/" class="nav-link text-muted" target="_blank">Creative Tim</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About Us</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">License</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>
  <div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="material-symbols-rounded py-2">settings</i>
    </a>
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3">
        <div class="float-start">
          <h5 class="mt-3 mb-0">Material UI Configurator</h5>
          <p>See our dashboard options.</p>
        </div>
        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="material-symbols-rounded">clear</i>
          </button>
        </div>
        <!-- End Toggle Button -->
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0">
        <!-- Sidebar Backgrounds -->
        <div>
          <h6 class="mb-0">Sidebar Colors</h6>
        </div>
        <a href="javascript:void(0)" class="switch-trigger background-color">
          <div class="badge-colors my-2 text-start">
            <span class="badge filter bg-gradient-primary" data-color="primary" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-dark active" data-color="dark" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
          </div>
        </a>
        <!-- Sidenav Type -->
        <div class="mt-3">
          <h6 class="mb-0">Sidenav Type</h6>
          <p class="text-sm">Choose between different sidenav types.</p>
        </div>
        <div class="d-flex">
          <button class="btn bg-gradient-dark px-3 mb-2" data-class="bg-gradient-dark" onclick="sidebarType(this)">Dark</button>
          <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-transparent" onclick="sidebarType(this)">Transparent</button>
          <button class="btn bg-gradient-dark px-3 mb-2  active ms-2" data-class="bg-white" onclick="sidebarType(this)">White</button>
        </div>
        <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
        <!-- Navbar Fixed -->
        <div class="mt-3 d-flex">
          <h6 class="mb-0">Navbar Fixed</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
          </div>
        </div>
        <hr class="horizontal dark my-3">
        <div class="mt-2 d-flex">
          <h6 class="mb-0">Sidenav Mini</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarMinimize" onclick="navbarMinimize(this)">
          </div>
        </div>
        <hr class="horizontal dark my-3">
        <div class="mt-2 d-flex">
          <h6 class="mb-0">Light / Dark</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
          </div>
        </div>
        <hr class="horizontal dark my-sm-4">
        <a class="btn bg-gradient-primary w-100" href="https://www.creative-tim.com/product/material-dashboard-pro">Buy now</a>
        <a class="btn bg-gradient-info w-100" href="https://www.creative-tim.com/product/material-dashboard">Free demo</a>
        <a class="btn btn-outline-dark w-100" href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard">View documentation</a>
        <div class="w-100 text-center">
          <a class="github-button" href="https://github.com/creativetimofficial/material-dashboard" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star creativetimofficial/material-dashboard on GitHub">Star</a>
          <h6 class="mt-3">Thank you for sharing!</h6>
          <a href="https://twitter.com/intent/tweet?text=Check%20Material%20UI%20Dashboard%20PRO%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23bootstrap5&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fsoft-ui-dashboard-pro" class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
          </a>
          <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/material-dashboard-pro" class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-facebook-square me-1" aria-hidden="true"></i> Share
          </a>
        </div>
      </div>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="../../../Public/assets/js/core/popper.min.js"></script>
  <script src="../../../Public/assets/js/core/bootstrap.min.js"></script>
  <script src="../../../Public/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../../../Public/assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../../../Public/assets/js/plugins/datatables.js"></script>
  <script>
    if (document.getElementById('TableEntretien')) {
      const dataTableSearch = new simpleDatatables.DataTable("#TableEntretien", {
        searchable: true,
        fixedHeight: false,
        
      });

      document.querySelectorAll(".export").forEach(function(el) {
        el.addEventListener("click", function(e) {
          var type = el.dataset.type;

          var data = {
            type: type,
            filename: "Interviews-" + type,
          };

          if (type === "csv") {
            data.columnDelimiter = " | ";
          }

          dataTableSearch.export(data);
        });
      });
    };
  </script>

  <script>
    if (document.getElementById('TableEntretien')) {
      const dataTableSearch = new simpleDatatables.DataTable("#TableEntretien", {
        searchable: true,
        fixedHeight: false,
        
      });

      document.querySelectorAll(".export").forEach(function(el) {
        el.addEventListener("click", function(e) {
          var type = el.dataset.type;

          var data = {
            type: type,
            filename: "Interviews-" + type,
          };

          if (type === "csv") {
            data.columnDelimiter = " | ";
          }

          dataTableSearch.export(data);
        });
      });
    };
  </script>
  <!-- Kanban scripts -->
  <script src="../../../Public/assets/js/plugins/dragula/dragula.min.js"></script>
  <script src="../../../Public/assets/js/plugins/jkanban/jkanban.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="../../../../../buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../../Public/assets/js/material-dashboard.mine63c.js?v=3.1.0"></script>
<script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"9284dad54e09edcb","version":"2025.1.0","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"1b7cbb72744b40c580f8633c6b62637e","b":1}' crossorigin="anonymous"></script>
<footer>
  <!--   Core JS Files   -->
  <script src="../../public/assets/js/core/popper.min.js"></script>
  <script src="../../public/assets/js/core/bootstrap.min.js"></script>
  <script src="../../public/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../../public/assets/js/plugins/smooth-scrollbar.min.js"></script>
  <!-- Kanban scripts -->
  <script src="../../public/assets/js/plugins/dragula/dragula.min.js"></script>
  <script src="../../public/assets/js/plugins/jkanban/jkanban.min.js"></script>
  <script src="../../public/assets/js/plugins/chartjs.min.js"></script>
  <script src="../../public/assets/js/plugins/world.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="../../public/assets/buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../../public/assets/js/material-dashboard.mine63c.js?v=3.1.0"></script>
<script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"9284c5f32fd10e85","version":"2025.1.0","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"1b7cbb72744b40c580f8633c6b62637e","b":1}' crossorigin="anonymous"></script>

<script>
    (function(a, s, y, n, c, h, i, d, e) {
      s.className += ' ' + y;
      h.start = 1 * new Date;
      h.end = i = function() {
        s.className = s.className.replace(RegExp(' ?' + y), '')
      };
      (a[n] = a[n] || []).hide = h;
      setTimeout(function() {
        i();
        h.end = null
      }, c);
      h.timeout = c;
    })(window, document.documentElement, 'async-hide', 'dataLayer', 4000, {
      'GTM-K9BGS8K': true
    });
  </script>
</footer>
</body>


<!-- Mirrored from demos.creative-tim.com/material-dashboard-pro/pages/applications/datatables.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 30 Mar 2025 05:24:21 GMT -->
</html>