<?php
require_once '../../../config/config.php';
require_once '../../../Model/Entretien.php';
require_once '../../../Controller/EntretienC.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_vehicule = $_POST['id_vehicule'] ?? '';
    $date = $_POST['date'] ?? '';
    $type_intervention = $_POST['type_intervention'] ?? '';

    if (!empty($id_vehicule) && !empty($date) && !empty($type_intervention)) {
        $entretien = new Entretien($id_vehicule, $date, $type_intervention);
        $entretienC = new EntretienC();
        $entretienC->ajouterEntretien($entretien);
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
    background-color: #f4f6f8; /* Fond clair */
    overflow-x: hidden; /* Masque le débordement horizontal */
}

.card {
    background-color: white; /* Fond blanc pour la carte */
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 30px;
    margin: 20px auto;
    width: 80%; /* Largeur de la carte */
    max-width: 600px; /* Largeur maximale */
}

.card-header {
    background-color: #2ecc71; /* Couleur de fond verte */
    color: white; /* Couleur du texte en blanc */
    padding: 15px;
    border-radius: 10px 10px 0 0; /* Coins arrondis en haut */
    text-align: center;
}

.form-group {
    margin-bottom: 40px; /* Espacement entre les champs */
}
.form-group-row {
    margin-bottom: 20px; /* Espacement entre les groupes de formulaire */
}
.form-label {
    font-weight: bold;
    margin-bottom: 5px; /* Espacement sous le label */
   /* Assure que le label prend toute la largeur */ /* Texte en gras */
}

.form-control {
    border: 1px solid #ccc; /* Bordure des champs */
    border-radius: 5px; /* Coins arrondis */
    padding: 10px; /* Espacement interne */
    width: 100%; /* Largeur complète */
    
}

.btn-primary {
    background-color: #2ecc71; /* Couleur du bouton */
    color: white; /* Texte en blanc */
    border: none; /* Pas de bordure */
    padding: 10px 20px; /* Espacement interne */
    border-radius: 5px; /* Coins arrondis */
    transition: background-color 0.3s; /* Transition douce */
}

.btn-primary:hover {
    background-color: #27ae60; /* Couleur au survol */
}

.text-center {
    text-align: center; /* Centre le texte */
}

#typeError {
    color: red; /* Couleur du message d'erreur */
}

.form-ajout {
    margin-left: 500px;
    margin-right: 100px; /* Éliminer l'espace sur le côté */
    margin-top: 75px; /* Augmentez cette valeur pour descendre verticalement */
    width: 80%; /* Largeur complète */
    max-width: 1700px; /* Largeur maximale pour le formulaire */
    padding: 20px; /* Espacement interne */
    color: green; /* Texte en blanc pour le contraste */
    border-radius: 10px; /* Coins arrondis */
}

.add-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 60px; /* Largeur de l'icône */
    height: 60px; /* Hauteur de l'icône */
    background-color: #2ecc71; /* Fond vert */
    border-radius: 5px; /* Coins arrondis */
    color: white; /* Couleur de l'icône */
    font-size: 18px; /* Taille de l'icône */
    position: absolute; /* Position absolue pour l'icône */
    left: 15px; /* Ajustement horizontal */
    top: -20px; /* Ajustement vertical pour monter sur le formulaire */
}

.card-title {
    display: flex; /* Utilisation de flexbox pour aligner l'icône et le texte */
    align-items: center; /* Centre l'icône et le texte verticalement */
    font-weight: 500; /* Poids du texte */
    color: #3c4858; /* Couleur du texte */
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
                typeError.textContent = 'Veuillez entrer des caractères uniquement.';
                event.preventDefault(); // Empêche l'entrée de caractères invalides
                return false;
            } else {
                typeError.textContent = ''; // Efface le message d'erreur
            }

            return true;
        }
        
    document.addEventListener('DOMContentLoaded', function() {
        const historiqueButton = document.querySelector('[data-target="#historiqueModal"]');

        historiqueButton.addEventListener('click', function() {
            const historiqueContent = document.getElementById('historiqueContent');
            historiqueContent.innerHTML = ''; // Vider le contenu

            <?php if (isset($_SESSION['historique'])): ?>
                const historique = <?php echo json_encode($_SESSION['historique']); ?>;
                historique.forEach((entry, index) => {
                    historiqueContent.innerHTML += `<h6>Page ${index + 1}</h6>
                                                     <p>ID Véhicule: ${entry.id_vehicule}</p>
                                                     <p>Date: ${entry.date}</p>
                                                     <p>Type d'Intervention: ${entry.type_intervention}</p>
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
    <div class="card" style="width: 100%; max-width: 900px;"> <!-- Nouveau style -->

            <div class="card-header">
                <div class="add-icon">
                    <i class="fas fa-plus"></i> <!-- Icône d'ajout -->
                </div>
                <h3 class="card-title mb-0">Add A Maintenance</h3>
            </div>
            <div class="card-body mt-4">
                <div class="form-group">
                    <label class="form-label" for="id_vehicule">Vehicle ID *</label>
                    <input type="number" id="id_vehicule" name="id_vehicule" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="date">Date *</label>
                    <input type="date" id="date" name="date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="type_intervention">Type of Intervention *</label>
                    <input type="text" id="type_intervention" name="type_intervention" class="form-control" required onkeypress="isLetter(event)">
                    <div id="typeError" style="color: red;"></div>
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
