<!DOCTYPE html>
<html lang="en">
<?php
require_once '../../../config/config.php';
require_once '../../../Model/Livraison.php';
require_once '../../../Controller/LivraisonC.php';
$livraisonC = new LivraisonC();
$livraisons = $livraisonC->afficherLivraisons(); ?>
<?php require_once '../includes/header.php'; ?>

<body class="">

  <div class="wrapper ">

    <?php require_once '../includes/configurator.php'; ?>
    <?php require_once '../includes/sidenav.php'; ?>
    <div class="main-panel">

      <?php require_once '../includes/navbar.php'; ?>

      <div class="content">
        <div class="content">
          <div class="container-fluid">
            <div class="content">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-header card-header-unigreen card-header-icon">
                        <div class="card-icon">
                          <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">List Of Delivaries</h4>
                      </div>
                      <div class="card-body">
                        <div class="toolbar">
                          <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                          <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                              <tr>
                                <th>
                                  <h6 style="text-align: center;padding-right: 20px;">ID<br>Livraison</h6>
                                </th>
                                <th>
                                  <h6 style="text-align: center;">Adresse<br>Livraison</h6>
                                </th>
                                <th>
                                  <h6 style="text-align: center;padding-right: 20px;">État</h6>
                                </th>
                                <th>
                                  <h6 style="padding-right: 20px;">Montant</h6>
                                </th>
                                <th>
                                  <h6 style="text-align: center;">Statut<br>Paiement</h6>
                                </th>
                                <th>
                                  <h6 style="text-align: center;">Mode<br>Paiement</h6>
                                </th>
                                <th>
                                  <h6 style="padding-right: 20px;">Description</h6>
                                </th>
                                <th class="disabled-sorting text-center">
                                  <h4 style="text-align: center; font-weight: bold;">Actions</h4>
                                </th>
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
                                  <td><?= htmlspecialchars($livraison['Montant']) ?></td>
                                  <td><?= htmlspecialchars($livraison['Statut_paiement']) ?></td>
                                  <td><?= htmlspecialchars($livraison['Mode_paiement']) ?></td>
                                  <td><?= substr(htmlspecialchars($livraison['Description']), 0, 30) ?>...</td> <!-- Shortened for display -->
                                  <td class="text-right">
                                    <a href="SupprimerLivraison.php?id_livraison=<?= $livraison['id_livraison'] ?>"
                                      class="btn btn-danger"
                                      onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette livraison ?')">
                                      <i class="material-icons">delete</i> Delete
                                    </a>
                                    <button type="button" class="btn btn-warning open-modal"
                                      data-toggle="modal" data-target="#exampleModal"
                                      data-id="<?= $livraison['id_livraison'] ?>">
                                      <i class="material-icons">edit</i>Modifier
                                    </button>
                                  </td>
                                </tr>
                              <?php endforeach; ?>

                            </tbody>
                          </table>
                          <a href="ajouterlivraison.php" class="btn btn-unigreen open-modal" >
                            <i class="material-icons">add</i> Add a Delivery
                          </a>


                        </div>
                      </div>
                      <!-- end content-->
                    </div>
                    <!--  end card  -->
                  </div>
                  <!-- end col-md-12 -->
                </div>
                <!-- end row -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php require_once '../includes/footer.php'; ?>
    </div>
  </div>
  <script>
  document.addEventListener('DOMContentLoaded', function () {
    const modifyButtons = document.querySelectorAll('.open-modal');

    modifyButtons.forEach(button => {
      button.addEventListener('click', function () {
        const tr = this.closest('tr');

        const id = this.getAttribute('data-id');
        const adresse = tr.querySelector('td:nth-child(2)').textContent.trim();
        const etat = tr.querySelector('td:nth-child(3)').textContent.trim();
        const montant = tr.querySelector('td:nth-child(4)').textContent.trim();
        const statut = tr.querySelector('td:nth-child(5)').textContent.trim();
        const mode = tr.querySelector('td:nth-child(6)').textContent.trim();
        const description = tr.querySelector('td:nth-child(7)').textContent.trim().replace('...', '');

        document.querySelector('#exampleModal input[name="id_livraison"]').value = id;
        document.querySelector('#exampleModal textarea[name="adresse_livraison"]').value = adresse;
        document.querySelector('#exampleModal input[name="etat"]').value = etat;
        document.querySelector('#exampleModal input[name="montant"]').value = montant;
        document.querySelector('#exampleModal input[name="statut_paiement"]').value = statut;
        document.querySelector('#exampleModal select[name="mode_paiement"]').value = mode;
        document.querySelector('#exampleModal textarea[name="description"]').value = description;
      });
    });
  });
</script>

</body>

</html>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title fw-bold fs-4" id="exampleModalLabel">Modifier Livraison</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="UpdateLivraison_client.php">
          <input type="hidden" name="id_livraison">

          <div class="form-group mb-4">
            <label for="adresse_livraison" class="fw-semibold">Adresse Livraison:</label>
            <textarea id="adresse_livraison" name="adresse_livraison" class="form-control py-2 px-3" required></textarea>
          </div>

          <div class="form-group mb-4">
            <label for="etat" class="fw-semibold">État:</label>
            <input type="text" id="etat" name="etat" class="form-control py-2 px-3" disabled>
          </div>

          <div class="form-group mb-4">
            <label for="montant" class="fw-semibold">Montant:</label>
            <input type="text" id="montant" name="montant" class="form-control py-2 px-3" disabled>
          </div>

          <div class="form-group mb-4">
            <label for="statut_paiement" class="fw-semibold">Statut Paiement:</label>
            <input type="text" id="statut_paiement" name="statut_paiement" class="form-control py-2 px-3" disabled>
          </div>
          <label for="mode_paiement" class="fw-semibold">Mode Paiement:</label>

          <div class="form-group mb-4">
            <select name="mode_paiement" id="mode_paiement" class="form-control py-2 px-3" required>
              <option value="Cash">Cash</option>
              <option value="Credit Card">Credit Card</option>
              <option value="Debit Card">Debit Card</option>
              <option value="Bank Transfer">Bank Transfer</option>
              <option value="Apple Pay">Apple Pay</option>
              <option value="Google Pay">Google Pay</option>
              <option value="PayPal">PayPal</option>
              <option value="Skrill">Skrill</option>
              <option value="Cash on Delivery">Cash on Delivery</option>
              <option value="Bitcoin">Bitcoin</option>
              <option value="Ethereum">Ethereum</option>
              <option value="Cheque">Cheque</option>
            </select>
          </div>
          <label for="description" class="fw-semibold">Description:</label>

          <div class="form-group mb-4">
            <textarea id="description" name="description" class="form-control py-2 px-3" required></textarea>
          </div>

          <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary px-4 py-2">Modifier</button>
            <button type="button" class="btn btn-secondary px-4 py-2" data-dismiss="modal">Fermer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Principal -->
<div class="modal fade" id="addLivraisonModal" tabindex="-1" role="dialog" aria-labelledby="addLivraisonLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title fw-bold fs-4" id="addLivraisonLabel">Ajouter une Livraison</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="AjouterLivraison_client.php">
          <div class="form-group mb-4">
            <label for="adresse" class="fw-semibold">Adresse:</label>
            <input type="text" id="adresse" name="adresse" class="form-control py-2 px-3" required readonly>
          </div>

          <div class="form-group mb-4">
            <label for="latitude" class="fw-semibold">Latitude:</label>
            <input type="text" id="latitude" name="latitude" class="form-control py-2 px-3" required readonly>
          </div>

          <div class="form-group mb-4">
            <label for="longitude" class="fw-semibold">Longitude:</label>
            <input type="text" id="longitude" name="longitude" class="form-control py-2 px-3" required readonly>
          </div>

          <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#mapModal">Sélectionner sur la carte</button>

          <div class="form-group mb-4">
            <label for="description" class="fw-semibold">Description:</label>
            <input type="text" id="description" name="description" class="form-control py-2 px-3" required>
          </div>

          <label for="mode_paiement" class="fw-semibold">Mode Paiement:</label>
          <div class="form-group mb-4">
            <select name="mode_paiement" id="mode_paiement" class="form-control py-2 px-3" required>
              <option value="Cash">Cash</option>
              <option value="Credit Card">Credit Card</option>
              <option value="Debit Card">Debit Card</option>
              <option value="Bank Transfer">Bank Transfer</option>
              <option value="Apple Pay">Apple Pay</option>
              <option value="Google Pay">Google Pay</option>
              <option value="PayPal">PayPal</option>
              <option value="Skrill">Skrill</option>
              <option value="Cash on Delivery">Cash on Delivery</option>
              <option value="Bitcoin">Bitcoin</option>
              <option value="Ethereum">Ethereum</option>
              <option value="Cheque">Cheque</option>
            </select>
          </div>

          <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-success px-4 py-2">Ajouter</button>
            <button type="button" class="btn btn-secondary px-4 py-2" data-dismiss="modal">Fermer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal pour la carte -->
<div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="mapModalLabel">Sélectionner un emplacement</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Carte -->
        <div id="map" style="height: 400px; width: 100%;"></div>

        <!-- Champs pour afficher l'adresse et les coordonnées -->
        <div class="form-group mt-3">
          <label for="map-adresse" class="fw-semibold">Adresse:</label>
          <input type="text" id="map-adresse" class="form-control" readonly>
        </div>

        <div class="form-group mt-3">
          <label for="map-latitude" class="fw-semibold">Latitude:</label>
          <input type="text" id="map-latitude" class="form-control" readonly>
        </div>

        <div class="form-group mt-3">
          <label for="map-longitude" class="fw-semibold">Longitude:</label>
          <input type="text" id="map-longitude" class="form-control" readonly>
        </div>
      </div>
      <div class="modal-footer">
        <!-- Bouton pour confirmer la sélection -->
        <button type="button" class="btn btn-success" id="confirmLocation">Confirmer la sélection</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>


<!-- Leaflet.js -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
  let map;
  let marker;

  function initMap() {
    map = L.map('map').setView([33.8869, 9.5375], 7); // Tunisie par défaut

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(position => {
        const {
          latitude,
          longitude
        } = position.coords;
        map.setView([latitude, longitude], 13);
        marker = L.marker([latitude, longitude], {
          draggable: true
        }).addTo(map);
        updateAddress(latitude, longitude);

        marker.on('dragend', function(event) {
          const newPos = event.target.getLatLng();
          updateAddress(newPos.lat, newPos.lng);
        });
      }, () => {
        alert("Impossible d'obtenir votre position.");
      });
    } else {
      alert("La géolocalisation n'est pas supportée par votre navigateur.");
    }

    // Ajouter un marqueur au clic
    map.on("click", function(e) {
      const lat = e.latlng.lat;
      const lng = e.latlng.lng;

      if (marker) {
        map.removeLayer(marker);
      }

      marker = L.marker([lat, lng], {
        draggable: true
      }).addTo(map);
      updateAddress(lat, lng);

      marker.on('dragend', function(event) {
        const newPos = event.target.getLatLng();
        updateAddress(newPos.lat, newPos.lng);
      });
    });
  }

  function updateAddress(lat, lng) {
    document.getElementById('map-latitude').value = lat;
    document.getElementById('map-longitude').value = lng;
    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
      .then(response => response.json())
      .then(data => {
        document.getElementById('map-adresse').value = data.display_name || "Adresse inconnue";
      })
      .catch(() => {
        document.getElementById('map-adresse').value = "Adresse inconnue";
      });
  }

  document.getElementById("confirmLocation").addEventListener("click", function() {
    document.getElementById("adresse").value = document.getElementById("map-adresse").value;
    document.getElementById("latitude").value = document.getElementById("map-latitude").value;
    document.getElementById("longitude").value = document.getElementById("map-longitude").value;
    $("#mapModal").modal("hide");
  });

  document.addEventListener("DOMContentLoaded", initMap);
</script>



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