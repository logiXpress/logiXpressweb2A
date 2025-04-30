<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send Location to MySQL and Firebase</title>
    <script type="module">
        // Firebase configuration
        import { initializeApp } from "https://www.gstatic.com/firebasejs/11.6.0/firebase-app.js";
        import { getDatabase, ref, push } from "https://www.gstatic.com/firebasejs/11.6.0/firebase-database.js";

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

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const db = getDatabase(app);

        // Function to send location data to Firebase
        function sendLocationToFirebase(lat, lon) {
            const timestamp = new Date().toISOString();
            const data = { latitude: lat, longitude: lon, timestamp: timestamp };

            const locationRef = ref(db, 'locations/');
            push(locationRef, data)
                .then(() => {
                    console.log('Location saved to Firebase:', data);
                    document.getElementById('latitude').textContent = lat;
                    document.getElementById('longitude').textContent = lon;
                })
                .catch(error => console.error('Firebase Error:', error));
        }

        // Function to send location data to the PHP server (MySQL)
        function sendLocationToServer(lat, lon) {
            const livreurId = 245; // For testing purposes, using 245 as the livreur id

            const formData = new FormData();
            formData.append("livreurId", livreurId);
            formData.append("latitude", lat);
            formData.append("longitude", lon);

            fetch("updateLocation.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log("MySQL Response:", data); // Log the response from the server
            })
            .catch(error => {
                console.error("Error sending location to MySQL:", error);
            });
        }

        let currentLat = null;
        let currentLon = null;

        // Geolocation functionality to get current position and send it to MySQL and Firebase
        if (navigator.geolocation) {
            navigator.geolocation.watchPosition(
                position => {
                    currentLat = position.coords.latitude;
                    currentLon = position.coords.longitude;
                },
                error => {
                    console.error('Geolocation error:', error);
                },
                { enableHighAccuracy: true }
            );

            setInterval(() => {
                if (currentLat !== null && currentLon !== null) {
                    sendLocationToServer(currentLat, currentLon); // Send location to MySQL
                    sendLocationToFirebase(currentLat, currentLon); // Send location to Firebase
                } else {
                    console.log("Waiting for initial geolocation data...");
                }
            }, 5000); // every 5 seconds
        } else {
            console.error('Geolocation is not supported by this browser.');
        }
    </script>
</head>
<body>
    <h1>Sending your location to MySQL and Firebase every 5 seconds...</h1>
    <div id="coordinatesDisplay">
        <p>Latitude: <span id="latitude">Not available</span></p>
        <p>Longitude: <span id="longitude">Not available</span></p>
    </div>
</body>
</html>
