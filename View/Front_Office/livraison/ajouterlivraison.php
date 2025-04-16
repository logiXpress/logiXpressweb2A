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
          <div class="row justify-content-center">
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <div class="icon">
                    <i class="material-icons">contacts</i>
                  </div>
                  <h3 class="card-title">Informations du Colis</h3>
                </div>
                <div class="card-body">
                  <form>
                    <!-- Input groups -->
                    <br><br>
                    <div class="mb-3">
                      <label class="form-label">Tel *</label>
                      <input type="tel" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Tel2</label>
                      <input type="tel" class="form-control">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Nom *</label>
                      <input type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Adresse *</label>
                      <input type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Gouvernorat *</label>
                      <input type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Délégation *</label>
                      <input type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Localité *</label>
                      <input type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Commentaire</label>
                      <textarea class="form-control" rows="3"></textarea>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Second Form -->
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <div class="icon">
                    <i class="material-icons">add_box</i>
                  </div>
                  <h3 class="card-title">Paramètres du client</h3>
                </div>
                <div class="card-body">
                  <form>
                    <br><br>
                    <div class="mb-3">
                      <label class="form-label">Code *</label>
                      <input type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Prix (en TND) *</label>
                      <input type="number" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">NB Pièces ?</label>
                      <input type="number" class="form-control" value="1">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Désignation *</label>
                      <input type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Poids (Kg) *</label>
                      <input type="number" class="form-control" value="1" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Exchange *</label><br>
                      <select class="selectpicker" data-size="7" data-style="btn btn-rose btn-round" title="Single Select ">
                        <option disabled selected>Choisir une option</option>
                        <option value="oui">Oui</option>
                        <option value="non">Non</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Type *</label><br>
                      <select class="selectpicker" data-size="7" data-style="btn btn-rose btn-round" title="Single Select ">
                        <option disabled selected>Choisir le type</option>
                        <option value="fix">Fix</option>
                        <option value="fragile">Fragile</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label d-block">Fragile</label>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fragile" value="oui">
                        <label class="form-check-label">Oui</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fragile" value="non">
                        <label class="form-check-label">Non</label>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Single Submit Button for Both Forms -->
      <div class="d-flex justify-content-center mt-4">
        <button type="submit" class="btn btn-primary btn-lg w-25">
          <i class="material-icons">send</i> Submit
        </button>
      </div>


      <?php require_once '../includes/footer.php'; ?>
    </div>
  </div>

</body>

</html>