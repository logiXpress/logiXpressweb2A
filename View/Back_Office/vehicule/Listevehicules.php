<?php
require_once 'C:/Users/Desktop/PHP/htdocs/Project/Model/Vehicule.php';
require_once 'C:/Users/Desktop/PHP/htdocs/Project/Controller/VehiculeC.php';

$VehiculeC = new VehiculeC();

// Gestion des actions
if (isset($_POST['add'])) {
  $VehiculeC->ajouterVehicule(new Vehicule($_POST['immatriculation'], $_POST['type'], $_POST['autonomie'], $_POST['statut']));
  header('Location: listevehicules.php');
  exit();
}

if (isset($_GET['delete'])) {
  $VehiculeC->supprimerVehicule($_GET['delete']);
  header('Location: listevehicules.php');
  exit();
}

$vehicule = null;
if (isset($_GET['id'])) {
  $vehicule = $VehiculeC->getVehiculeById($_GET['id']);
}

if (isset($_POST['update']) && $vehicule) {
  $VehiculeC->modifierVehicule($_POST['id_vehicule'], new Vehicule($_POST['immatriculation'], $_POST['type'], $_POST['autonomie'], $_POST['statut']));
  header('Location: listevehicules.php');
  exit();
}

// Rechercher les véhicules selon le terme de recherche
$searchTerm = '';
if (isset($_POST['search_btn'])) {
  $searchTerm = $_POST['search'];
}

// Appel de la méthode de recherche
$vehicules = $VehiculeC->rechercherVehicule($searchTerm);
?>

<!DOCTYPE html>
<html lang="fr">

<?php require_once '../includes/header.php'; ?>

<style>
  .card-header {
    display: flex;
    align-items: center;
    background-color: #2ecc71;
    color: white;
    padding: 15px;
    border-radius: 10px;
    justify-content: center;
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
<style>
  body {
    margin: 0;
    padding: 0;
    overflow-x: hidden;
  }

  .wrapper {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }

  .main-panel {
    flex: 1;
    overflow-y: auto;
  }

  .content {
    padding: 10px 20px;
  }

  .container-fluid {
    padding: 0 60px;
    margin-left: 0;
    width: 100%;
    display: flex;
    justify-content: center;
  }

  .card {
    width: 100%;
    max-width: none;
    padding: 30px;
    margin-top: 10px;
  }

  .card-header {
    background-color: #2ecc71;
    color: white;
    padding: 15px;
    border-top-left-radius: 40px;
    border-top-right-radius: 40px;
    text-align: center;
  }

  .form-label {
    font-weight: 600;
    width: 200px;
  }

  .form-group-row {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
  }

  .form-group-row input {
    flex: 1;
    background-color: white;
    color: black;
    border: 1px solid #ccc;
  }

  .form-group-row input:focus {
    border-color: #2ecc71;
    box-shadow: 0 0 0 0.2rem rgba(46, 204, 113, 0.25);
    outline: none;
  }

  .btn-primary {
    background-color: #2ecc71;
    border-color: #2ecc71;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .btn-primary i {
    background-color: #2ecc71;
    border-color: #2ecc71;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .btn-primary:hover {
    background-color: #27ae60;
    border-color: #27ae60;
  }

  .text-center {
    text-align: center;
  }

  img {
    max-width: 200px;
    border-radius: 10px;
  }
</style>

<body>
  <div class="wrapper">
    <?php require_once '../includes/configurator.php'; ?>
    <?php require_once '../includes/sidenav.php'; ?>

    <div class="main-panel">
      <?php require_once '../includes/navbar.php'; ?>

      <div class="content">
        <div class="container-fluid">
          <div class="row justify-content-center">

            <!-- Formulaire de modification -->
<div class="col-md-8">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Modify a Vehicle</h3>
        </div>
        <div class="card-body">
            <form method="post" onsubmit="return validateForm()">
                <input type="hidden" name="id_vehicule" value="<?= htmlspecialchars($vehicule['id_vehicule'] ?? '') ?>">

                <div class="form-group-row">
                    <label class="form-label" for="immatriculation">Registration *</label>
                    <input type="text" id="immatriculation" name="immatriculation" class="form-control" required
                        value="<?= htmlspecialchars($vehicule['Immatriculation'] ?? '') ?>" onkeypress="return isRegistrationFormat(event)">
                    <small id="immatriculationError" class="text-danger"></small>
                </div>

                <div class="form-group-row">
                    <label class="form-label" for="type">Type *</label>
                    <input type="text" id="type" name="type" class="form-control" required
                        value="<?= htmlspecialchars($vehicule['Type'] ?? '') ?>" onkeypress="return isLetter(event)">
                    <small id="typeError" class="text-danger"></small>
                </div>

                <div class="form-group-row">
                    <label class="form-label" for="autonomie">Autonomy (km) *</label>
                    <input type="number" id="autonomie" name="autonomie" class="form-control" required
                        value="<?= htmlspecialchars($vehicule['Autonomie'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label">Statut *</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="statut" id="statut_maintenance" value="In Maintenance"
                            <?= (isset($vehicule['Statut']) && $vehicule['Statut'] == 'In Maintenance') ? 'checked' : '' ?> required>
                        <label class="form-check-label" for="statut_maintenance">In Maintenance</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="statut" id="statut_service" value="In Service"
                            <?= (isset($vehicule['Statut']) && $vehicule['Statut'] == 'In Service') ? 'checked' : '' ?>>
                        <label class="form-check-label" for="statut_service">In Service</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="statut" id="statut_disponible" value="Available"
                            <?= (isset($vehicule['Statut']) && $vehicule['Statut'] == 'Available') ? 'checked' : '' ?>>
                        <label class="form-check-label" for="statut_disponible">Available</label>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" name="update" class="btn btn-primary btn-lg">
                        <i class="fas fa-pencil-alt"></i> Modify
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
  
    function isLetter(event) {
        const char = String.fromCharCode(event.which);
        if (!/^[a-zA-Z\s]$/.test(char)) {
            event.preventDefault(); // Empêche l'entrée
            return false;
        }
        return true;
    }
    function validateForm() {
        let isValid = true;
        // Validation pour le type
        const type = document.getElementById('type').value;
        const typeError = document.getElementById('typeError');
        if (!/^[a-zA-Z\s]+$/.test(type)) {
            typeError.textContent = "Le type doit contenir uniquement des lettres.";
            isValid = false;
        } else {
            typeError.textContent = "";
        }

        return isValid;
    }
    
</script>

            <!-- Liste des véhicules -->
            <div class="col-md-8">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">List Of Vehicles</h3>
                </div>
                <div class="card-body">
                  <table class="table table-hover table-bordered text-center">
                    <thead class="table-light">
                      <tr>
                        <th>ID</th>
                        <th>Registration</th>
                        <th>Type</th>
                        <th>Autonomy</th>
                        <th>Statut</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($vehicules as $veh): ?>
                        <tr>
                          <td><?= htmlspecialchars($veh['id_vehicule']) ?></td>
                          <td><?= htmlspecialchars($veh['Immatriculation']) ?></td>
                          <td><?= htmlspecialchars($veh['Type']) ?></td>
                          <td><?= htmlspecialchars($veh['Autonomie']) ?> km</td>
                          <td><?= htmlspecialchars($veh['Statut']) ?></td>
                          <td>
                            <a href="listevehicules.php?id=<?= htmlspecialchars($veh['id_vehicule']) ?>" class="btn btn-warning btn-sm">✏️</a>
                            <a href="listevehicules.php?delete=<?= htmlspecialchars($veh['id_vehicule']) ?>"
                              class="btn btn-danger btn-sm"
                              onclick="return confirm('Supprimer ce véhicule ?');">🗑️</a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>

                  <!-- Formulaire de recherche -->
                  <style>
    .form-container {
        background-color: #f8f9fa; /* Couleur gris clair */
        border: 1px solid #dee2e6; /* Bordure gris */
        border-radius: 0.375rem; /* Coins arrondis */
        padding: 20px; /* Espacement interne */
        margin: 20px 0; /* Espacement externe */
    }
</style>

<div class="form-container">
    <label for="search" class="form-label">Search by Registration:</label>
    <form method="post" class="input-group mb-3">
        <input type="text" id="search" name="search" class="form-control" placeholder="Enter registration" value="<?= htmlspecialchars($searchTerm) ?>">
        <button type="submit" name="search_btn" class="btn btn-primary btn-lg">
            <i class="fas fa-search"></i> Search
        </button>
    </form>
</div>
                    <!-- Bouton de rafraîchissement -->
                    <form method="post">
                    <div style="display: flex; justify-content: center; margin: 20px 0;">
                      <button type="submit" name="refresh_btn" class="btn btn-primary btn-lg" style="
    background-color: #2ecc71;
    border-color: #2ecc71;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;">
                        <i class="fas fa-refresh"></i> Refresh
                      </button>

                    </form>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php require_once '../includes/footer.php'; ?>
    </div>
  </div>

</body>

</html>