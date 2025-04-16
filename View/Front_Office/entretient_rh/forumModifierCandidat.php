
<?php
// Start the session if needed
session_start();

// Include your necessary files
require "../../../controller/candidatC.php"; // Adjust the path as needed

// Initialize variables
$idCandidat = null;
$nom = '';
$prenom = '';
$email = '';
$telephone = '';
$CV = '';
$date = '';

// Check if the ID is set in the POST request
if (isset($_POST['idCandidat']) && is_numeric($_POST['idCandidat'])) {
    $idCandidat = intval($_POST['idCandidat']);
} else {
    echo "Error";
    
    exit();
}

$candidatC = new CandidatC();
$tab = $candidatC->ChercherCandidatByID($idCandidat);


if (isset($tab) && !empty($tab)) {
    $nom = htmlspecialchars($tab[0]['nom']);
    $prenom = htmlspecialchars($tab[0]['prenom']);
    $email = htmlspecialchars($tab[0]['email']);
    $telephone = htmlspecialchars($tab[0]['telephone']);
    $CV = htmlspecialchars($tab[0]['CV']);
    
    // Fetch the date
    $date = isset($tab[0]['Date_Candidature']) ? htmlspecialchars($tab[0]['Date_Candidature']) : '';
    
    // Format the date to Y/m/d
    if (!empty($date)) {
        $date = date('Y/m/d h:i A', strtotime($date)); // Format to Y/m/d
    } else {
        $date = ''; // Handle empty date
    }
    

} else {
    echo "No candidate data available.";
}

?>

<!DOCTYPE html>
<html lang="en">
<?php require_once '../includes/header.php'; ?>

<style>
  .card-header {
    display: flex;
    align-items: center;
    background-color: #2ecc71;
    /* Unigreen color */
    color: white;
    padding: 15px;
    border-radius: 10px;
    /* Rounded edges for the header */
    position: absolute;
    top: -35px;
    left: 2px;
    width: calc(100% - 10px);
    /* To fit with the card width */
  }

  .icon {
    background: #2ecc71;
    /* Unigreen color */
    color: white;
    border-radius: 5px;
    /* Now it's rectangular */
    padding: 20px;
    margin-right: 10px;
    margin-bottom: 15px;
  }

  .card {
    border: none;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    border-radius: 12px;
    margin-bottom: 30px;
  }

  .form-label {
    font-weight: 600;
  }

  .btn-primary {
    background-color: #2ecc71;
    border-color: #2ecc71;
  }

  .btn-primary:hover {
    background-color: #27ae60;
    border-color: #27ae60;
  }
</style>

<body class="">

  <div class="wrapper">
    <?php require_once '../includes/configurator.php'; ?>
    <?php require_once '../includes/sidenav.php'; ?>
    <div class="main-panel">
      <?php require_once '../includes/navbar.php'; ?>
      <div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
            <form id="TypeValidation" class="form-horizontal" action="conModifierCandidat.php" method="post" enctype="multipart/form-data" onsubmit="return valideContenue()">
    <div class="card">
        <div class="card-header card-header-unigreen card-header-text">
            <div class="card-text">
                <h4 class="card-title">Update Candidate</h4>
            </div>
        </div>
        <input type="hidden" name="idCandidat" value="<?php echo htmlspecialchars($idCandidat); ?>">
        <div class="card-body">
            <div class="row">
                <label class="col-sm-2 col-form-label">Last Name</label>
                <div class="col-sm-7">
                    <div class="form-group">
                        <input class="form-control" type="text" name="nom" id="nom" value="<?php echo htmlspecialchars($nom); ?>"/>
                    </div>
                </div>
            </div>

            <div class="row">
                <label class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-7">
                    <div class="form-group">
                        <input class="form-control" type="text" name="prenom" id="prenom" value="<?php echo htmlspecialchars($prenom); ?>"/>
                    </div>
                </div>
            </div>

            <div class="row">
                <label class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-7">
                    <div class="form-group">
                        <input class="form-control" type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>"/>
                    </div>
                </div>
            </div>

            <div class="row">
                <label class="col-sm-2 col-form-label">Phone Number</label>
                <div class="col-sm-7">
                    <div class="form-group">
                        <input class="form-control" type="text" name="telephone" id="telephone" value="<?php echo htmlspecialchars($telephone); ?>"/>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header card-header-unigreen card-header-text">
                            <div class="card-icon">
                                <i class="material-icons">today</i>
                            </div>
                            <h4 class="card-title">Date</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <input type="text" class="form-control datetimepicker" name="date" value="<?php echo htmlspecialchars($date ?? ''); ?>" id="date">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-4">
    <h4 class="title">Your CV</h4>
    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
        <div class="fileinput-new thumbnail">
        <?php if (!empty($CV)): ?>
                
                    <img src="../../../Public/assets/img/pdf.png" alt="CV PDF" style="max-height: 100px; max-width: 100%;">
                
            <?php else: ?>
                <img src="../../assets/img/image_placeholder.jpg" alt="No CV uploaded">
            <?php endif; ?>
        </div>
        <div class="fileinput-preview fileinput-exists thumbnail"></div>
        <div>
            <span class="btn btn-unigreen btn-round btn-file">
                <span class="fileinput-new">Select PDF</span>
                <span class="fileinput-exists">Change</span>
                <input type="file" name="CV" id="CV" accept=".pdf"/>
            </span>
            <a id="view-file" href="<?php echo !empty($CV) ? htmlspecialchars($CV) : '#'; ?>" target="_blank" class="btn btn-info btn-round">View</a>
            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput">
                <i class="fa fa-times"></i> Remove
            </a>
        </div>
    </div>
</div>
            </div>





            

            <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-unigreen">Validate</button>
            </div>
        </div>
    </div>
</form>
            </div>
        </div>
    </div>
</div>


      <?php require_once '../includes/footer.php'; ?>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../../../Public/assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
  <script>
    $(document).ready(function() {
        $('.datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD HH:mm' // Adjust format as needed
        });
    });
  </script>
<script src="../includes/valider.js"></script>

</body>

</html>