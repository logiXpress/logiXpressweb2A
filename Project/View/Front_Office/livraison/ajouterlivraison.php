<?php
require_once '../../../config/config.php';
require_once '../../../Model/Colis.php';
require_once '../../../Model/Livraison.php';
require_once '../../../Controller/ColisC.php';
require_once '../../../Controller/LivraisonC.php';

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
    $switch      = $_POST['switch'] ?? 'non';
    $type        = $_POST['type'] ?? 'Standard';
    $fragile     = $_POST['fragile'] ?? 'non';

    $colisController = new ColisC();
    $livraisonController = new LivraisonC();

    try {
        $colis = new Colis($name, $phone1, $phone2, $designation, $pieces, $weight, $type, $comments);
        $colisController->ajouterColis($colis);

        $pdo = config::getConnexion();
        $colis_id = $pdo->lastInsertId();

        $livraison = new Livraison($address, 'en attente', $price, 'en attente', 'Cash', $designation, $goverment, $delegation, $local,$colis_id);
        $livraisonController->ajouterLivraison($livraison);

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
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
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    border-radius: 12px;
    margin-bottom: 30px;
  }
  .form-label { font-weight: 600; }
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
        <div class="row justify-content-center">

          <form method="POST" class="row justify-content-center w-100">

            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <div class="icon"><i class="material-icons">contacts</i></div>
                  <h3 class="card-title">Package Informations</h3>
                </div>
                <div class="card-body">
                  <br><br>
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
                <div class="card-body">
                  <br><br>
                  <div class="mb-3">
                    <label class="form-label">Price (in TND) *</label>
                    <input type="number" name="price" step="0.01" class="form-control" required>
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
                    <input type="number" name="weight" class="form-control" value="1" step="0.01" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Switch *</label><br>
                    <select name="switch" class="selectpicker" required>
                      <option disabled selected>Choose an option</option>
                      <option value="oui">Yes</option>
                      <option value="non">No</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Type *</label><br>
                    <select name="type" class="selectpicker" required>
                      <option disabled selected>Choose the type</option>
                      <option value="fix">Fix</option>
                      <option value="fragile">Fragile</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label class="form-label d-block">Fragile</label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="fragile" value="oui">
                      <label class="form-check-label">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="fragile" value="non">
                      <label class="form-check-label">No</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-center mt-4">
              <button type="submit" class="btn btn-primary btn-lg w-25">
                <i class="material-icons">send</i> Submit
              </button>
            </div>

          </form>

        </div>
      </div>
    </div>
    <?php require_once '../includes/footer.php'; ?>
  </div>
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script src="https://unpkg.com/leaflet.locatecontrol/dist/L.Control.Locate.min.js"></script>

<script>
const tunisiaBounds = L.latLngBounds(
  [30.228, 7.524],
  [37.541, 11.588]
);
const map = L.map('map', {minZoom:6,maxZoom:18}).setView([34.0, 9.0], 7);
map.setMaxBounds(tunisiaBounds);
map.on('drag', () => map.panInsideBounds(tunisiaBounds, {animate:false}));
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap contributors' }).addTo(map);
L.Control.geocoder({ defaultMarkGeocode: true }).addTo(map);
L.control.locate({
  position:'topright',
  flyTo:true,
  initialZoomLevel:15,
  strings:{ title:"Show me where I am!" },
  locateOptions:{ maxZoom:16, enableHighAccuracy:true }
}).addTo(map);

let marker;
map.on('click', function(e) {
  const {lat, lng} = e.latlng;
  if (marker) map.removeLayer(marker);
  marker = L.marker([lat, lng]).addTo(map);
  fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
    .then(res => res.json())
    .then(data => {
      if (data.address) {
        const addr = data.address;
        document.querySelector('input[name="address"]').value = data.display_name || '';
        document.querySelector('input[name="goverment"]').value = addr.state || '';
        document.querySelector('input[name="delegation"]').value = addr.city_district || addr.city || '';
        document.querySelector('input[name="local"]').value = addr.village || addr.suburb || '';
      }
    });
});
</script>

</body>
</html>
