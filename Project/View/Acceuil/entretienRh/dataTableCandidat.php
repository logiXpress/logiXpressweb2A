<?php
session_start();
require "../../../controller/candidatC.php";
$candidatC = new CandidatC();
$tab = $candidatC->listeCandidat();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        /* Ensure the input background is white and text is black */
        #datetime {
            background-color: white;
            color: black;
        }

        /* Optional: Remove Flatpickr's calendar icon or adjust styling */
        .flatpickr-input {
            background-color: white !important;
            color: black !important;
        }

        /* Optional: Style the calendar popup for better appearance */
        .flatpickr-calendar {
            background-color: #fff;
            border: 1px solid #ccc;
        }

        /* Ensure DataTables buttons don't break layout */
        .dataTables_wrapper .dt-buttons {
            margin-bottom: 10px;
        }

        /* Style for action buttons */
        .btn-action {
            margin-right: 5px;
        }

        /* Make the table full width */
        #datatables {
            width: 100% !important;
        }

        /* Ensure the DataTables wrapper takes full width */
        .dataTables_wrapper {
            width: 100% !important;
        }

        /* Adjust container to be full-width */
        .container-fluid {
            width: 100%;
            padding-left: 15px;
            padding-right: 15px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Ensure the table container doesn't constrain width */
        .col-md-12 {
            width: 100%;
            padding-left: 0;
            padding-right: 0;
        }

        /* Prevent horizontal overflow */
        .services, .callback-form {
            overflow-x: auto;
        }

        /* Reduce spacing above the table */
        .services {
            margin-top: -30px; /* Adjust this value to move the table up (negative value pulls it up) */
        }

        /* Reduce spacing below the page-heading */
        .page-heading {
            margin-bottom: 10px; /* Reduce the bottom margin */
        }
    </style>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>Our Delivery Services | LogiXpress Products</title>

    <!-- Bootstrap core CSS -->
    <link href="../../../Public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="../../../Public/assets/css/fontawesome.css">
    <link rel="stylesheet" href="../../../Public/assets/css/style.css">
    <link rel="stylesheet" href="../../../Public/assets/css/owl.css">

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

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
                        <li><a href="#"><i class="fa fa-phone"></i>+216 56 207 742</a></li>
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
                <a class="navbar-brand" href="../index.html"><h2>LogiXpress<em> Website</em></h2></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="../index.html">Home
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="products.html">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="checkout.html">Checkout</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">About</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="about.html">About Us</a>
                                <a class="dropdown-item" href="blog.html">Blog</a>
                                <a class="dropdown-item" href="testimonials.html">Testimonials</a>
                                <a class="dropdown-item" href="terms.html">Terms</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown active">
                <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Join</a>
                <div class="dropdown-menu">
                  <a class="dropdown-item " href="forumCandidat.php">Join Us</a>
                  <a class="dropdown-item active" href="dataTableCandidat.php">List</a>
                </div>
              </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.html">Contact Us</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Page Content -->
    <div class="page-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Candidates List</h1>
                    <span>This List Has All the candidates</span>
                </div>
            </div>
        </div>
    </div>

    <div class="">
        <div class="callback-form">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Display session messages -->


                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Last Name</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Date</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Last Name</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Date</th>
                                    <th class="text-right"></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                for ($i = 0; $i < count($tab); $i++) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($tab[$i]["nom"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($tab[$i]["prenom"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($tab[$i]["email"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($tab[$i]["telephone"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($tab[$i]["Date_Candidature"]) . "</td>";
                                    echo "<td class='text-right'>
                                        <form action='forumModifierCandidat.php' method='post' style='display: inline;' enctype='multipart/form-data'>
                                            <input type='hidden' name='idCandidat' value='" . $tab[$i]["id_candidat"] . "'>
                                            <button type='submit' class='btn btn-action' style='background-color: green; color: white;'>Update</button>
                                        </form>
                                        <form action='conSupprimerCandidat.php' method='post' style='display: inline;'>
                                            <input type='hidden' name='idCandidat' value='" . $tab[$i]["id_candidat"] . "'>
                                            <button type='submit' class='btn btn-action' style='background-color: black; color: white;'>Delete</button>
                                        </form>
                                    </td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <br><br><br><br>
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
                                        <input name="email" type="text" class="form-control" id="email" pattern="[^ @]*@[^ @]*" placeholder="E-Mail Address" required="">
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <textarea name="message" rows="6" class="form-control" id="message" placeholder="Your Message" required=""></textarea>
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
    <script src="../../../Public/vendor/jquery/jquery.min.js"></script>
    <script src="../../../Public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

    <!-- Additional Scripts -->
    <script src="../../../Public/assets/js/custom.js"></script>
    <script src="../../../Public/assets/js/owl.js"></script>
    <script src="../../../Public/assets/js/slick.js"></script>
    <script src="../../../Public/assets/js/accordions.js"></script>

    <!-- Flatpickr JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        // Initialize DataTables
        $(document).ready(function() {
            $('#datatables').DataTable({
                "order": [[0, "asc"]], // Default sort by Last Name (column 0) ascending
                "columnDefs": [
                    {
                        "targets": 5, // Actions column (index 5)
                        "orderable": false // Disable sorting on Actions column
                    }
                ],
                "pageLength": 10, // Number of rows per page
                "responsive": true, // Enable responsive design
                "scrollX": true // Enable horizontal scrolling if needed
            });
        });

        // Initialize Flatpickr
        flatpickr("#datetime", {
            enableTime: true,
            dateFormat: "Y/m/d H:i",
            time_24hr: true
        });
    </script>

    <script>
        const fileInput = document.getElementById('CV');
        const uploadBtn = document.getElementById('form-submit');
        const fileInfo = document.getElementById('file-info');
        const fileNameDisplay = document.getElementById('file-name');
        const viewBtn = document.getElementById('view-btn');
        const deleteBtn = document.getElementById('delete-btn');

        if (uploadBtn && fileInput) {
            uploadBtn.addEventListener('click', () => {
                fileInput.click();
            });

            fileInput.addEventListener('change', () => {
                if (fileInput.files.length > 0) {
                    const file = fileInput.files[0];
                    uploadBtn.style.display = 'none';
                    fileNameDisplay.textContent = "Selected file: " + file.name;
                    fileInfo.style.display = 'block';
                    viewBtn.onclick = () => {
                        const fileURL = URL.createObjectURL(file);
                        window.open(fileURL, '_blank');
                    };
                    deleteBtn.onclick = () => {
                        fileInput.value = '';
                        fileInfo.style.display = 'none';
                        uploadBtn.style.display = 'inline-block';
                    };
                }
            });
        }
    </script>
</body>
</html>