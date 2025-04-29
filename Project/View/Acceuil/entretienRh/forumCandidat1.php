


<!DOCTYPE html>
<html lang="en">
<?php require_once '../includes/header.php'; ?>


<style>
  #uploaded-file {
    margin-top: 20px;
}

#file-preview {
    display: flex;
    align-items: center;
}

#file-name {
    margin-right: 10px;
    font-weight: bold;
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
              <form enctype="multipart/form-data" id="TypeValidation" class="form-horizontal" action="conAjouterCandidat.php" method="post" onsubmit="return valideContenue()">
                <div class="card">
                  <div class="card-header card-header-unigreen card-header-text">
                    <div class="card-text">
                      <h4 class="card-title">Add Candidate</h4>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <label class="col-sm-2 col-form-label">Last Name</label>
                      <div class="col-sm-7">
                        <div class="form-group">
                          <input class="form-control" type="text" name="nom" id="nom"/>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <label class="col-sm-2 col-form-label">Name</label>
                      <div class="col-sm-7">
                        <div class="form-group">
                          <input class="form-control" type="text" name="prenom" id="prenom"/>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <label class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-7">
                        <div class="form-group">
                          <input class="form-control" type="text" name="email" id="email"/>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <label class="col-sm-2 col-form-label">Phone Number</label>
                      <div class="col-sm-7">
                        <div class="form-group">
                          <input class="form-control" type="text" name="telephone" id="telephone"/>
                        </div>
                      </div>
                    </div>

                    <div class="row justify-content-center">
                      <div class="col-md-5">
                        <div class="card">
                          <div class="card-header card-header-unigreen card-header-text">
                            <div class="card-icon">
                              <i class="material-icons">today</i>
                            </div>
                            <h4 class="card-title">Date</h4>
                          </div>
                          <div class="card-body">
                            <div class="form-group">
                              <input type="text" class="form-control datetimepicker" name="date" id="date">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-1">
    <h4 class="title">Your CV</h4>
    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
        <div class="fileinput-new thumbnail">
            <img src="../../../Public/assets/img/image_placeholder.jpg" alt="PDF Placeholder"> <!-- Placeholder for PDF -->
        </div>
        <div class="fileinput-preview fileinput-exists thumbnail"></div>
        <div>
            <span class="btn btn-unigreen btn-round btn-file">
                <span class="fileinput-new">Select PDF</span>
                <span class="fileinput-exists">Change</span>
                <input type="file" name="CV" id="CV" accept=".pdf"/> <!-- Accept only PDF files -->
            </span>
            <!-- View button positioned between Change and Remove -->
            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput">
                <i class="fa fa-times"></i> Remove
            </a>
            
        </div>
    </div>
</div>
                    </div>
                  </div>

                  <div class="card-footer ml-auto mr-auto">
                    <button type="submit" class="btn btn-unigreen">Validate</button>
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