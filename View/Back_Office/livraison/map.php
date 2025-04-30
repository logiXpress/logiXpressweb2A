<?php
// Include the Firebase/MySQL update functionality
include_once '../api/firelivreur.php'; // Adjust the path as needed
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once '../includes/header.php'; ?>

<head>

  <title>Real-Time Delivery Tracking</title>

  <!-- Leaflet.js CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
  <style>
    #map {
      height: 600px;
      width: 100%;
    }

    .livreur-popup {
      font-size: 14px;
    }

    #routeButton {
      margin: 10px;
      padding: 8px 16px;
      background-color: blue;
      color: white;
      border: none;
      cursor: pointer;
    }
  </style>

</head>
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

        <div id="map"></div>

        <!-- Leaflet.js Library -->
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
        <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

        <script>
          // Initialize the map centered on Tunisia with max bounds
          var map = L.map('map', {
            center: [36.8065, 10.1815], // Tunis as the center
            zoom: 7, // Initial zoom level
            minZoom: 6, // Prevent excessive zooming out
            maxZoom: 18, // Allow zooming in
            maxBounds: [
              [30, 7], // Southwest corner (near Algeria/Libya)
              [38, 12] // Northeast corner (Mediterranean)
            ],
            maxBoundsViscosity: 1.0 // Makes sure the user can't drag outside
          });

          // Load OpenStreetMap tiles
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
          }).addTo(map);

          // Add a search control to the map
          L.Control.geocoder({
            defaultMarkGeocode: true
          }).on('markgeocode', function(e) {
            var latlng = e.geocode.center;
            map.setView(latlng, 14); // Zoom in on the searched location
          }).addTo(map);

          let livreurMarkers = {}; // Store markers for each livreur
          let livraisonMarkers = {}; // Store livraison markers
          let routeControls = {}; // Store routing controls

          // Function to create custom markers for livreurs
          function createLivreurMarker(lat, lon, statut) {
            let livreurIcon = L.icon({
              iconUrl: statut === 'Disponible' ? '../../../Public/assets/img/tracking.png' : '../../../Public/assets/img/tracking.png',
              iconSize: [40, 40],
              iconAnchor: [20, 40],
              popupAnchor: [0, -40]
            });

            return L.marker([lat, lon], {
              icon: livreurIcon
            });
          }

          // Function to create icon markers for livraison locations
          function createLivraisonMarker(lat, lon) {
            let livraisonIcon = L.icon({
              iconUrl: '../../../Public/assets/img/location.png',
              iconSize: [35, 35],
              iconAnchor: [17, 35],
              popupAnchor: [0, -35]
            });

            return L.marker([lat, lon], {
              icon: livraisonIcon
            });
          }

          // Function to fetch Firebase data and update MySQL periodically
          async function updateFirebaseLocation() {
            try {
              // Fetch the data from Firebase and update MySQL
              await fetch('http://localhost/Project/View/Back_Office/api/updateLocation.php');
            } catch (error) {
              console.error('Error updating location from Firebase:', error);
            }
          }

          // Function to update the map with live data
          async function updateMap() {
            try {
              // Fetch updated location data from MySQL
              let livreurResponse = await fetch('http://localhost/Project/View/Back_Office/api/getLivreursLocation.php');
              let livreurData = await livreurResponse.json();

              let livraisonResponse = await fetch('http://localhost/Project/View/Back_Office/api/getLivraisonLocation.php');
              let livraisonData = await livraisonResponse.json();

              // Remove all old markers from the map
              Object.values(livreurMarkers).forEach(marker => map.removeLayer(marker));
              Object.values(livraisonMarkers).forEach(marker => map.removeLayer(marker));

              livreurMarkers = {};
              livraisonMarkers = {};

              // Add new markers based on updated data
              livreurData.forEach(livreurItem => {
                if (livreurItem.latitude && livreurItem.longitude) {
                  let livreurLat = parseFloat(livreurItem.latitude);
                  let livreurLon = parseFloat(livreurItem.longitude);
                  let statut = livreurItem.Statut?.trim() || "Unknown";

                  if (!isNaN(livreurLat) && !isNaN(livreurLon)) {
                    // Create the livreur marker
                    let marker = createLivreurMarker(livreurLat, livreurLon, statut).addTo(map);
                    livreurMarkers[livreurItem.id_livreur] = marker;

                    // Handle livraison marker logic
                    let livraisonItem = livraisonData.find(l => l.id_livreur === livreurItem.id_livreur);
                    let livraisonLat, livraisonLon, adresseLivraison;

                    if (livraisonItem && livraisonItem.latitude && livraisonItem.longitude) {
                      livraisonLat = parseFloat(livraisonItem.latitude);
                      livraisonLon = parseFloat(livraisonItem.longitude);
                      adresseLivraison = livraisonItem.Adresse_livraison || "Adresse inconnue";

                      let livraisonMarker = createLivraisonMarker(livraisonLat, livraisonLon).addTo(map);
                      livraisonMarker.bindPopup(`
              <b>Livraison ID:</b> ${livraisonItem.id_livraison}<br>
              <b>Adresse:</b> ${adresseLivraison}
            `);
                      livraisonMarkers[livraisonItem.id_livraison] = livraisonMarker;
                    }

                    // Add route if needed
                    if (!routeControls[livreurItem.id_livreur] && livraisonLat !== undefined && livraisonLon !== undefined) {
                      let route = L.Routing.control({
                        waypoints: [
                          L.latLng(livreurLat, livreurLon),
                          L.latLng(livraisonLat, livraisonLon)
                        ],
                        routeWhileDragging: true,
                        createMarker: function() {
                          return null;
                        },
                        serviceUrl: 'https://router.project-osrm.org/route/v1'
                      });

                      routeControls[livreurItem.id_livreur] = {
                        control: route,
                        shownManually: false
                      };
                    }

                    // Add popup with a button to toggle route visibility
                    marker.bindPopup(`
            <b>Livreur ID:</b> ${livreurItem.id_livreur}<br>
            <b>Status:</b> ${statut}<br>
            <button id="routeButton_${livreurItem.id_livreur}">Show Route</button>
          `);

                    // Attach event for showing/hiding route
                    marker.on('popupopen', function() {
                      let routeButton = document.getElementById(`routeButton_${livreurItem.id_livreur}`);
                      let routeData = routeControls[livreurItem.id_livreur];

                      routeButton.addEventListener('click', function() {
                        if (routeData.shownManually) {
                          routeData.control.remove();
                          routeData.shownManually = false;
                          routeButton.textContent = "Show Route";
                        } else {
                          routeData.control.addTo(map);
                          routeData.shownManually = true;
                          routeButton.textContent = "Hide Route";
                        }
                      });
                    });
                  }
                }
              });
            } catch (error) {
              console.error('Error fetching data:', error);
            }
          }

          // Call updateFirebaseLocation periodically to update Firebase to MySQL
          setInterval(updateFirebaseLocation, 3000); // Update every 5 seconds

          // Update the map every 5 seconds with the latest MySQL data
          setInterval(updateMap, 3000);

          // Initial load of map data
          updateMap();
        </script>



        <?php require_once '../includes/footer.php'; ?>
    </div>
  </div>
</body>

</html>