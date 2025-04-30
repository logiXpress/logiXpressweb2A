<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Location to MySQL and Firebase</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">

    <!-- Leaflet CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- Leaflet Routing Machine -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/11.6.0/firebase-app.js";
        import { getDatabase, ref, get, push } from "https://www.gstatic.com/firebasejs/11.6.0/firebase-database.js";

        const firebaseConfig = {
            apiKey: "AIzaSyA-_6Ix9Mlw3Z13MtEO7qN27akCMiiwpNU",
            authDomain: "project-1e2f9.firebaseapp.com",
            databaseURL: "https://project-1e2f9-default-rtdb.firebaseio.com",
            projectId: "project-1e2f9",
            storageBucket: "project-1e2f9.appspot.com",
            messagingSenderId: "679122121625",
            appId: "1:679122121625:web:50e8f24c6cb57d2a449908",
            measurementId: "G-306K5S9YM0"
        };

        const app = initializeApp(firebaseConfig);
        const db = getDatabase(app);

        let currentLat = null;
        let currentLon = null;
        let livreurId = null;
        let trackingStarted = false;
        let map, marker;
        let routingControl = null;

        function initMap() {
            map = L.map('livreurMap').setView([51.505, -0.09], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            marker = L.marker([51.505, -0.09]).addTo(map);
        }

        function sendLocationToFirebase(lat, lon) {
            const timestamp = new Date().toISOString();
            const data = {
                latitude: lat,
                longitude: lon,
                timestamp: timestamp
            };

            const locationRef = ref(db, `RealTimeTracking/${livreurId}`);
            push(locationRef, data)
                .then(() => {
                    console.log('Location saved:', data);
                    document.getElementById('latitude').textContent = lat.toFixed(6);
                    document.getElementById('longitude').textContent = lon.toFixed(6);
                })
                .catch(error => console.error('Firebase Error:', error));
        }

        function startTracking() {
            if (navigator.geolocation) {
                navigator.geolocation.watchPosition(
                    position => {
                        currentLat = position.coords.latitude;
                        currentLon = position.coords.longitude;
                        marker.setLatLng([currentLat, currentLon]);
                        sendLocationToFirebase(currentLat, currentLon);
                    },
                    error => {
                        console.error('Geolocation error:', error);
                    }, {
                        enableHighAccuracy: true
                    }
                );

                setInterval(() => {
                    if (currentLat !== null && currentLon !== null && trackingStarted) {
                        sendLocationToFirebase(currentLat, currentLon);
                    }
                }, 1000);
            } else {
                alert('Geolocation is not supported by this browser.');
            }
        }

        async function displayLivraisonsForLivreur(livreurId) {
            const livraisonsRef = ref(db, 'livraisons');
            try {
                const snapshot = await get(livraisonsRef);
                if (snapshot.exists()) {
                    const livraisons = snapshot.val();
                    Object.entries(livraisons).forEach(([idLivraison, livraisonData]) => {
                        if (livraisonData.id_livreur == livreurId) {
                            const { latitude, longitude, adresse } = livraisonData;
                            const livraisonMarker = L.marker([latitude, longitude]).addTo(map);

                            livraisonMarker.bindPopup(`
                                <b>Livraison #${idLivraison}</b><br>
                                ${adresse}<br>
                                <button class="btn btn-sm btn-primary mt-2 show-route" data-lat="${latitude}" data-lon="${longitude}">
                                    Show Route
                                </button>
                                <button class="btn btn-sm btn-danger mt-2 hide-route">
                                    Hide Route
                                </button>
                            `);
                        }
                    });

                    map.on('popupopen', function(e) {
                        const popupNode = e.popup._contentNode;

                        popupNode.querySelectorAll('.show-route').forEach(button => {
                            button.addEventListener('click', function() {
                                const lat = this.getAttribute('data-lat');
                                const lon = this.getAttribute('data-lon');
                                showRoute(lat, lon);
                            });
                        });

                        popupNode.querySelectorAll('.hide-route').forEach(button => {
                            button.addEventListener('click', function() {
                                hideRoute();
                            });
                        });
                    });

                } else {
                    console.log('No livraisons found.');
                }
            } catch (error) {
                console.error('Error fetching livraisons:', error);
            }
        }

        function showRoute(lat, lon) {
            if (routingControl) {
                routingControl.setWaypoints([marker.getLatLng(), L.latLng(lat, lon)]);
            } else {
                routingControl = L.Routing.control({
                    waypoints: [
                        marker.getLatLng(),
                        L.latLng(lat, lon)
                    ],
                    routeWhileDragging: true
                }).addTo(map);
            }
        }

        function hideRoute() {
            if (routingControl) {
                map.removeControl(routingControl);
                routingControl = null;
            }
        }

        document.getElementById("startBtn").addEventListener("click", () => {
            const enteredId = document.getElementById("livreurId").value;
            const enteredPassword = document.getElementById("password").value;

            if (!enteredId || !enteredPassword) return alert("Please enter both ID and password.");

            const livreurRef = ref(db, `livreurs/${enteredId}`);

            get(livreurRef)
                .then(snapshot => {
                    if (snapshot.exists()) {
                        const livreurData = snapshot.val();
                        if (livreurData.password === enteredPassword) {
                            console.log("Tracking started for ID:", enteredId);
                            livreurId = enteredId;
                            trackingStarted = true;
                            document.getElementById("status").textContent = `Tracking started for ID: ${livreurId}`;

                            document.getElementById("trackingInfo").style.display = 'block';
                            document.getElementById("livreurMap").style.display = 'block';
                            startTracking();
                            displayLivraisonsForLivreur(livreurId);
                        } else {
                            alert("Incorrect password.");
                        }
                    } else {
                        alert("Invalid Livreur ID.");
                    }
                })
                .catch(error => {
                    console.error("Error fetching Livreur data:", error);
                });
        });

        window.onload = initMap;
    </script>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <!-- Login Form -->
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="text-center">Livreur Login</h3>
                    </div>
                    <div class="card-body">
                        <form id="loginForm">
                            <div class="mb-3">
                                <label for="livreurId" class="form-label">Livreur ID</label>
                                <input type="number" id="livreurId" class="form-control" placeholder="Enter Livreur ID" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" class="form-control" placeholder="Enter Password" required>
                            </div>
                            <button type="button" id="startBtn" class="btn btn-primary w-100">Start Tracking</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tracking Info -->
        <div class="row mt-5" id="trackingInfo" style="display: none;">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h4 class="text-center">Tracking Info</h4>
                    </div>
                    <div class="card-body">
                        <p id="status" class="text-center">Not tracking</p>
                        <div class="text-center">
                            <p>Latitude: <span id="latitude">Not available</span></p>
                            <p>Longitude: <span id="longitude">Not available</span></p>
                        </div>
                        <div id="livreurMap" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
