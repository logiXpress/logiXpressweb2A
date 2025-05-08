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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
body {
    background-color: #f4f6f8;
    overflow-x: hidden;
}

.card {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 30px;
    margin: 20px auto;
    width: 80%;
    max-width: 600px;
}

.card-header {
    background-color: #2ecc71;
    color: white;
    padding: 15px;
    border-radius: 10px 10px 0 0;
    text-align: center;
}

.form-group {
    margin-bottom: 40px;
}

.form-group-row {
    margin-bottom: 20px;
}

.form-label {
    font-weight: bold;
    margin-bottom: 5px;
}

.form-control {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    width: 100%;
}

.btn-primary {
    background-color: #2ecc71;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.btn-primary:hover {
    background-color: #27ae60;
}

.text-center {
    text-align: center;
}

#typeError {
    color: red;
}

.form-ajout {
    margin-left: 500px;
    margin-right: 100px;
    margin-top: 75px;
    width: 80%;
    max-width: 1700px;
    padding: 20px;
    color: green;
    border-radius: 10px;
}

.add-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
    background-color: #2ecc71;
    border-radius: 5px;
    color: white;
    font-size: 18px;
    position: absolute;
    left: 15px;
    top: -20px;
}

.card-title {
    display: flex;
    align-items: center;
    font-weight: 500;
    color: #3c4858;
}

img {
    max-width: 600px;
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
            <div class="container-fluid d-flex align-items-center justify-content-center" style="margin-top: 50px; gap: 30px;">
                <div style="height: 300%;">
                    <img src="../vehicule/image.png" alt="Voiture de livraison verte">
                    
                    
                </div>
                <form method="POST" class="form-ajout" style="margin: 0;">
                    <div class="card" style="width: 100%; max-width: 900px;">
                        <div class="card-header">
                            <div class="add-icon">
                                <i class="fas fa-plus"></i>
                            </div>
                            <h3 class="card-title mb-0">Add A Vehicle</h3>
                        </div>
                        <div class="card-body mt-4">
                            <div class="form-group">
                                <label class="form-label" for="immatriculation">Registration *</label>
                                <input type="text" id="immatriculation" name="immatriculation" class="form-control" oninput="limitInput(this)">
                                <small id="immatriculationError" class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="type">Type *</label>
                                <input type="text" id="type" name="type" class="form-control" onkeypress="return isLetter(event)">
                                <div id="typeError" style="color: red;"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="autonomie">Autonomy (km) *</label>
                                <input type="number" id="autonomie" name="autonomie" class="form-control" min="1">
                                <small id="autonomieError" class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="statut">Statut *</label>
                                <select class="form-control" name="statut" id="statut">
                                    <option value="In Maintenance">In Maintenance</option>
                                    <option value="In Service">In Service</option>
                                    <option value="Available">Available</option>
                                </select>
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-unigreen btn-lg">
                                    <i class="fas fa-plus"></i> Add A Vehicle
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let hasStartedTyping = false;

        function isLetter(event) {
            const char = String.fromCharCode(event.which);
            const isValid = /^[a-zA-Z\s]$/.test(char);
            const typeError = document.getElementById('typeError');

            if (!hasStartedTyping) {
                hasStartedTyping = true;
                return isValid;
            }

            if (!isValid) {
                typeError.textContent = 'Veuillez entrer des caractères uniquement.';
                event.preventDefault();
                return false;
            } else {
                typeError.textContent = '';
            }

            return true;
        }

        function limitInput(input) {
            let value = input.value;
            value = value.replace(/[^0-9TUNIS ]/gi, '');
            if (!value.includes('TUNIS')) {
                value = value.replace(/[^0-9]/g, '');
                if (value.length > 3) {
                    value = value.substring(0, 3);
                }
                if (value.length === 3) {
                    value += ' TUNIS ';
                }
            } else {
                let parts = value.split('TUNIS');
                let before = parts[0].replace(/[^0-9]/g, '').substring(0, 3);
                let after = (parts[1] || '').replace(/[^0-9]/g, '').substring(0, 4);
                value = before + ' TUNIS ' + after;
            }
            input.value = value;
        }

        function validateForm() {
            const registrationInput = document.getElementById('immatriculation').value.trim();
            const typeInput = document.getElementById('type').value.trim();
            const regexRegistration = /^[0-9]{3} TUNIS [0-9]{4}$/;
            const regexType = /^[a-zA-Z\s]*$/;

            if (!regexRegistration.test(registrationInput)) {
                document.getElementById('immatriculationError').textContent = 'Format invalide. Ex: 123 TUNIS 4567';
                return false;
            }

            if (!regexType.test(typeInput)) {
                document.getElementById('typeError').textContent = 'Veuillez entrer des caractères uniquement.';
                return false;
            }

            document.getElementById('immatriculationError').textContent = '';
            document.getElementById('typeError').textContent = '';
            return true;
        }

        document.querySelector('.form-ajout').addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
            }
        });
        function validateType() {
        const typeInput = document.getElementById('type').value.trim();
        const regexType = /^[a-zA-Z\s]*$/;

        if (!regexType.test(typeInput)) {
            document.getElementById('typeError').textContent = 'Veuillez entrer des caractères uniquement.';
            return false;
        }

        document.getElementById('typeError').textContent = '';
        return true;
    }

    document.querySelector('form').addEventListener('submit', function(e) {
        if (!validateForm() || !validateType()) {
            e.preventDefault(); // Prevent form submission
        }
    });
    </script>
</body>

</html>