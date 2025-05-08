<?php
require_once '../../../config/config.php';
require_once '../../../Model/Entretien.php';
require_once '../../../Controller/EntretienC.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_vehicule = $_POST['id_vehicule'] ?? '';
    $date = $_POST['date'] ?? '';
    $type_intervention = $_POST['type_intervention'] ?? '';
    $statut = isset($_POST['statut']) ? 'soumis' : 'non soumis'; // Détermine le statut

    if (!empty($id_vehicule) && !empty($date) && !empty($type_intervention)) {
        $entretien = new Entretien($id_vehicule, $date, $type_intervention, $statut);
        $entretienC = new EntretienC();
        $entretienC->ajouterEntretien($entretien);
        // Ajoutez cette ligne pour enregistrer l'action d'ajout
        $entretienC->ajouterHistorique('add', $id_vehicule, $type_intervention);
        header('Location: listeentretiens.php');
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
<script>
    function isLetter(event) {
        const char = String.fromCharCode(event.which);
        const isValid = /^[a-zA-Z\s]$/.test(char);
        const typeError = document.getElementById('typeError');

        if (!isValid) {
            typeError.textContent = 'Please enter only characters.';
            event.preventDefault(); 
            return false;
        } else {
            typeError.textContent = ''; 
        }

        return true;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const historiqueButton = document.querySelector('[data-target="#historiqueModal"]');

        historiqueButton.addEventListener('click', function() {
            const historiqueContent = document.getElementById('historiqueContent');
            historiqueContent.innerHTML = '';

            <?php if (isset($_SESSION['historique'])): ?>
                const historique = <?php echo json_encode($_SESSION['historique']); ?>;
                historique.forEach((entry, index) => {
                    historiqueContent.innerHTML += `<h6>Page ${index + 1}</h6>
                                                     <p>ID Véhicule: ${entry.id_vehicule}</p>
                                                     <p>Date: ${entry.Date}</p>
                                                     <p>Type d'Intervention: ${entry.Type_intervention}</p>
                                                     <hr>`;
                });
            <?php endif; ?>
        });
    });
</script>
</head>

<body>
    <div class="wrapper">
        <?php require_once '../includes/sidenav.php'; ?>
        <div class="main-panel">
            <?php require_once '../includes/navbar.php'; ?>
            <?php require_once '../includes/configurator.php'; ?>
            <div class="container-fluid d-flex align-items-center justify-content-center" style="margin-top: 50px; gap: 30px;">
                <div style="height: 300%;">
                    <img src="../Entretien/imagee.png" alt="Voiture de livraison verte">
                </div>
                <form method="POST" class="form-ajout" style="margin: 0;">
                    <div class="card" style="width: 100%; max-width: 900px;">
                        <div class="card-header">
                            <div class="add-icon">
                                <i class="fas fa-plus"></i> 
                            </div>
                            <h3 class="card-title mb-0">Add A Maintenance</h3>
                        </div>
                        <div class="card-body mt-4">
                            <div class="form-group">
                                <label class="form-label" for="id_vehicule">Vehicle ID *</label>
                                <input type="number" id="id_vehicule" name="id_vehicule" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="date">Date *</label>
                                <input type="date" id="date" name="date" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="type_intervention">Type of Intervention *</label>
                                <input type="text" id="type_intervention" name="type_intervention" class="form-control" onkeypress="isLetter(event)" >
                                <div id="typeError" style="color: red;"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Statut *</label>
                                <div>
                                    <input type="checkbox" id="statut" name="statut">
                                    <label for="statut">Submitted</label>
                                </div>
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-unigreen btn-lg">
                                    <i class="fas fa-plus"></i> Add
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>