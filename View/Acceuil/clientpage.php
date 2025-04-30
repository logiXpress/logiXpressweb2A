<?php
session_start();
require_once '../../config/config.php';  // Your PDO connection file

// Check if user is logged in
if (!isset($_SESSION['id_utilisateur'])) {
  exit();
}

$id = $_SESSION['id_utilisateur'];

try {
  $pdo = config::getConnexion();

  // 1. Récupérer les infos utilisateur
  $stmt = $pdo->prepare("SELECT Nom, Prénom, Email, phone_number, profile_picture FROM utilisateurs WHERE id_utilisateur = :id AND Type = 'Client'");
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();

  if ($stmt->rowCount() == 1) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Store user data in session for later use
    $_SESSION['Nom'] = $user['Nom'];
    $_SESSION['Prénom'] = $user['Prénom'];
    $_SESSION['Email'] = $user['Email'];
    $_SESSION['phone_number'] = $user['phone_number'];
    $_SESSION['profile_picture'] = $user['profile_picture'];
  } else {
    echo "User not found or not a client.";
    exit();
  }

  // 2. Récupérer le nombre de réponses de l'admin pour ce client
  $stmt2 = $pdo->prepare("SELECT COUNT(*) FROM reponses_admin RA
  INNER JOIN reclamations R ON RA.id_reclamation = R.id_reclamation
  WHERE R.id_client = :id_client");

  $stmt2->execute([':id_client' => $id]);
  $nombreReponses = (int) $stmt2->fetchColumn();

} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
  exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap"
    rel="stylesheet">

  <title>Welcome to LogiXpress | Fast & Secure Delivery</title>

  <!-- Bootstrap core CSS -->
  <link href="../../Public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Additional CSS Files -->
  <link rel="stylesheet" href="../../Public/assets/css/fontawesome.css">
  <link rel="stylesheet" href="../../Public/assets/css/style.css">
  <link rel="stylesheet" href="../../Public/assets/css/owl.css">
</head>
<style>
  .profile-icon {
    width: 40px;
    /* Adjust the size as needed */
    height: 40px;
    /* Adjust the size as needed */
    border-radius: 50%;
    object-fit: cover;
    margin-right: 10px;
  }

  .badge {
    border-radius: 10px;
    padding: 2px 6px;
    font-size: 12px;
  }
</style>




<body>

  <!-- ***** Preloader Start ***** -->
  <div id="preloader">
    <div class="jumper">
      <div></div>
      <div></div>
      <div></div>
    </div>
  </div>
  <!-- ***** Preloader End ***** -->

  <!-- Header -->
  <div class="sub-header">
    <div class="container">
      <div class="row">
        <div class="col-md-8 col-xs-12">
          <ul class="left-info">
            <li><a href="#"><i class="fa fa-envelope"></i>logixpress@gmail.com</a></li>
            <li><a href="#"><i class="fa fa-phone"></i>+216-56-207-742</a></li>
          </ul>
        </div>
        <div class="col-md-4">
          <ul class="right-icons">
            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <header class="">
    <nav class="navbar navbar-expand-lg">
      <div class="container">
        <a class="navbar-brand" href="index.php">
          <img src="../../Public/assets/images/logo.png" alt="LogiXpress Logo" height="50">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
          aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">


            <li class="nav-item active">
              <a class="nav-link" href="index.php">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="pages/products.html">Products</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo ($nombreReponses > 0) ? 'text-danger' : ''; ?>" href="pages/claim.php">
                Claims
                <?php if ($nombreReponses > 0): ?>
                  <span class="badge bg-danger text-white"><?php echo $nombreReponses; ?></span>
                <?php endif; ?>
              </a>
            </li>



            <li class="nav-item dropdown">
              <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                aria-expanded="false">About</a>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="pages/about.html">About Us</a>
                <a class="dropdown-item" href="pages/blog.html">Blog</a>
                <a class="dropdown-item" href="pages/testimonials.html">Testimonials</a>
                <a class="dropdown-item" href="pages/terms.html">Terms</a>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages/contact.html">Contact Us</a>
            </li>

            <!-- Profile Section Link (if logged in) -->
            <?php if (isset($_SESSION['user_id'])) { ?>
              <li class="nav-item">
                <a class="nav-link" href="clientpage.php">My Profile</a>
              </li>
            <?php } else { ?>
              <li class="nav-item">
                <a class="nav-link" href="signin/basic.php">Sign in</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="signup/signup.php">Register/Sign Up</a>
              </li>
            <?php } ?>
            <!-- Profile Section -->
            <?php if (isset($_SESSION['id_utilisateur'])) { ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?php
                  if (!empty($user['profile_picture'])) {
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($user['profile_picture']) . '" alt="Profile Icon" class="profile-icon" />';
                  } else {
                    echo '<i class="fa fa-user-circle" style="font-size: 40px; margin-right: 10px;"></i>';
                  }
                  ?>
                  <span><?php echo htmlspecialchars($user['Nom'] . ' ' . $user['Prénom']); ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                  <a class="dropdown-item" href="profile.php">
                    <span class="sidebar-mini"> MP </span>
                    <span class="sidebar-normal"> My Profile </span>
                  </a>
                  <a class="dropdown-item" href="edit_profile.php">
                    <span class="sidebar-mini"> EP </span>
                    <span class="sidebar-normal"> Edit Profile </span>
                  </a>
                  <a class="dropdown-item" href="settings.php">
                    <span class="sidebar-mini"> S </span>
                    <span class="sidebar-normal"> Settings </span>
                  </a>
                </div>
              </li>
            <?php } ?>

          </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- Page Content -->
  <!-- Banner Starts Here -->
  <div class="main-banner header-text" id="top">
    <div class="Modern-Slider">
      <!-- Item -->
      <div class="item item-1">
        <div class="img-fill">
          <div class="text-content">
            <h6>lorem ipsum dolor sit amet!</h6>
            <h4>Quam temporibus accusam <br> hic ducimus quia</h4>
            <p>Magni deserunt dolorem consectetur adipisicing elit. Corporis molestiae optio, laudantium odio quod rerum
              maiores, omnis unde quae illo.</p>
            <a href="pages/products.html" class="filled-button">Products</a>
          </div>
        </div>
      </div>
      <!-- // Item -->
      <!-- Item -->


      <div class="item item-2">
        <div class="img-fill">
          <div class="text-content">
            <h6>magni deserunt dolorem harum quas!</h6>
            <h4>Aliquam iusto harum <br> ratione porro odio</h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. At culpa cupiditate mollitia adipisci assumenda
              laborum eius quae quo excepturi, eveniet. Dicta nulla ea beatae consequuntur?</p>
            <a href="pages/about.html" class="filled-button">About Us</a>
          </div>
        </div>
      </div>
      <!-- // Item -->
      <!-- Item -->
      <div class="item item-3">
        <div class="img-fill">
          <div class="text-content">
            <h6>alias officia qui quae vitae natus!</h6>
            <h4>Lorem ipsum dolor <br>sit amet, consectetur.</h4>
            <p>Vivamus ut tellus mi. Nulla nec cursus elit, id vulputate mi. Sed nec cursus augue. Phasellus lacinia ac
              sapien vitae dapibus. Mauris ut dapibus velit cras interdum nisl ac urna tempor mollis.</p>
            <a href="pages/contact.html" class="filled-button">Contact Us</a>
          </div>
        </div>
      </div>
      <!-- // Item -->
    </div>
  </div>
  <!-- Banner Ends Here -->

  <div class="request-form">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <h4>Request a call back right now ?</h4>
          <span>Mauris ut dapibus velit cras interdum nisl ac urna tempor mollis.</span>
        </div>
        <div class="col-md-4">
          <a href="pages/contact.html" class="border-button">Contact Us</a>
        </div>
      </div>
    </div>
  </div>

  <div class="services">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="section-heading">
            <h2>Featured <em>Products</em></h2>
            <span>Aliquam id urna imperdiet libero mollis hendrerit</span>
          </div>
        </div>
        <div class="col-md-4">
          <div class="service-item">
            <img src="../../Public/assets/images/product-1-720x480.jpg" alt="">
            <div class="down-content">
              <h4>Lorem ipsum dolor sit amet</h4>
              <div style="margin-bottom:10px;">
                <span> <del><sup>$</sup>2000.00</del> <sup>$</sup>1700.00 </span>
              </div>

              <p>Nullam nibh mi, tincidant sed sapien ut, rutrum hendrerit velit. Integer auctor a mauris sit amet
                eleifend.</p>
              <a href="pages/product-details.html" class="filled-button">View More</a>
            </div>
          </div>

          <br>
        </div>
        <div class="col-md-4">
          <div class="service-item">
            <img src="../../Public/assets/images/product-2-720x480.jpg" alt="">
            <div class="down-content">
              <h4>Lorem ipsum dolor sit amet</h4>
              <div style="margin-bottom:10px;">
                <span> <del><sup>$</sup>2000.00</del> <sup>$</sup>1700.00 </span>
              </div>

              <p>Nullam nibh mi, tincidunt sed sapien ut, rutrum hendrerit velit. Integer auctor a mauris sit amet
                eleifend.</p>
              <a href="pages/product-details.html" class="filled-button">View More</a>
            </div>
          </div>

          <br>
        </div>
        <div class="col-md-4">
          <div class="service-item">
            <img src="../../Public/assets/images/product-3-720x480.jpg" alt="">
            <div class="down-content">
              <h4>Lorem ipsum dolor sit amet</h4>
              <div style="margin-bottom:10px;">
                <span> <del><sup>$</sup>2000.00</del> <sup>$</sup>1700.00 </span>
              </div>

              <p>Nullam nibh mi, tincidunt sed sapien ut, rutrum hendrerit velit. Integer auctor a mauris sit amet
                eleifend.</p>
              <a href="pages/product-details.html" class="filled-button">View More</a>
            </div>
          </div>

          <br>
        </div>
      </div>
    </div>
  </div>

  <div class="fun-facts">
    <div class="container">
      <div class="more-info-content">
        <div class="row">
          <div class="col-md-6">
            <div class="left-image">
              <img src="../../Public/assets/images/about-1-570x350.jpg" class="img-fluid" alt="">
            </div>
          </div>
          <div class="col-md-6 align-self-center">
            <div class="right-content">
              <span>Who we are</span>
              <h2>Get to know about <em>our company</em></h2>
              <p>Curabitur pulvinar sem a leo tempus facilisis. Sed non sagittis neque. Nulla conse quat tellus nibh, id
                molestie felis sagittis ut. Nam ullamcorper tempus ipsum in cursus</p>
              <a href="pages/about.html" class="filled-button">Read More</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="more-info">
    <div class="container">
      <div class="section-heading">
        <h2>Read our <em>Blog</em></h2>
        <span>Aliquam id urna imperdiet libero mollis hendrerit</span>
      </div>

      <div class="row" id="tabs">
        <div class="col-md-4">
          <ul>
            <li><a href='#tabs-1'>Lorem ipsum dolor sit amet, consectetur adipisicing <br> <small>John Doe &nbsp;|&nbsp;
                  27.07.2020 10:10</small></a></li>
            <li><a href='#tabs-2'>Mauris lobortis quam id dictum dignissim <br> <small>John Doe &nbsp;|&nbsp; 27.07.2020
                  10:10</small></a></li>
            <li><a href='#tabs-3'>Class aptent taciti sociosqu ad litora torquent per <br> <small>John Doe &nbsp;|&nbsp;
                  27.07.2020 10:10</small></a></li>
          </ul>

          <br>

          <div class="text-center">
            <a href="pages/blog.html" class="filled-button">Read More</a>
          </div>

          <br>
        </div>

        <div class="col-md-8">
          <section class='tabs-content'>
            <article id='tabs-1'>
              <img src="../../Public/assets/images/blog-image-1-940x460.jpg" alt="">
              <h4><a href="pages/blog-details.html">Lorem ipsum dolor sit amet, consectetur adipisicing.</a></h4>
              <p>Sed ut dolor in augue cursus ultrices. Vivamus mauris turpis, auctor vel facilisis in, tincidunt vel
                diam. Sed vitae scelerisque orci. Nunc non magna orci. Aliquam commodo mauris ante, quis posuere nibh
                vestibulum sit amet.</p>
            </article>
            <article id='tabs-2'>
              <img src="../../Public/assets/images/blog-image-2-940x460.jpg" alt="">
              <h4><a href="pages/blog-details.html">Mauris lobortis quam id dictum dignissim</a></h4>
              <p>Sed ut dolor in augue cursus ultrices. Vivamus mauris turpis, auctor vel facilisis in, tincidunt vel
                diam. Sed vitae scelerisque orci. Nunc non magna orci. Aliquam commodo mauris ante, quis posuere nibh
                vestibulum sit amet</p>
            </article>
            <article id='tabs-3'>
              <img src="../../Public/assets/images/blog-image-3-940x460.jpg" alt="">
              <h4><a href="pages/blog-details.html">Class aptent taciti sociosqu ad litora torquent per</a></h4>
              <p>Mauris lobortis quam id dictum dignissim. Donec pellentesque erat dolor, cursus dapibus turpis
                hendrerit quis. Suspendisse at suscipit arcu. Nulla sed erat lectus. Nulla facilisi. In sit amet neque
                sapien. Donec scelerisque mi at gravida efficitur. Nunc lacinia a est eu malesuada. Curabitur eleifend
                elit sapien, sed pulvinar orci luctus eget.
              </p>
            </article>
          </section>
        </div>
      </div>


    </div>
  </div>

  <div class="testimonials">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="section-heading">
            <h2>What they say <em>about us</em></h2>
            <span>testimonials from our greatest clients</span>
          </div>
        </div>
        <div class="col-md-12">
          <div class="owl-testimonials owl-carousel">

            <div class="testimonial-item">
              <div class="inner-content">
                <h4>George Walker</h4>
                <span>Chief Financial Analyst</span>
                <p>"Nulla ullamcorper, ipsum vel condimentum congue, mi odio vehicula tellus, sit amet malesuada justo
                  sem sit amet quam. Pellentesque in sagittis lacus."</p>
              </div>
              <img src="../../Public/assets/img/placeholder.jpg" alt="">
            </div>

            <div class="testimonial-item">
              <div class="inner-content">
                <h4>John Smith</h4>
                <span>Market Specialist</span>
                <p>"In eget leo ante. Sed nibh leo, laoreet accumsan euismod quis, scelerisque a nunc. Mauris accumsan,
                  arcu id ornare malesuada, est nulla luctus nisi."</p>
              </div>
              <img src="../../Public/assets/img/placeholder.jpg" alt="">
            </div>

            <div class="testimonial-item">
              <div class="inner-content">
                <h4>David Wood</h4>
                <span>Chief Accountant</span>
                <p>"Ut ultricies maximus turpis, in sollicitudin ligula posuere vel. Donec finibus maximus neque, vitae
                  egestas quam imperdiet nec. Proin nec mauris eu tortor consectetur tristique."</p>
              </div>
              <img src="../../Public/assets/img/placeholder.jpg" alt="">
            </div>

            <div class="testimonial-item">
              <div class="inner-content">
                <h4>Andrew Boom</h4>
                <span>Marketing Head</span>
                <p>"Curabitur sollicitudin, tortor at suscipit volutpat, nisi arcu aliquet dui, vitae semper sem turpis
                  quis libero. Quisque vulputate lacinia nisl ac lobortis."</p>
              </div>
              <img src="../../Public/assets/img/placeholder.jpg" alt="">
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="callback-form">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="section-heading">
            <h2>Request a <em>call back</em></h2>
            <span>Etiam suscipit ante a odio consequat</span>
          </div>
        </div>
        <div class="col-md-12">
          <div class="contact-form">
            <form id="contact" action="" method="post">
              <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12">
                  <fieldset>
                    <input name="name" type="text" class="form-control" id="name" placeholder="Full Name" required="">
                  </fieldset>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                  <fieldset>
                    <input name="email" type="text" class="form-control" id="email" pattern="[^ @]*@[^ @]*"
                      placeholder="E-Mail Address" required="">
                  </fieldset>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                  <fieldset>
                    <input name="subject" type="text" class="form-control" id="subject" placeholder="Subject"
                      required="">
                  </fieldset>
                </div>
                <div class="col-lg-12">
                  <fieldset>
                    <textarea name="message" rows="6" class="form-control" id="message" placeholder="Your Message"
                      required=""></textarea>
                  </fieldset>
                </div>
                <div class="col-lg-12">
                  <fieldset>
                    <button type="submit" id="form-submit" class="border-button">Send Message</button>
                  </fieldset>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <br>
      <br>
      <br>
      <br>
    </div>
  </div>

  <!-- Footer Starts Here -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-3 footer-item">
          <h4>LogiXpress</h4>
          <p>Vivamus tellus mi. Nulla ne cursus elit,vulputate. Sed ne cursus augue hasellus lacinia sapien vitae.</p>
          <ul class="social-icons">
            <li><a rel="nofollow" href="#" target="_blank"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
          </ul>
        </div>
        <div class="col-md-3 footer-item">
          <h4>Useful Links</h4>
          <ul class="menu-list">
            <li><a href="#">Vivamus ut tellus mi</a></li>
            <li><a href="#">Nulla nec cursus elit</a></li>
            <li><a href="#">Vulputate sed nec</a></li>
            <li><a href="#">Cursus augue hasellus</a></li>
            <li><a href="#">Lacinia ac sapien</a></li>
          </ul>
        </div>
        <div class="col-md-3 footer-item">
          <h4>Additional Pages</h4>
          <ul class="menu-list">
            <li><a href="#">Products</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">Terms</a></li>
          </ul>
        </div>
        <div class="col-md-3 footer-item last-item">
          <h4>Contact Us</h4>
          <div class="contact-form">
            <form id="contact footer-contact" action="" method="post">
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <fieldset>
                    <input name="name" type="text" class="form-control" id="name" placeholder="Full Name" required="">
                  </fieldset>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <fieldset>
                    <input name="email" type="text" class="form-control" id="email" pattern="[^ @]*@[^ @]*"
                      placeholder="E-Mail Address" required="">
                  </fieldset>
                </div>
                <div class="col-lg-12">
                  <fieldset>
                    <textarea name="message" rows="6" class="form-control" id="message" placeholder="Your Message"
                      required=""></textarea>
                  </fieldset>
                </div>
                <div class="col-lg-12">
                  <fieldset>
                    <button type="submit" id="form-submit" class="filled-button">Send Message</button>
                  </fieldset>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <div class="sub-footer">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <p>
            Copyright © 2020 Company Name
            - Template by: <a href="https://www.phpjabbers.com/">PHPJabbers.com</a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript -->
  <script src="../../Public/vendor/jquery/jquery.min.js"></script>
  <script src="../../Public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Additional Scripts -->
  <script src="../../Public/assets/js/custom.js"></script>
  <script src="../../Public/assets/js/owl.js"></script>
  <script src="../../Public/assets/js/slick.js"></script>
  <script src="../../Public/assets/js/accordions.js"></script>

  <script language="text/Javascript">
    cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
    function clearField(t) { //declaring the array outside of the
      if (!cleared[t.id]) { // function makes it static and global
        cleared[t.id] = 1; // you could use true and false, but that's more typing
        t.value = ''; // with more chance of typos
        t.style.color = '#fff';
      }
    }
  </script>

</body>

</html>