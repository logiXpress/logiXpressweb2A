<?php
session_start();

require "../../../controller/entretienC.php";  // Changed backslashes to forward slashes
$id = '';

$id = isset($_POST['idEntretien']) ? htmlspecialchars($_POST['idEntretien']) : '';
$entrientC=new entretienC();
$tab=$entrientC->ChercherEntretientByID($id);

if (isset($tab) && !empty($tab)) {
  $date_entretien = isset($tab[0]['date_entretien']) ? htmlspecialchars($tab[0]['date_entretien']) : '';
  $statut = isset($tab[0]['statut']) ? htmlspecialchars($tab[0]['statut']) : '';
  $lien_entretien = isset($tab[0]['lien_entretien']) ? htmlspecialchars($tab[0]['lien_entretien']) : '';
  $evaluation = isset($tab[0]['evaluation']) ? htmlspecialchars($tab[0]['evaluation']) : '';
  if (!empty($date_entretien)) {
    // Format properly for HTML datetime-local input
    $date_entretien = date('Y-m-d\TH:i', strtotime(str_replace('/', '-', $date_entretien)));
} else {
    $date_entretien = ''; // Empty if no date
}


} else {
  echo "No Entretien data available.";
  // Optionally set default values
  $date_entretien = $statut = $lien_entretien = $evaluation = '';
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
            <form id="TypeValidation" class="form-horizontal" action="conModifierEntretient.php" method="post" enctype="multipart/form-data" onsubmit="return validateUpdateForm();">

    <div class="card">
        <div class="card-header card-header-unigreen card-header-text">
            <div class="card-text">
                <h4 class="card-title">Update An Interview</h4>
            </div>
        </div>
        
        <div class="card-body">
            <div class="row">
                <label class="col-sm-2 col-form-label">Interview Date</label>
                <div class="col-sm-7">
                    <div class="form-group">
                    <input type="datetime-local" name="date_entretient" class="form-control datetimepicker" id="date_entretien"
 value="<?php echo $date_entretien; ?>" />
                    </div>
                </div>
            </div>

            <div class="row">
                <label class="col-sm-2 col-form-label">Interview Link</label>
                <div class="col-sm-7">
                    <div class="form-group ">
                    <input type="text" class="form-control form-control-success" name="lien_entretient"  id="lien_entretient" value="<?php     echo  $lien_entretien ;?>"/>
                    </div>
                </div>
            </div>

            <div class="row">
                <label class="col-sm-2 col-form-label">Status</label>
                <div class="col-sm-7">
                    <div class="form-group">
                
    <select class="form-control" name="Status_entretient"  id="Status_entretient">
        <option value="" disabled <?php if ($statut == "") echo 'selected'; ?>>Select Status</option>
        <option value="Planifié" <?php if ($statut == "Planifié") echo 'selected'; ?>>Planifié</option>
        <option value="Effectué" <?php if ($statut == "Effectué") echo 'selected'; ?>>Effectué</option>
        <option value="Annulé" <?php if ($statut == "Annulé") echo 'selected'; ?>>Annulé</option>
    </select>
</div>   
                </div>
            </div>

            <div class="row">
                <label class="col-sm-2 col-form-label">Evaluation</label>
                <div class="col-sm-7">
                    <div class="form-group">
                    <textarea class="form-control" name="Evaluation_entretient" id="Evaluation_entretient" rows="5"><?php echo htmlspecialchars($evaluation); ?></textarea>

                    </div>
                </div>
            </div>
            <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-unigreen">Update</button>
            </div>
        </div>
    </div>
    <input type="hidden" class="form-control" id="idEntretien" name="idEntretien" value="<?php echo htmlspecialchars($id); ?>" />
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

  
<script src="validerupdate.js"></script>

</body>

</html>