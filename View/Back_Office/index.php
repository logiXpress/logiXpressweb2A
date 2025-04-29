<?php
session_start();

// Debug: Check if session contains user data
echo '<pre>';
print_r($_SESSION);
echo '</pre>';

// Check if the user session exists and has the 'id' field
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
    die("User ID is missing in the session.");
}

$user = $_SESSION['user'];

// Rest of your code


// Create a database connection
$conn = new mysqli("localhost", "root", "", "db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute the SQL query
$user_id = $user['id'];
$result = $conn->query("SELECT profile_picture FROM utilisateurs WHERE id = " . $user_id);

if ($result && $row = $result->fetch_assoc()) {
  echo "<img src='" . $row['profile_picture'] . "' alt='User Image' class='img-fluid rounded'>";
} else {
  echo "<img src='https://via.placeholder.com/150' alt='User Image' class='img-fluid rounded'>";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
  <title>Welcome to LogiXpress | Fast & Secure Delivery</title>

  <!-- Bootstrap core CSS -->
  <link href="../../Public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Additional CSS Files -->
  <link rel="stylesheet" href="../../Public/assets/css/fontawesome.css">
  <link rel="stylesheet" href="../../Public/assets/css/style.css">
  <link rel="stylesheet" href="../../Public/assets/css/owl.css">
</head>

<body>

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

  <header class="navbar navbar-expand-lg">
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
          <li class="nav-item active"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="pages/products.html">Products</a></li>
          <li class="nav-item"><a class="nav-link" href="pages/checkout.html">Checkout</a></li>
          <li class="nav-item dropdown">
            <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">About</a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="pages/about.html">About Us</a>
              <a class="dropdown-item" href="pages/blog.html">Blog</a>
              <a class="dropdown-item" href="pages/testimonials.html">Testimonials</a>
              <a class="dropdown-item" href="pages/terms.html">Terms</a>
            </div>
          </li>
          <li class="nav-item"><a class="nav-link" href="pages/contact.html">Contact Us</a></li>
          <li class="nav-item"><a class="nav-link" href="signin/basic.php">Sign in</a></li>
          <li class="nav-item"><a class="nav-link" href="signup/signup.php">Register/Sign Up</a></li>
        </ul>
      </div>
    </div>
  </header>

  <!-- Client Profile Section -->
  <div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow-lg p-4" style="width: 22rem; border-radius: 20px;">
      <div class="d-flex justify-content-center">
        <img src="<?php echo $profilePicture; ?>" class="rounded-circle shadow" alt="Profile Picture" width="150" height="150">
      </div>
      <div class="card-body text-center">
        <h3 class="card-title"><?php echo htmlspecialchars($user['Prénom']) . ' ' . htmlspecialchars($user['Nom']); ?></h3>
        <p class="card-text">
          <strong>Email:</strong><br>
          <?php echo htmlspecialchars($user['Email']); ?><br><br>
          <strong>Téléphone:</strong><br>
          <?php echo htmlspecialchars($user['phone_number']); ?>
        </p>
        <a href="#" class="btn btn-primary mt-2">Modifier Profil</a>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript -->
  <script src="../../Public/vendor/jquery/jquery.min.js"></script>
  <script src="../../Public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
