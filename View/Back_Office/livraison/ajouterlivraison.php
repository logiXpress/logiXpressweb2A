<?php
require_once '../../../config/config.php';
require_once '../../../Model/Colis.php';
require_once '../../../Model/Livraison.php';
require_once '../../../Controller/ColisC.php';
require_once '../../../Controller/LivraisonC.php';
$livraisonC = new LivraisonC();
$livraisons = $livraisonC->afficherLivraisons();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $phone1      = $_POST['phone1'] ?? '';
  $phone2      = $_POST['phone2'] ?? '';
  $name        = $_POST['name'] ?? '';
  $address     = $_POST['address'] ?? '';
  $goverment   = $_POST['goverment'] ?? '';
  $delegation  = $_POST['delegation'] ?? '';
  $local       = $_POST['local'] ?? '';
  $comments    = $_POST['comments'] ?? '';
  $price       = isset($_POST['price']) ? floatval($_POST['price']) : 0;
  $pieces      = isset($_POST['pieces']) ? intval($_POST['pieces']) : 1;
  $designation = $_POST['designation'] ?? '';
  $weight      = isset($_POST['weight']) ? floatval($_POST['weight']) : 1.00;
  $switch      = $_POST['switch'];
  $type        = $_POST['type'];

  $colisController = new ColisC();
  $livraisonController = new LivraisonC();

  try {
    $colis = new Colis($name, $phone1, $phone2, $designation, $pieces, $weight, $type, $comments);
    $colisController->ajouterColis($colis);

    $pdo = config::getConnexion();
    $id_colis = $pdo->lastInsertId();

    $livraison = new Livraison($address, 'en attente', $price, 'en attente', 'Cash', $designation, $goverment, $delegation, $local, $id_colis);
    $livraisonController->ajouterLivraison($livraison);

    echo "<script>alert('Data has been successfully inserted into colis and livraisons tables!');</script>";
  } catch (PDOException $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once '../includes/header.php'; ?>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.locatecontrol/dist/L.Control.Locate.min.css" />
<style>
  .material-datatables table {
    border-collapse: separate;
    border-spacing: 0 10px;
  }

  .material-datatables thead th {
    background-color: #2ecc71;
    color: white;
    text-align: center;
    vertical-align: middle;
    border: none;
    padding: 15px;
    border-radius: 10px 10px 0 0;
  }

  .material-datatables tbody tr {
    background: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .material-datatables tbody tr:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.10);
  }

  .material-datatables tbody td {
    padding: 15px;
    vertical-align: middle;
    text-align: center;
    border: none;
  }

  .material-datatables tfoot th {
    background-color: #f4f6f9;
    font-weight: 600;
    color: #555;
    text-align: center;
    border-top: 2px solid #eaeaea;
  }

  .material-datatables .text-center {
    text-align: center;
  }
</style>

<style>
  .card-header {
    display: flex;
    align-items: center;
    background-color: #2ecc71;
    color: white;
    padding: 15px;
    border-radius: 10px;
    position: absolute;
    top: -35px;
    left: 2px;
    width: calc(100% - 10px);
  }

  .icon {
    background: #2ecc71;
    color: white;
    border-radius: 5px;
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

  #map {
    height: 300px;
    border-radius: 10px;
    margin-bottom: 20px;
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
          <form id="clientForm" method="POST" onsubmit="return validateForm(event)">
            <div class="row justify-content-center">

              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <div class="icon"><i class="material-icons">contacts</i></div>
                    <h3 class="card-title">Package Informations</h3>
                  </div>
                  <div class="card-body"><br><br>
                    <div class="mb-3">
                      <label class="form-label">Phone1 *</label>
                      <input type="tel" name="phone1" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Phone2</label>
                      <input type="tel" name="phone2" class="form-control">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Name *</label>
                      <input type="text" name="name" class="form-control" required>
                    </div>
                    <div id="map"></div>
                    <div class="mb-3">
                      <label class="form-label">Adresse *</label>
                      <input type="text" name="address" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Goverment *</label>
                      <input type="text" name="goverment" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Delegation *</label>
                      <input type="text" name="delegation" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Local *</label>
                      <input type="text" name="local" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Comments</label>
                      <textarea name="comments" class="form-control" rows="3"></textarea>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <div class="icon"><i class="material-icons">add_box</i></div>
                    <h3 class="card-title">Client Informations</h3>
                  </div>
                  <div class="card-body"><br><br>
                    <div class="mb-3">
                      <label class="form-label">Price (in TND) *</label>
                      <input type="number" step="0.01" name="price" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Number of Pieces</label>
                      <input type="number" name="pieces" class="form-control" value="1">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Designation *</label>
                      <input type="text" name="designation" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Weight (Kg) *</label>
                      <input type="number" name="weight" class="form-control" value="1" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Switch *</label><br>
                      <select name="switch" class="selectpicker" data-style="btn btn-rose btn-round" required>
                        <option value="" disabled selected>Choose an option</option>
                        <option value="oui">Yes</option>
                        <option value="non">No</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Type *</label><br>
                      <select name="type" class="selectpicker" data-style="btn btn-rose btn-round" required>
                        <option value="" disabled selected>Choose the type</option>
                        <option value="Standard">Standard</option>
                        <option value="fragile">Fragile</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="d-flex justify-content-center mt-4">
                  <button type="submit" class="btn btn-primary btn-lg w-25">
                    <i class="material-icons">send</i> Submit
                  </button>
                </div>
              </div>

              <div class="material-datatables">
                <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                  <thead>
                    <tr>
                      <th>ID Livraison</th>
                      <th>Adresse Livraison</th>
                      <th>État</th>
                      <th>Montant</th>
                      <th>Statut Paiement</th>
                      <th>Mode Paiement</th>
                      <th>Description</th>
                    </tr>
                  </thead>

                  <tfoot>
                    <tr>
                      <th>ID Livraison</th>
                      <th>Adresse Livraison</th>
                      <th>État</th>
                      <th>Montant</th>
                      <th>Statut Paiement</th>
                      <th>Mode Paiement</th>
                      <th>Description</th>
                      <th class="text-center">Actions</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php foreach ($livraisons as $livraison): ?>
                      <tr>
                        <td class="clickable-row" data-toggle="modal" data-target="#viewLivraisonModal"
                          data-id="<?= htmlspecialchars($livraison['id_livraison']) ?>"
                          data-adresse="<?= htmlspecialchars($livraison['Adresse_livraison']) ?>"
                          data-etat="<?= htmlspecialchars($livraison['Etat']) ?>"
                          data-montant="<?= htmlspecialchars($livraison['Montant']) ?>"
                          data-statut="<?= htmlspecialchars($livraison['Statut_paiement']) ?>"
                          data-mode="<?= htmlspecialchars($livraison['Mode_paiement']) ?>"
                          data-description="<?= htmlspecialchars($livraison['Description']) ?>">
                          <?= htmlspecialchars($livraison['id_livraison']) ?>
                        </td>
                        <td><?= htmlspecialchars($livraison['Adresse_livraison']) ?></td>
                        <td><?= htmlspecialchars($livraison['Etat']) ?></td>
                        <td><?= htmlspecialchars(string: $livraison['Montant']) ?></td>
                        <td><?= htmlspecialchars($livraison['Statut_paiement']) ?></td>
                        <td><?= htmlspecialchars($livraison['Mode_paiement']) ?></td>
                        <td><?= substr(htmlspecialchars($livraison['Description']), 0, 30) ?>...</td> <!-- Shortened for display -->
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </form>
        </div>
      </div>

      <?php require_once '../includes/footer.php'; ?>
    </div>
  </div>

  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
  <script src="https://unpkg.com/leaflet.locatecontrol/dist/L.Control.Locate.min.js"></script>
  <script>
  // Validate form on submit
  function validateForm(event) {
    // Get the form fields
    const phone1 = document.querySelector('input[name="phone1"]');
    const phone2 = document.querySelector('input[name="phone2"]');
    const name = document.querySelector('input[name="name"]');
    const address = document.querySelector('input[name="address"]');
    const goverment = document.querySelector('input[name="goverment"]');
    const delegation = document.querySelector('input[name="delegation"]');
    const local = document.querySelector('input[name="local"]');
    const comments = document.querySelector('textarea[name="comments"]');
    const price = document.querySelector('input[name="price"]');
    const pieces = document.querySelector('input[name="pieces"]');
    const designation = document.querySelector('input[name="designation"]');
    const weight = document.querySelector('input[name="weight"]');
    const switchOption = document.querySelector('select[name="switch"]');
    const type = document.querySelector('select[name="type"]');

    // Regular expression for validating phone number (example: US format)
    const phoneRegex = /^[0-9]{8}$/;

    // Check required fields
    if (!phone1.value.match(phoneRegex)) {
      alert("Phone1 must be a 8-digit number.");
      phone1.focus();
      event.preventDefault();
      return false;
    }
    if (!name.value.trim()) {
      alert("Name is required.");
      name.focus();
      event.preventDefault();
      return false;
    }
    if (!address.value.trim()) {
      alert("Address is required.");
      address.focus();
      event.preventDefault();
      return false;
    }
    if (!goverment.value.trim()) {
      alert("Goverment is required.");
      goverment.focus();
      event.preventDefault();
      return false;
    }
    if (!delegation.value.trim()) {
      alert("Delegation is required.");
      delegation.focus();
      event.preventDefault();
      return false;
    }
    if (!local.value.trim()) {
      alert("Local is required.");
      local.focus();
      event.preventDefault();
      return false;
    }
    if (!price.value || parseFloat(price.value) <= 0) {
      alert("Price must be greater than 0.");
      price.focus();
      event.preventDefault();
      return false;
    }
    if (!pieces.value || parseInt(pieces.value) <= 0) {
      alert("Number of pieces must be greater than 0.");
      pieces.focus();
      event.preventDefault();
      return false;
    }
    if (!designation.value.trim()) {
      alert("Designation is required.");
      designation.focus();
      event.preventDefault();
      return false;
    }
    if (!weight.value || parseFloat(weight.value) <= 0) {
      alert("Weight must be greater than 0.");
      weight.focus();
      event.preventDefault();
      return false;
    }
    if (!switchOption.value) {
      alert("Switch option must be selected.");
      switchOption.focus();
      event.preventDefault();
      return false;
    }
    if (!type.value) {
      alert("Type must be selected.");
      type.focus();
      event.preventDefault();
      return false;
    }
    
    // If all validations pass, allow form submission
    return true;
  }

  // Attach validation function to form
  document.querySelector('form').addEventListener('submit', validateForm);
</script>

  <script>
    // Tunisia bounding box
    const tunisiaBounds = L.latLngBounds([30.228, 7.524], [37.541, 11.588]);
    const map = L.map('map', {
      minZoom: 6,
      maxZoom: 18
    }).setView([34.0, 9.0], 7);
    map.setMaxBounds(tunisiaBounds);
    map.on('drag', () => map.panInsideBounds(tunisiaBounds, {
      animate: false
    }));

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    L.Control.geocoder({
      defaultMarkGeocode: true
    }).addTo(map);
    L.control.locate({
      position: 'topright',
      flyTo: true,
      initialZoomLevel: 15,
      strings: {
        title: "Show me where I am!"
      },
      locateOptions: {
        maxZoom: 16,
        enableHighAccuracy: true
      }
    }).addTo(map);

    let marker;
    map.on('click', function(e) {
      const lat = e.latlng.lat;
      const lng = e.latlng.lng;
      if (marker) map.removeLayer(marker);
      marker = L.marker([lat, lng]).addTo(map);
      fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
        .then(response => response.json())
        .then(data => {
          if (data.address) {
            const address = data.address;
            document.querySelector('input[name="address"]').value = data.display_name || '';
            document.querySelector('input[name="goverment"]').value = address.state || '';
            document.querySelector('input[name="delegation"]').value = address.city_district || address.city || '';
            document.querySelector('input[name="local"]').value = address.village || address.suburb || '';
          }
        });
    });
  </script>

</body>

</html>
<div class="modal fade" id="viewLivraisonModal" tabindex="-1" role="dialog" aria-labelledby="viewLivraisonLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title fw-bold fs-4" id="viewLivraisonLabel">Détails de la Livraison</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><strong>ID Livraison:</strong> <span id="livraison-id"></span></p>
        <p><strong>Adresse Livraison:</strong> <span id="livraison-adresse"></span></p>
        <p><strong>État:</strong> <span id="livraison-etat"></span></p>
        <p><strong>Montant:</strong> <span id="livraison-montant"></span></p>
        <p><strong>Statut Paiement:</strong> <span id="livraison-statut"></span></p>
        <p><strong>Mode Paiement:</strong> <span id="livraison-mode"></span></p>
        <p><strong>Description:</strong></p>
        <textarea id="livraison-description" class="form-control" rows="5" readonly></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary px-4 py-2" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>