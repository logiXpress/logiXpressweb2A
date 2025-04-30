<!-- Ajout avant le formulaire -->
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../../../config/config.php';

    try {
        $pdo = config::getConnexion();
        $id_utilisateur = $_POST['id_utilisateur'] ?? null;
        $password = $_POST['password'] ?? null;

        if ($id_utilisateur && $password) {
            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = :id_utilisateur AND Mot_de_passe = :password");
            $stmt->execute([
                ':id_utilisateur' => $id_utilisateur,
                ':password' => $password
            ]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $_SESSION['user'] = $user;
                $_SESSION['id_utilisateur'] = $user['id_utilisateur'];

                if ($user['Type'] === 'Admin') {
                    header("Location: /Project/View/Back_Office/index.php");
                    exit();
                } elseif ($user['Type'] === 'Client') {
                    header("Location: /Project/View/Acceuil/clientpage.php");	
                    exit();
                }
            } else {
                $error_message = "ID utilisateur ou mot de passe incorrect.";
            }
        } else {
            $error_message = "Veuillez remplir tous les champs.";
        }
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

?>
<!DOCTYPE html>
<html lang="en">


<?php require_once '../../Back_Office/includes/header.php'; ?>

<body class="bg-gray-200"><!-- Extra details for Live View on GitHub Pages --><!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0"
      style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-100"
      style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=1950&amp;q=80');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Sign in</h4>
                  <div class="row mt-3">
                    <div class="col-2 text-center ms-auto">
                      <a class="btn btn-link px-3" href="javascript:;">
                        <i class="fa fa-facebook text-white text-lg"></i>
                      </a>
                    </div>
                    <div class="col-2 text-center px-1">
                      <a class="btn btn-link px-3" href="javascript:;">
                        <i class="fa fa-github text-white text-lg"></i>
                      </a>
                    </div>
                    <div class="col-2 text-center me-auto">
                      <a class="btn btn-link px-3" href="javascript:;">
                        <i class="fa fa-google text-white text-lg"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <?php if (!empty($error_message)): ?>
                  <div class="alert alert-danger text-center">
                    <?php echo $error_message; ?>
                  </div>
                <?php endif; ?>
                <form role="form" class="text-start" method="POST" action="">
                  <!-- Remplacement -->
                  <label class="form-label">ID Utilisateur</label>

                  <div class="input-group input-group-outline my-3">
                    <input type="text" name="id_utilisateur" class="form-control">
                  </div>
                  <label class="form-label">Mot de passe</label>

                  <div class="input-group input-group-outline mb-3">
                    <input type="password" name="password" class="form-control" required>
                  </div>
                  <div class="form-check form-switch d-flex align-items-center mb-3">
                    <input class="form-check-input" type="checkbox" id="rememberMe" checked>
                    <label class="form-check-label mb-0 ms-3" for="rememberMe">Remember me</label>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Sign in</button>
                  </div>
                  <p class="mt-4 text-sm text-center">
                    Don't have an account?
                    <a href="../signup/signup.php" class="text-primary text-gradient font-weight-bold">Sign
                      up</a>
                  </p>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>
<footer>
  <div class="container">
    <div class="row align-items-center justify-content-lg-between">
      <div class="col-12 col-md-6 my-auto">
        <div class="copyright text-center text-sm text-white text-lg-start">
          ©
          <script>
            document.write(new Date().getFullYear())
          </script>,
          made with <i class="fa fa-heart" aria-hidden="true"></i> by
          <a href="https://www.creative-tim.com/" class="font-weight-bold text-white" target="_blank">Creative Tim</a>
          for a better web.
        </div>
      </div>
      <div class="col-12 col-md-6">
        <ul class="nav nav-footer justify-content-center justify-content-lg-end">
          <li class="nav-item">
            <a href="https://www.creative-tim.com/" class="nav-link text-white" target="_blank">Creative Tim</a>
          </li>
          <li class="nav-item">
            <a href="https://www.creative-tim.com/presentation" class="nav-link text-white" target="_blank">About Us</a>
          </li>
          <li class="nav-item">
            <a href="https://www.creative-tim.com/blog" class="nav-link text-white" target="_blank">Blog</a>
          </li>
          <li class="nav-item">
            <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-white" target="_blank">License</a>
          </li>
        </ul>
      </div>
    </div>
  </div>

</footer>
  <!--   Core JS Files   -->
  <script src="../../../Public/assets/js/core/popper.min.js"></script>
  <script src="../../../Public/assets/js/core/bootstrap.min.js"></script>
  <script src="../../../Public/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../../../Public/assets/js/plugins/smooth-scrollbar.min.js"></script>
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
  <script async defer src="../../../Public/assets/buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../../../Public/assets/js/material-dashboard.mine63c.js?v=3.1.0"></script>
<script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"9284dae65dc9edcb","version":"2025.1.0","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"1b7cbb72744b40c580f8633c6b62637e","b":1}' crossorigin="anonymous"></script>

<!-- Mirrored from demos.creative-tim.com/material-dashboard-pro/pages/authentication/signin/basic.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 30 Mar 2025 05:23:50 GMT -->

</html>