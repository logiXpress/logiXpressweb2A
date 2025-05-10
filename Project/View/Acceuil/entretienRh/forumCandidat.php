<!DOCTYPE html>
<html lang="en">

  <head>
  <style>
  
  #datetime {
    background-color: white;
    color: black;
  }

  
  .flatpickr-input {
    background-color: white !important; 
    color: black !important;
  }

  
  .flatpickr-calendar {
    background-color: #fff;
    border: 1px solid #ccc;
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

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="../../../Public/assets/css/fontawesome.css">
    <link rel="stylesheet" href="../../../Public/assets/css/style.css">
    <link rel="stylesheet" href="../../../Public/assets/css/owl.css">
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
                  <a class="dropdown-item active" href="forumCandidat.php">Join Us</a>
                  <a class="dropdown-item" href="dataTableCandidat.php">List</a>
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
            <h1>Join Us</h1>
            <span>Please Fill This Form</span>
          </div>
        </div>
      </div>
    </div>

    <div class="services">
      
        <div class="callback-form">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Request to <em>Join us</em></h2>
              <span>Fill This Form</span>
            </div>
          </div>
          <div class="col-md-12">
            <div class="contact-form">
              <form id="contact" action="conAjouterCandidat.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-lg-6">
                    <fieldset>
                      <input  type="text" name="nom" id="nom"  class="form-control" placeholder="Last Name" />
                    </fieldset>
                  </div>
                  <div class="col-lg-6">
                    <fieldset>
                      <input class="form-control" type="text" name="prenom" id="prenom" placeholder="Name"/>
                    </fieldset>
                  </div>
                  <div class="col-lg-6 col-md-12 col-sm-12">
                    <fieldset>
                      <input type="text" name="email" id="email" class="form-control" placeholder="Email"/>
                    </fieldset>
                  </div>

                  
                  <div class="col-lg-6">
                    <fieldset>
                      <input  type="text" name="telephone" id="telephone" class="form-control" placeholder="Phone Number" />
                    </fieldset>
                  </div>



                  <div class="col-lg-6">
                    <fieldset>
                    <input type="text" name="date" id="datetime" class="form-control" placeholder="YYYY/MM/DD HH:MM" />

                    </fieldset>
                  </div>


                  <div class="col-lg-6">
  <fieldset>
    <!-- Hidden file input -->
    <input type="file" name="CV" id="CV" accept=".pdf" style="display: none;" />

    <!-- Upload button -->
    <button type="button" id="form-submit" class="border-button">Upload Your CV</button>

    <!-- File info section -->
    <div id="file-info" style="margin-top: 10px; display: none;">
      <p id="file-name" style="margin-bottom: 5px;"></p>
      <button type="button" id="view-btn" class="border-button">View</button>
      <button type="button" id="delete-btn" class="border-button">Delete</button>
    </div>
  </fieldset>
</div>


                  
                  <div class="col-lg-12">
                    <fieldset>
                      <button type="submit" id="form-submit" class="border-button">Submit</button>
                    </fieldset>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
         

          

         

          

          
        </div>

        <br>
        <br>

       

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

    <!-- Additional Scripts -->
    <script src="../../../Public/assets/js/custom.js"></script>
    <script src="../../../Public/assets/js/owl.js"></script>
    <script src="../../../Public/assets/js/slick.js"></script>
    <script src="../../../Public/assets/js/accordions.js"></script>

    <script language = "text/Javascript"> 
      cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
      function clearField(t){                   //declaring the array outside of the
      if(! cleared[t.id]){                      // function makes it static and global
          cleared[t.id] = 1;  // you could use true and false, but that's more typing
          t.value='';         // with more chance of typos
          t.style.color='#fff';
          }
      }
    </script>

<script>
  const fileInput = document.getElementById('CV');
  const uploadBtn = document.getElementById('form-submit');
  const fileInfo = document.getElementById('file-info');
  const fileNameDisplay = document.getElementById('file-name');
  const viewBtn = document.getElementById('view-btn');
  const deleteBtn = document.getElementById('delete-btn');

  uploadBtn.addEventListener('click', () => {
    fileInput.click();
  });

  fileInput.addEventListener('change', () => {
    if (fileInput.files.length > 0) {
      const file = fileInput.files[0];

      // Hide upload button
      uploadBtn.style.display = 'none';

      // Show file info
      fileNameDisplay.textContent = "Selected file: " + file.name;
      fileInfo.style.display = 'block';

      // View button
      viewBtn.onclick = () => {
        const fileURL = URL.createObjectURL(file);
        window.open(fileURL, '_blank');
      };

      // Delete button
      deleteBtn.onclick = () => {
        fileInput.value = '';
        fileInfo.style.display = 'none';
        uploadBtn.style.display = 'inline-block'; // Show upload button again
      };
    }
  });
</script>
<!-- Initialize Flatpickr -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
  flatpickr("#datetime", {
    enableTime: true,
    dateFormat: "YYYY/mmm/dd H:i",  // yyyy/mm/dd HH:MM
    time_24hr: true           // Use 24-hour time
  });
</script>
  </body>
</html>