<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Face Recognition with Face-api.js</title>
</head>
<script defer src="https://cdn.jsdelivr.net/npm/face-api.js"></script>

<body>
  <h2>Face Recognition Test</h2>
  <video id="video" width="640" height="480" autoplay></video>
  <script>
    const video = document.getElementById("video");

    // Load the models from the correct path
    async function setup() {
      await faceapi.nets.ssdMobilenetv1.loadFromUri('./models');  // Corrected path
      await faceapi.nets.faceLandmark68Net.loadFromUri('./models');  // Corrected path
      await faceapi.nets.faceRecognitionNet.loadFromUri('./models');  // Corrected path
      startVideo();
    }

    // Start video capture
    function startVideo() {
      navigator.mediaDevices.getUserMedia({
        video: {}
      }).then((stream) => {
        video.srcObject = stream;
      }).catch((err) => console.error("Error accessing webcam", err));
    }

    // Run face detection every 100ms
    video.addEventListener('play', () => {
      setInterval(async () => {
        const detections = await faceapi.detectAllFaces(video)
          .withFaceLandmarks()
          .withFaceDescriptors();

        console.log(detections);
      }, 100);
    });

    setup();
  </script>
</body>
</html>
