<!--
=========================================================
* Material Dashboard 3 - v3.2.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2024 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->

<?php
session_start();

require "../../../Controller/candidatC.php";// Changed backslashes to forward slashes
$CV = '';

$CV = isset($_POST['CV1']) ? htmlspecialchars($_POST['CV1']) : '';




?>

<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from demos.creative-tim.com/material-dashboard-pro/pages/applications/datatables.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 30 Mar 2025 05:24:21 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <link
      rel="apple-touch-icon"
      sizes="76x76"
      href="../../../public/assets/img/apple-icon.png"
    />
    <link
      rel="icon"
      type="image/png"
      href="../../public/assets/img/favicon.png"
    />
    <title>Welcome To LogiXpress Website</title>
    <link
      rel="canonical"
      href="https://www.creative-tim.com/product/material-dashboard-pro"
    />
    <!--  Social tags      -->
    <meta
      name="keywords"
      content="creative tim, html dashboard, html css dashboard, web dashboard, bootstrap 5 dashboard, bootstrap 5, css3 dashboard, bootstrap 5 admin, material dashboard bootstrap 5 dashboard, frontend, responsive bootstrap 5 dashboard, material design, material dashboard bootstrap 5 dashboard"
    />
    <meta
      name="description"
      content="Material Dashboard PRO is a beautiful Bootstrap 5 admin dashboard with a large number of components, designed to look beautiful, clean and organized. If you are looking for a tool to manage dates about your business, this dashboard is the thing for you."
    />
    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product" />
    <meta name="twitter:site" content="@creativetim" />
    <meta
      name="twitter:title"
      content="Material Dashboard PRO by Creative Tim"
    />
    <meta
      name="twitter:description"
      content="Material Dashboard PRO is a beautiful Bootstrap 5 admin dashboard with a large number of components, designed to look beautiful, clean and organized. If you are looking for a tool to manage dates about your business, this dashboard is the thing for you."
    />
    <meta name="twitter:creator" content="@creativetim" />
    <meta
      name="twitter:image"
      content="../../../s3.amazonaws.com/creativetim_bucket/products/51/original/opt_mdp_bs5_thumbnail.jpg"
    />
    <!-- Open Graph data -->
    <meta property="fb:app_id" content="655968634437471" />
    <meta
      property="og:title"
      content="Material Dashboard PRO by Creative Tim"
    />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="default.html" />
    <meta
      property="og:image"
      content="../../../s3.amazonaws.com/creativetim_bucket/products/51/original/opt_mdp_bs5_thumbnail.jpg"
    />
    <meta
      property="og:description"
      content="Material Dashboard PRO is a beautiful Bootstrap 5 admin dashboard with a large number of components, designed to look beautiful, clean and organized. If you are looking for a tool to manage dates about your business, this dashboard is the thing for you."
    />
    <meta property="og:site_name" content="Creative Tim" />
    <!--     Fonts and icons     -->
    <link
      rel="stylesheet"
      type="text/css"
      href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900"
    />
    <!-- Nucleo Icons -->
    <link href="../../../public/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../../../public/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
      integrity="sha512-1zXDjo...correctHash..."
      crossorigin="anonymous"
    />
    <!-- Material Icons -->
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0"
    />
    <!-- CSS Files -->
    <link
      id="pagestyle"
      href="../../../public/assets/css/material-dashboard.mine63c.css?v=3.1.0"
      rel="stylesheet"
    />
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
        opacity: 0 !important;
      }
    </style>
  </head>

<body class="g-sidenav-show  bg-gray-100">
  <!-- Extra details for Live View on GitHub Pages -->
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  <aside
      class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white my-2"
      id="sidenav-main"
    >
      <div class="sidenav-header">
        <i
          class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
          aria-hidden="true"
          id="iconSidenav"
        ></i>
        <a class="navbar-brand px-4 py-3 m-0" href="index.html" target="_blank">
          <img
            src="../../public/assets/img/logo.png"
            class="navbar-brand-img"
            width="250"
            height="80"
            alt="main_logo"
          />
        </a>
      </div>
      <hr class="horizontal dark mt-0 mb-2" />
      <div
        class="collapse navbar-collapse w-auto h-auto"
        id="sidenav-collapse-main"
      >
        <ul class="navbar-nav">
          <!-- Profile Section -->
          <li class="nav-item mb-2 mt-0">
            <a
              data-bs-toggle="collapse"
              href="#ProfileNav"
              class="nav-link text-dark"
              aria-controls="ProfileNav"
              role="button"
              aria-expanded="false"
            >
              <img src="../../public/assets/img/faces/asma.jpg" class="avatar" />
              <span class="nav-link-text ms-2 ps-1">Asma Messaoudi</span>
            </a>
            <div class="collapse" id="ProfileNav">
              <ul class="nav">
                <li class="nav-item">
                  <a
                    class="nav-link text-dark"
                    href="pages/profile/overview.html"
                  >
                    <span class="sidenav-mini-icon">MP</span>
                    <span class="sidenav-normal ms-3 ps-1">My Profile</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link text-dark"
                    href="pages/account/settings.html"
                  >
                    <span class="sidenav-mini-icon">S</span>
                    <span class="sidenav-normal ms-3 ps-1">Settings</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link text-dark"
                    href="authentication/signin/basic.html"
                  >
                    <span class="sidenav-mini-icon">L</span>
                    <span class="sidenav-normal ms-3 ps-1">Logout</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>

          <!-- Dashboard Section -->
          <hr class="horizontal dark mt-0" />
          <li class="nav-item">
            <a
              data-bs-toggle="collapse"
              href="#dashboardsExamples"
              class="nav-link text-dark active"
              aria-controls="dashboardsExamples"
              role="button"
              aria-expanded="false"
            >
              <i class="material-symbols-rounded opacity-5">space_dashboard</i>
              <span class="nav-link-text ms-1 ps-1">Dashboards</span>
            </a>
            <div class="collapse" id="dashboardsExamples">
              <ul class="nav">
                <li class="nav-item active">
                  <a class="nav-link text-dark active" href="index.html">
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
                  <a
                    class="nav-link text-dark"
                    href="dashboards/automotive.html"
                  >
                    <span class="sidenav-mini-icon">A</span>
                    <span class="sidenav-normal ms-1 ps-1">Automotive</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link text-dark"
                    href="dashboards/smart-home.html"
                  >
                    <span class="sidenav-mini-icon">S</span>
                    <span class="sidenav-normal ms-1 ps-1">Smart Home</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>

          <hr class="horizontal dark mt-0">
        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#InterviewsExamples" class="nav-link text-dark " aria-controls="InterviewsExamples" role="button" aria-expanded="false">
            <i class="material-symbols-rounded opacity-5 {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">contract</i>
            <span class="nav-link-text ms-1 ps-1">Interviews & Candidates</span>
          </a>
          <div class="collapse " id="InterviewsExamples">
            <ul class="nav ">
              <li class="nav-item">
                <a class="nav-link text-dark " href="entretientRH/TableEntretien.php">
                  <span class="sidenav-mini-icon"> I </span>
                  <span class="sidenav-normal  ms-1  ps-1"> Interview Table </span>
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link text-dark " href="entretientRH/TableCandidat.php">
                  <span class="sidenav-mini-icon"> C </span>
                  <span class="sidenav-normal  ms-1  ps-1"> Candidates Table </span>
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link text-dark " href="entretientRH/calendarEntretient.php">
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
            <li class="breadcrumb-item text-sm text-dark active font-weight-bold" aria-current="page">DataTables</li>
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
              <a href="../authentication/signin/illustration.html" class="px-1 py-0 nav-link line-height-0" target="_blank">
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
    
      
        
          
            <!-- Card header -->
            
            
              
            
          
        
              <div class="container-fluid py-2">
      <div class="row mt-4">
        <div class="col-12">
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <h5 class="mb-0">CV</h5>
            </div>
            <?php if (!empty($CV)): ?>
        <img src="<?php echo htmlspecialchars('../Front_Office/entretient_rh/uploads' . basename($CV)); ?>" alt="CV Image" style="max-height: 700px; max-width: 50%;">
    <?php else: ?>
        <img src="../../assets/img/image_placeholder.jpg" alt="Image placeholder">
    <?php endif; ?>
          </div>
        </div>
      </div>
      







      <?php include_once 'includes/footer.php'; ?>
    </div>
 </body>


<!-- Mirrored from demos.creative-tim.com/material-dashboard-pro/pages/applications/datatables.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 30 Mar 2025 05:24:21 GMT -->
</html>