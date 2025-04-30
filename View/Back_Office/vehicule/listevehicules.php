<?php
require_once 'C:/Users/Desktop/PHP/htdocs/Project/Model/Vehicule.php';
require_once 'C:/Users/Desktop/PHP/htdocs/Project/Controller/VehiculeC.php';

$VehiculeC = new VehiculeC();

// Gestion des actions
if (isset($_POST['add'])) {
    $VehiculeC->ajouterVehicule(new Vehicule($_POST['immatriculation'], $_POST['type'], $_POST['autonomie'], $_POST['statut']));
    header('Location: listevehicules.php');
    exit();
}

if (isset($_GET['delete'])) {
    $VehiculeC->supprimerVehicule($_GET['delete']);
    header('Location: listevehicules.php');
    exit();
}

$vehicule = null;
if (isset($_GET['id'])) {
    $vehicule = $VehiculeC->getVehiculeById($_GET['id']);
}

if (isset($_POST['update']) && $vehicule) {
    $VehiculeC->modifierVehicule($_POST['id_vehicule'], new Vehicule($_POST['immatriculation'], $_POST['type'], $_POST['autonomie'], $_POST['statut']));
    header('Location: listevehicules.php');
    exit();
}

// Rechercher les véhicules selon le terme de recherche
$searchTerm = '';
if (isset($_POST['search_btn'])) {
    $searchTerm = $_POST['search'];
}

// Appel de la méthode de recherche
$vehicules = $VehiculeC->rechercherVehicule($searchTerm);
?>

<!DOCTYPE html>
<html lang="fr">

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

       
        
        .btn-primary i {
            margin-right: 5px;
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
    margin-top: 70px; /* Augmentez cette valeur pour descendre verticalement */
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
.btn-primary {
    background-color: #2ecc71; /* Couleur de fond verte */
    border-color: #2ecc71; /* Bordure verte */
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-primary:hover {
    background-color: #27ae60; /* Couleur de fond au survol */
    border-color: #27ae60; /* Bordure au survol */
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

<body>
    <div class="wrapper">
        <?php require_once '../includes/configurator.php'; ?>
        <?php require_once '../includes/sidenav.php'; ?>

        <div class="main-panel">
            <?php require_once '../includes/navbar.php'; ?>
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <!-- Formulaire de modification -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Modify a Vehicle</h3>
                            </div>
                            <div class="card-body">
                                <form method="post">
                                    <input type="hidden" name="id_vehicule" value="<?= htmlspecialchars($vehicule['id_vehicule'] ?? '') ?>">
                                    <div class="form-group-row">
                                        <label class="form-label" for="immatriculation">Registration *</label>
                                        <input type="text" id="immatriculation" name="immatriculation" class="form-control" required value="<?= htmlspecialchars($vehicule['Immatriculation'] ?? '') ?>">
                                    </div>
                                    <div class="form-group-row">
                                        <label class="form-label" for="type">Type *</label>
                                        <input type="text" id="type" name="type" class="form-control" required value="<?= htmlspecialchars($vehicule['Type'] ?? '') ?>">
                                    </div>
                                    <div class="form-group-row">
                                        <label class="form-label" for="autonomie">Autonomy (km) *</label>
                                        <input type="number" id="autonomie" name="autonomie" class="form-control" required value="<?= htmlspecialchars($vehicule['Autonomie'] ?? '') ?>">
                                    </div>
                                    <div class="form-group-row" style="flex-direction: column; align-items: flex-start;">
                              <label class="form-label" for="statut">Statut *</label>
                                <select class="form-control" name="statut" id="statut" >
                                    <option value="In Maintenance">In Maintenance</option>
                                    <option value="In Service">In Service</option>
                                    <option value="Available">Available</option>
                                </select>
                            </div>
                                    <div class="text-center mt-4">
                                        <button type="submit" name="update" class="btn btn-primary btn-lg">
                                            <i class="fas fa-pencil-alt"></i> Modify
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                   
                    

                    <!-- Liste des véhicules -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">List Of Vehicles</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-hover table-bordered text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Registration</th>
                                            <th>Type</th>
                                            <th>Autonomy</th>
                                            <th>Statut</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($vehicules as $veh): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($veh['id_vehicule']) ?></td>
                                                <td><?= htmlspecialchars($veh['Immatriculation']) ?></td>
                                                <td><?= htmlspecialchars($veh['Type']) ?></td>
                                                <td><?= htmlspecialchars($veh['Autonomie']) ?> km</td>
                                                <td><?= htmlspecialchars($veh['Statut']) ?></td>
                                                <td>
                                                    <a href="listevehicules.php?id=<?= htmlspecialchars($veh['id_vehicule']) ?>" class="btn btn-warning btn-sm">✏️</a>
                                                    <a href="listevehicules.php?delete=<?= htmlspecialchars($veh['id_vehicule']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce véhicule ?');">🗑️</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                
                                
                                
                      </div>

                    </form>
                                <div class="form-container">
                                    <label for="search" class="form-label">Search by Registration:</label>
                                    <form method="post" class="input-group mb-3">
                                        <input type="text" id="search" name="search" class="form-control" placeholder="Enter registration" value="<?= htmlspecialchars($searchTerm) ?>">
                                        
                                        <button type="submit" name="search_btn" class="btn btn-primary btn-lg" style="background-color: #2ecc71;
    border-color: #2ecc71;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                    </form>
                                </div>

                                <!-- Bouton de rafraîchissement -->
                                
                                <form method="post">
                    <div style="display: flex; justify-content: center; margin: 20px 0;">
                      <button type="submit" name="refresh_btn" class="btn btn-primary btn-lg" style="
    background-color: #2ecc71;
    border-color: #2ecc71;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;">
                        <i class="fas fa-refresh"></i> Refresh
                      </button>
                      </div>

                    </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php require_once '../includes/footer.php'; ?>
        </div>
    </div>
    
</body>

</html>