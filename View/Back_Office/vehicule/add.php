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
        .sidebar {
            margin-left: 20px;
            /* Ajustez cette valeur */
        }

        .main-panel {
            margin-left: 250px;
            /* Ajustez pour éloigner le contenu du sidenav */
        }

        .container-fluid {
            padding: 0 30px;
            /* Ajustez pour plus d'espace */
        }

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

        .card {
            width: 100%;
            max-width: none;
            padding: 30px;
            margin-top: 10px;
            border: 1px solid #d6d6d6;
            /* Gardez cette propriété */
            border-radius: 10px;
            /* Gardez cette propriété */
            background-color: rgb(255, 255, 255);
            box-sizing: border-box;
        }
        

.form-group-row input {
    background-color: white; /* Champs de saisie en blanc */
    color: black; /* Texte des champs en noir */
    border: 1px solid #ccc; /* Bordure des champs */
}

.form-group-row input:focus {
    border-color: #2ecc71; /* Bordure verte au focus */
    box-shadow: 0 0 0 0.2rem rgba(46, 204, 113, 0.25); /* Ombre verte au focus */
}
        

        .form-label {
            font-weight: 600;
            width: 200px;
            /* Gardez ceci si nécessaire */
            margin-bottom: 10px;
            /* Ajoutez un espace en bas */
        }

        .form-group-row {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
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
        .form-ajout {
    margin-left: 0; /* Éliminer l'espace sur le côté */
    margin-top: 30px; /* Augmentez cette valeur pour descendre verticalement */
    width: 100%; /* Largeur complète */
    max-width: 600px; /* Largeur maximale pour le formulaire */
    padding: 20px; /* Espacement interne */
    
    color: green; /* Texte en blanc pour le contraste */
    border-radius: 10px; /* Coins arrondis */
    
}
.card-title {
    color:rgb(255, 255, 255); 
    background-color: #2ecc71;
    padding: 10px 15px;
}
.card-header {
    background-color: #2ecc71; /* Fond vert pour l'en-tête */
    
    padding: 15px; /* Espacement interne */
    border-radius: 10px 10px 0 0; /* Coins arrondis en haut */
    text-align: center; /* Centre le texte */
}
.text-center {
    text-align: center; /* Centre le texte */
}

.mt-4 {
    margin-top: 20px; /* Ajuste l'espacement supérieur */
}

.text-center .btn {
    background-color: #2ecc71; /* Couleur de fond verte pour le bouton */
    border-color: #2ecc71; /* Bordure verte pour le bouton */
    color: white; /* Texte en blanc */
    padding: 10px 20px; /* Espacement interne du bouton */
    border-radius: 5px; /* Coins arrondis du bouton */
    transition: background-color 0.3s; /* Transition douce pour le changement de couleur */
}

.text-center .btn:hover {
    background-color: #27ae60; /* Couleur de fond au survol */
    border-color: #27ae60; /* Bordure au survol */
}

.card-title {
    margin: 0; /* Supprime les marges par défaut */
    font-size: 1.5rem; /* Taille de police appropriée */
    font-weight: bold; /* Texte en gras */
}
table {
    width: 100%;
    border-collapse: collapse;
    background-color: #f4f6f8; /* fond clair et propre */
    
    border-radius: 8px;
    
}
.card {
    background-color:rgba(216, 222, 225, 0.9); /* Blanc-gris très clair */
    border: 1px solid #e0e0e0;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    border-radius: 10px;
    padding: 30px;
    margin-top: 20px;
    transition: all 0.3s ease;
}
.card:hover {
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
}      
    </style>
</head>

<body>
    <div class="wrapper">
        <?php require_once '../includes/sidenav.php'; ?>

        <div class="main-panel">
            <?php require_once '../includes/navbar.php'; ?>
            <?php require_once '../includes/configurator.php'; ?>

            <div class="container-fluid">
                <div style="flex: 1; text-align: center; padding-top: 80px;">
                    <img src="../vehicule/image.png" alt="Voiture de livraison verte"
                    
                        style="max-width:   450px; border-radius: 10px; display: block; margin: 0 auto 0px;">
                    <div style="flex: 1; text-align: center; padding-top: 20px;">
                        <img src="../vehicule/tourneo-courier-global-nav.png" alt="Tourneo Courier"
                            style="max-width: 800px; border-radius: 10px; display: block; margin: 0 auto;">
                    </div>
                </div>

                <form method="POST" class="form-ajout">
                <div class="card">
    <div class="card-header">
    
        <h3 class="card-title mb-0">Add A Vehicle</h3>
        <style>
        
      

        .card-title {
            margin: 0; /* Supprime les marges par défaut */
            font-size: 1.5rem; /* Taille de police appropriée */
            font-weight: bold; /* Texte en gras */
        }
    </style>
</style>
    </div>
    <div class="card-body mt-4">
        <div class="form-group-row">
            <label class="form-label" for="registration">Registration*</label>
            <input type="text" id="registration" name="immatriculation" oninput="limitInput(this)" class="form-control">
            <small id="immatriculationError" class="text-danger"></small>
        </div>

        <div class="form-group-row" style="flex-direction: column; align-items: flex-start;">
            <div style="display: flex; width: 100%; align-items: center;">
                <label class="form-label" for="type" style="width: 200px;">Type *</label>
                <input type="text" id="type" name="type" class="form-control" onkeypress="return isLetter(event)" style="flex: 1;">
            </div>
            <small id="typeError" class="text-danger" style="margin-left: 200px; margin-top: 5px;"></small>
        </div>

        <div class="form-group-row">
            <label class="form-label" for="autonomie">Autonomy (km) *</label>
            <input type="number" id="autonomie" name="autonomie" class="form-control" min="1">
            <small id="autonomieError" class="text-danger"></small>
        </div>

        <div class="form-group-row" style="flex-direction: column; align-items: flex-start;">
            <label class="form-label" for="statut">Statut *</label>
            <select class="form-control" name="statut" id="statut">
                <option value="In Maintenance">In Maintenance</option>
                <option value="In Service">In Service</option>
                <option value="Available">Available</option>
            </select>
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
            const registrationInput = document.getElementById('registration').value.trim();
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
    </script>

    <?php require_once '../includes/footer.php'; ?>
    <script>
    let hastartedTyping = false;

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

    function validateForm() {
        const registrationInput = document.getElementById('immatriculation').value.trim();
        const typeInput = document.getElementById('type').value.trim();
        const regexRegistration = /^[0-9]{3} TUNIS [0-9]{4}$/; // Ajustez si nécessaire
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

    document.querySelector('.form-modification').addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
        }
    });
</script>
</body>

</html>