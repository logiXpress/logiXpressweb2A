<?php
session_start();
require "../../../Controller/candidatC.php";

$id = '';
if (!isset($_POST['idCandidat']) || empty($_POST['idCandidat'])) {
    header("Location: tableCandidat.php?error=missing_id");
    exit();
}

$id = htmlspecialchars($_POST['idCandidat']);

// Optionally, validate idCandidat format (e.g., if it's a number)
if (!is_numeric($id)) {
    header("Location: tableCandidat.php?error=invalid_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once '../includes/header.php'; ?>

<body>
  <div class="wrapper">
    <?php require_once '../includes/configurator.php'; ?>
    <?php require_once '../includes/sidenav.php'; ?>
    <div class="main-panel">
      <?php require_once '../includes/navbar.php'; ?>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <form role="form" class="text-start d-flex flex-column align-items-center" method="POST" action="conAjouterEntretient.php" onsubmit="return validateForm();">
                <div class="card">
                  <div class="card-header card-header-unigreen card-header-text">
                    <div class="card-text">
                      <h4 class="card-title">Add an Interview</h4>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <label class="col-sm-2 col-form-label" for="date_entretien">Interview Date</label>
                      <div class="col-sm-7">
                        <div class="form-group">
                          <input type="text" class="form-control datetimepicker" name="date_entretient" id="date">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <label class="col-sm-2 col-form-label" for="lien_entretient">Interview Link</label>
                      <div class="col-sm-7">
                        <div class="form-group">
                          <input type="text" class="form-control" name="lien_entretient" id="lien_entretient"/>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer ml-auto mr-auto">
                    <button type="submit" class="btn btn-unigreen">Validate</button>
                  </div>
                </div>
                <input type="hidden" class="form-control" id="idCandidat1" name="idCandidat1" value="<?php echo htmlspecialchars($id); ?>" />
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

    // Sample form validation
    function validateForm() {
      let date = document.getElementById('date').value;
      let lien = document.getElementById('lien_entretient').value;

      // Check if date and link are filled out
      if (!date || !lien) {
        alert("All fields are required.");
        return false;
      }

      // Validate the interview link
      if (!lien.startsWith("https://meet.google.com/")) {
        alert("The interview link must start with 'https://meet.google.com/'");
        return false;
      }

      return true;
    }
  </script>
  <script src="../includes/valider.js"></script>
</body>
</html>
