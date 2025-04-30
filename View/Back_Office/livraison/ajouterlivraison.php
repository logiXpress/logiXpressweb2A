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
<script>
  $(document).ready(function() {
    $(".open-modal").click(function() {
      var livraisonId = $(this).data("id"); // Récupérer l'ID de la livraison
      $.ajax({
        url: "get_livraison.php", // Fichier PHP qui retourne les données
        type: "GET",
        data: {
          id_livraison: livraisonId
        },
        success: function(response) {
          var data = JSON.parse(response); // Convertir la réponse JSON
          $("#exampleModal input[name='id_livraison']").val(data.id_livraison);
          $("#exampleModal textarea[name='adresse_livraison']").val(data.Adresse_livraison);
          $("#exampleModal input[name='etat']").val(data.Etat);
          $("#exampleModal input[name='montant']").val(data.Montant);
          $("#exampleModal input[name='statut_paiement']").val(data.Statut_paiement);
          $("#exampleModal select[name='mode_paiement']").val(data.Mode_paiement);
          $("#exampleModal textarea[name='description']").val(data.Description);
        }
      });
    });
  });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  (function(w, d, s, l, i) {
    w[l] = w[l] || [];
    w[l].push({
      'gtm.start': new Date().getTime(),
      event: 'gtm.js'
    });
    var f = d.getElementsByTagName(s)[0],
      j = d.createElement(s),
      dl = l != 'dataLayer' ? '&l=' + l : '';
    j.async = true;
    j.src =
      '../../../../www.googletagmanager.com/gtm5445.html?id=' + i + dl;
    f.parentNode.insertBefore(j, f);
  })(window, document, 'script', 'dataLayer', 'GTM-NKDMSK6');
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function() {
    $(".open-modal").click(function() {
      var livraisonId = $(this).data("id"); // Récupérer l'ID de la livraison
      $.ajax({
        url: "get_livraison.php", // Fichier PHP qui retourne les données
        type: "GET",
        data: {
          id_livraison: livraisonId
        },
        success: function(response) {
          var data = JSON.parse(response); // Convertir la réponse JSON
          $("#exampleModal input[name='id_livraison']").val(data.id_livraison);
          $("#exampleModal textarea[name='adresse_livraison']").val(data.Adresse_livraison);
          $("#exampleModal input[name='etat']").val(data.Etat);
          $("#exampleModal input[name='montant']").val(data.Montant);
          $("#exampleModal input[name='statut_paiement']").val(data.Statut_paiement);
          $("#exampleModal select[name='mode_paiement']").val(data.Mode_paiement);
          $("#exampleModal textarea[name='description']").val(data.Description);
        }
      });
    });
  });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function() {
    $(".clickable-row").on("click", function() {
      // Get data attributes from the clicked row
      var id = $(this).data("id");
      var adresse = $(this).data("adresse");
      var etat = $(this).data("etat");
      var montant = $(this).data("montant");
      var statut = $(this).data("statut");
      var mode = $(this).data("mode");
      var description = $(this).data("description");

      // Set the modal fields
      $("#livraison-id").text(id);
      $("#livraison-adresse").text(adresse);
      $("#livraison-etat").text(etat);
      $("#livraison-montant").text(montant);
      $("#livraison-statut").text(statut);
      $("#livraison-mode").text(mode);
      $("#livraison-description").val(description);
    });
  });
</script>
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
                      
                      <input type="tel" name="phone1" class="form-control" >
                      <small class="error-message text-danger"></small> <!-- Moved above the input -->

                    </div>
                    <div class="mb-3">
                      <label class="form-label">Phone2</label>
                      <input type="tel" name="phone2" class="form-control">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Name *</label>
                      <input type="text" name="name" class="form-control" >
                    </div>
                    <div id="map"></div>
                    <div class="mb-3">
                      <label class="form-label">Adresse *</label>
                      <input type="text" name="address" class="form-control" >
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Goverment *</label>
                      <input type="text" name="goverment" class="form-control" >
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Delegation *</label>
                      <input type="text" name="delegation" class="form-control" >
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Local *</label>
                      <input type="text" name="local" class="form-control" >
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
                      <input type="number" step="0.01" name="price" class="form-control" >
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Number of Pieces</label>
                      <input type="number" name="pieces" class="form-control" value="1">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Designation *</label>
                      <input type="text" name="designation" class="form-control" >
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Weight (Kg) *</label>
                      <small class="error-message text-danger"></small> <!-- Moved above the input -->

                      <input type="number" name="weight" class="form-control" value="1" >
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Switch *</label><br>
                      <select name="switch" class="selectpicker" data-style="btn btn-rose btn-round" >
                        <option value="" disabled selected>Choose an option</option>
                        <option value="oui">Yes</option>
                        <option value="non">No</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Type *</label><br>
                      <select name="type" class="selectpicker" data-style="btn btn-rose btn-round" >
                        <option value="" disabled selected>Choose the type</option>
                        <option value="Standard">Standard</option>
                        <option value="fragile">Fragile</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="d-flex justify-content-center mt-4">
                  <button type="submit" class="btn btn-unigreen btn-lg w-25">
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
  function clearErrors() {
  const inputs = document.querySelectorAll('input, select');
  inputs.forEach(input => {
    input.placeholder = input.dataset.originalPlaceholder || ''; // Reset to original
    input.classList.remove('is-invalid'); // Optional styling
  });
}

function showError(input, message) {
  if (!input.dataset.originalPlaceholder) {
    input.dataset.originalPlaceholder = input.placeholder;
  }
  input.value = ''; // Clear the value so the placeholder is visible
  input.placeholder = message;
  input.classList.add('is-invalid'); // Optional styling
}

function validateForm(event) {
  clearErrors(); // Clear previous messages
  let valid = true;
  const phone2 = document.querySelector('input[name="phone2"]');
  const phone1 = document.querySelector('input[name="phone1"]');
  const name = document.querySelector('input[name="name"]');
  const address = document.querySelector('input[name="address"]');
  const goverment = document.querySelector('input[name="goverment"]');
  const delegation = document.querySelector('input[name="delegation"]');
  const local = document.querySelector('input[name="local"]');
  const price = document.querySelector('input[name="price"]');
  const pieces = document.querySelector('input[name="pieces"]');
  const designation = document.querySelector('input[name="designation"]');
  const weight = document.querySelector('input[name="weight"]');
  const switchOption = document.querySelector('select[name="switch"]');
  const type = document.querySelector('select[name="type"]');

  const phoneRegex = /^[0-9]{8}$/;

  if (!phone1.value.match(phoneRegex)) {
    showError(phone2, "8-digit phone number");
    valid = false;
  }
  if (!phone1.value.match(phoneRegex)) {
    showError(phone1, "8-digit phone number");
    valid = false;
  }
  if (!name.value.trim()) {
    showError(name, "Name is required");
    valid = false;
  }

  if (!address.value.trim()) {
    showError(address, "Address is required");
    valid = false;
  }

  if (!goverment.value.trim()) {
    showError(goverment, "Goverment is required");
    valid = false;
  }

  if (!delegation.value.trim()) {
    showError(delegation, "Delegation is required");
    valid = false;
  }

  if (!local.value.trim()) {
    showError(local, "Local is required");
    valid = false;
  }

  if (!price.value || parseFloat(price.value) <= 0) {
    showError(price, "Price > 0 required");
    valid = false;
  }

  if (!pieces.value || parseInt(pieces.value) <= 0) {
    showError(pieces, "Pieces > 0 required");
    valid = false;
  }

  if (!designation.value.trim()) {
    showError(designation, "Designation is required");
    valid = false;
  }

  if (!weight.value || parseFloat(weight.value) <= 0) {
    showError(weight, "Weight > 0 required");
    valid = false;
  }

  if (!switchOption.value) {
    switchOption.classList.add('is-invalid');
    valid = false;
  }

  if (!type.value) {
    type.classList.add('is-invalid');
    valid = false;
  }

  if (!valid) {
    event.preventDefault();
  }
}

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