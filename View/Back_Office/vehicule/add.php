<?php
require_once '../../../config/config.php';
require_once '../../../Model/Vehicule.php';
require_once '../../../Controller/VehiculeC.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $immatriculation = $_POST['immatriculation'] ?? '';
    $type = $_POST['type'] ?? '';
    $autonomie = isset($_POST['autonomie']) ? intval($_POST['autonomie']) : 0;
    $statut = $_POST['statut'] ?? '';

    if (!empty($immatriculation) && !empty($type) && !empty($statut) && $autonomie > 0) {
        $vehicule = new Vehicule($immatriculation, $type, $autonomie, $statut);
        $vehiculeC = new VehiculeC();
        $vehiculeC->ajouterVehicule($vehicule);
        header('Location: Listevehicules.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <?php require_once '../includes/header.php'; ?>
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

        .card {
            border: 1px solid #d6d6d6;
            border-radius: 10px;
            padding: 30px;
            width: 100%;
            background-color: rgb(249, 249, 249);
            box-sizing: border-box;
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
            margin-right: 5px;
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
</head>

<body>
    <div class="wrapper">
        <?php require_once '../includes/sidenav.php'; ?>

        <div class="main-panel">
            <?php require_once '../includes/navbar.php'; ?>
            <?php require_once '../includes/configurator.php'; ?>

            <div class="content">
                <div class="container-fluid">
                    <div style="display: flex; width: 100%; gap: 30px;">
                        <div style="flex: 1; text-align: center; transform: translateX(100px);">
                            <img src="../vehicule/voituredelivraison.jpg" alt="Voiture de livraison verte"
                                style="max-width: 800px; border-radius: 10px; display: block; margin: 0 auto 15px;">
                            <img src="../vehicule/tourneo-courier-global-nav.png" alt="Tourneo Courier"
                                style="max-width: 800px; border-radius: 10px; display: block; margin: 0 auto;">
                        </div>

                        <div style="flex: 1;">
                            <form method="POST" onsubmit="return validateForm()">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title mb-0">Add A Vehicle</h3>
                                    </div>
                                    <div class="card-body mt-4">

                                        <div class="form-group-row">
                                            <label class="form-label" for="immatriculation">Registration*</label>
                                            <input type="text" id="registration" name="immatriculation" class="form-control" required>
                                            <small id="immatriculationError" class="text-danger"></small>
                                        </div>

                                        <div class="form-group-row">
                                            <label class="form-label" for="type">Type *</label>
                                            <input type="text" id="type" name="type" class="form-control" required onkeypress="return isLetter(event)">
                                            <small id="typeError" class="text-danger"></small>
                                        </div>

                                        <div class="form-group-row">
                                            <label class="form-label" for="autonomie">Autonomy (km) *</label>
                                            <input type="number" id="autonomie" name="autonomie" class="form-control" min="1" required>
                                            <small id="autonomieError" class="text-danger"></small>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Statut *</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="statut" id="statut_maintenance" value="In Maintenance" required>
                                                <label class="form-check-label" for="statut_maintenance">In Maintenance</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="statut" id="statut_service" value="In Service">
                                                <label class="form-check-label" for="statut_service">In Service</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="statut" id="statut_disponible" value="Available">
                                                <label class="form-check-label" for="statut_disponible">Available</label>
                                            </div>
                                        </div>

                                        <div class="text-center mt-4">
                                            <div style="display: flex; justify-content: center; margin: 20px 0;">
                                                <button type="submit" class="btn btn-primary btn-lg">
                                                    <i class="fas fa-plus"></i> Add A Vehicle
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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

        }
    </script>
    
    
    <?php require_once '../includes/footer.php'; ?>
</body>

</html>