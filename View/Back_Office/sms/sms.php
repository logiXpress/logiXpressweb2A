
<!DOCTYPE html>
<html lang="en">
<?php require_once '../includes/header.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMS Monitoring</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .log-container {
            height: 400px;
            overflow-y: auto;
            font-family: 'Courier New', Courier, monospace;
            background-color: #fff;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        .header-title {
            margin-top: 40px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body class="">

  <div class="wrapper">
    <?php require_once '../includes/configurator.php'; ?>
    <?php require_once '../includes/sidenav.php'; ?>
    <div class="main-panel">
      <?php require_once '../includes/navbar.php'; ?>
      <div class="container">
        <br><br>
        <h2 class="text-center header-title">📡 Real-Time SMS Monitoring</h2>

        <div class="card shadow-sm">
            <div class="card-body">
                <div id="status" class="log-container"></div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional for components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function fetchStatus() {
            fetch('get_status.php')
                .then(response => response.json())
                .then(data => {
                    let statusDiv = document.getElementById('status');
                    statusDiv.innerHTML = data.map(line => `<div>${line}</div>`).join('');
                    statusDiv.scrollTop = statusDiv.scrollHeight;
                })
                .catch(error => {
                    console.error('Error fetching status:', error);
                    document.getElementById('status').innerHTML += `<div class="text-danger">⚠ Error: ${error}</div>`;
                });
        }
        
        fetchStatus();
        setInterval(fetchStatus, 5000);
    </script>

        <?php require_once '../includes/footer.php'; ?>
    </div>
  </div>
</body>

</html>