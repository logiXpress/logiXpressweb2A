<?php
require_once 'C:/Users/Desktop/PHP/htdocs/Project/Model/Entretien.php';
require_once 'C:/Users/Desktop/PHP/htdocs/Project/Controller/EntretienC.php';

$EntretienC = new EntretienC();

// Gestion des actions
if (isset($_POST['add'])) {
    $EntretienC->ajouterEntretien(new Entretien($_POST['id_vehicule'], $_POST['date'], $_POST['type_intervention']));
    $EntretienC->ajouterHistorique('add', $_POST['id_vehicule'], $_POST['type_intervention']);
    header('Location: listeentretiens.php');
    exit();
}

if (isset($_GET['delete'])) {
    $entretien = $EntretienC->getEntretienById($_GET['delete']);
    if ($entretien) {
        $EntretienC->supprimerEntretien($_GET['delete']);
        $EntretienC->ajouterHistorique('delete', $entretien['id_vehicule'], $entretien['Type_intervention']);
    }
    header('Location: listeentretiens.php');
    exit();
}

$entretien = null;
if (isset($_GET['id'])) {
    $entretien = $EntretienC->getEntretienById($_GET['id']);
}

if (isset($_POST['update']) && $entretien) {
    $EntretienC->modifierEntretien($_POST['id_entretien'], new Entretien($_POST['id_vehicule'], $_POST['date'], $_POST['type_intervention']));
    $EntretienC->ajouterHistorique('update', $_POST['id_vehicule'], $_POST['type_intervention']);
    header('Location: listeentretiens.php');
    exit();
}




// Appel de la méthode pour lister les entretiens
$searchId = '';
$entretiens = []; // Initialiser la variable

if (isset($_POST['search_btn'])) {
    $searchId = $_POST['search_id'] ?? '';
    $entretiens = $EntretienC->rechercherEntretienParId($searchId);
} else {
    $entretiens = $EntretienC->listeentretiens(); // Par défaut, lister tous les entretiens
}

// Vérifiez si le tri par date est demandé
if (isset($_POST['sort_date'])) {
    $entretiens = $EntretienC->sortEntretiensByDate(); // Appeler la méthode de tri
}
$vehicule_id = isset($_GET['vehicule_id']) ? trim($_GET['vehicule_id']) : '';
$historique = [];

if (!empty($vehicule_id)) {
    $historique = $EntretienC->rechercherHistoriqueParIdVehicule($vehicule_id);
}

// Tri par date décroissante
usort($historique, function ($a, $b) {
    $dateA = strtotime($a['date']);
    $dateB = strtotime($b['date']);
    return $dateB - $dateA; // Ordre décroissant
});
// Notez que si le tri est effectué, il ne tiendra pas compte de la recherche, à moins que vous ne le souhaitiez
?>

<!DOCTYPE html>
<html lang="fr">

<?php require_once '../includes/header.php'; ?>
<style>
    body {
        background-color: #f4f6f8;
        /* Fond clair */
        overflow-x: hidden;
        /* Masque le débordement horizontal */
    }

    .card {
        background-color: white;
        /* Fond blanc pour la carte */
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin: 20px;
        /* Supprimer auto pour avoir le formulaire à gauche */
        width: calc(100% - 40px);
        /* Largeur presque complète */
        max-width: 600px;
        /* Largeur maximale */
    }

    .card-header {
        background-color: #2ecc71;
        /* Couleur de fond verte */
        color: white;
        /* Couleur du texte en blanc */
        padding: 15px;
        border-radius: 10px 10px 0 0;
        /* Coins arrondis en haut */
        text-align: left;
        /* Alignement à gauche */
    }

    .form-group {
        margin-bottom: 40px;
        /* Espacement entre les champs */
    }

    .form-group-row {
        margin-bottom: 20px;
        /* Espacement entre les groupes de formulaire */
    }

    .form-label {
        font-weight: bold;
        margin-bottom: 5px;
        /* Espacement sous le label */
    }

    .form-control {
        border: 1px solid #ccc;
        /* Bordure des champs */
        border-radius: 5px;
        /* Coins arrondis */
        padding: 10px;
        /* Espacement interne */
        width: 100%;
        /* Largeur complète */
    }

    .btn-unigreen {
        background-color: #2ecc71;
        /* Couleur du bouton */
        color: white;
        /* Texte en blanc */
        border: none;
        /* Pas de bordure */
        padding: 10px 20px;
        /* Espacement interne */
        border-radius: 5px;
        /* Coins arrondis */
        transition: background-color 0.3s;
        /* Transition douce */
    }

    .btn-unigreen:hover {
        background-color: #27ae60;
        /* Couleur au survol */
    }

    .text-center {
        text-align: center;
        /* Centre le texte */
    }

    #typeError {
        color: red;
        /* Couleur du message d'erreur */
    }

    .form-ajout {
        padding: 20px;
        /* Ajouter du padding pour un meilleur aspect */
        width: 100%;
        /* Largeur complète */
        border-radius: 10px;
        /* Coins arrondis */
        background-color: white;
        /* Couleur de fond */
    }

    .add-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        /* Largeur de l'icône */
        height: 60px;
        /* Hauteur de l'icône */
        background-color: #2ecc71;
        /* Fond vert */
        border-radius: 5px;
        /* Coins arrondis */
        color: white;
        /* Couleur de l'icône */
        font-size: 18px;
        /* Taille de l'icône */
        position: absolute;
        /* Position absolue pour l'icône */
        left: 15px;
        /* Ajustement horizontal */
        top: -20px;
        /* Ajustement vertical pour monter sur le formulaire */
    }

    .card-title {
        display: flex;
        /* Utilisation de flexbox pour aligner l'icône et le texte */
        align-items: center;
        /* Centre l'icône et le texte verticalement */
        font-weight: 500;
        /* Poids du texte */
        color: #3c4858;
        /* Couleur du texte */
    }

    .card-liste {
        background-color: white;
        /* Fond blanc pour la carte */
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin: 20px;
        /* Supprimer auto pour avoir la carte à gauche */
        width: calc(100% - 40px);
        /* Largeur presque complète */
        max-width: 100%;
        /* Supprimer la largeur maximale */
    }

    .card-header-liste {
        background-color: rgb(255, 255, 255);
        /* Couleur de fond verte */
        color: white;
        /* Couleur du texte en blanc */
        padding: 15px;
        border-radius: 10px 10px 0 0;
        /* Coins arrondis en haut */
        text-align: left;
        /* Alignement à gauche */
    }
</style>
<script>
    function isLetter(event) {
        const char = String.fromCharCode(event.which);
        const typeError = document.getElementById('typeError');

        // Vérifie si le caractère est une lettre ou un espace
        if (!/^[a-zA-Z\s]$/.test(char)) {
            typeError.textContent = 'Veuillez entrer des caractères uniquement.';
            event.preventDefault(); // Empêche l'entrée de caractères invalides
            return false;
        } else {
            typeError.textContent = ''; // Efface le message d'erreur
        }

        return true;
    }
</script>

<body>
    <div class="wrapper">
        <?php require_once '../includes/configurator.php'; ?>
        <?php require_once '../includes/sidenav.php'; ?>

        <div class="main-panel">
            <?php require_once '../includes/navbar.php'; ?>

            <div class="content">
                <div class="container-fluid">
                    <div class="row justify-content-center">

                        <!-- Formulaire de modification -->
                        <div class="col-md-12"> <!-- Utiliser une colonne pleine largeur -->
                            <div class="card">
                                <div class="card-header">
                                    <div class="add-icon">
                                        <i class="fas fa-pencil-alt"></i> <!-- Icône de modification -->
                                    </div>
                                    <h3 class="card-title mb-0">Modify A Maintenance</h3>
                                </div>
                                <div class="card-body">
                                    <form method="post" class="form-ajout"> <!-- S'assurer que cette classe est appliquée -->
                                        <input type="hidden" name="id_entretien" value="<?= htmlspecialchars($entretien['id_entretien'] ?? '') ?>">

                                        <div class="form-group-row">
                                            <label class="form-label" for="id_vehicule">Vehicle ID *</label>
                                            <input type="number" id="id_vehicule" name="id_vehicule" class="form-control" required
                                                value="<?= htmlspecialchars($entretien['id_vehicule'] ?? '') ?>">
                                        </div>

                                        <div class="form-group-row">
                                            <label class="form-label" for="date">Date *</label>
                                            <input type="date" id="date" name="date" class="form-control" required
                                                value="<?= htmlspecialchars($entretien['Date'] ?? '') ?>">
                                        </div>

                                        <div class="form-group-row">
                                            <label class="form-label" for="type_intervention">
                                            Type of Intervention*</label>
                                            <input type="text" id="type_intervention" name="type_intervention" class="form-control" required
                                                value="<?= htmlspecialchars($entretien['Type_intervention'] ?? '') ?>">
                                        </div>

                                        <div class="text-center mt-4">
                                            <button type="submit" name="update" class="btn btn-unigreen btn-lg">
                                                <i class="fas fa-pencil-alt"></i> Modify
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Formulaire de recherche placé correctement -->
                        <div class="col-md-8">
                            <div class="form-container">
                                <form method="post" class="input-group" style="display: flex; align-items: center;">

                                    <input type="text" id="search_id" name="search_id" class="form-control" placeholder="Entrez l'ID véhicule" value="<?= htmlspecialchars($searchId ?? '') ?>" required style="flex: 1; margin-right: 10px;">
                                    <button type="submit" name="search_btn" class="btn btn-unigreen" style="background-color:rgb(46, 204, 113); border-color:rgb(154, 63, 172); font-weight: bold;">
                                        <i class="fas fa-search"></i> Search By <br>Vehicle ID
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Liste des entretiens -->
                        <div class="col-md-12"> <!-- Colonne pleine largeur -->
                            <div class="card-liste">
                                <div class="card-header-liste">
                                    <div class="add-icon" style="display: flex; align-items: center; justify-content: center; width: 60px; height: 60px; background-color: #2ecc71; border-radius: 10px; margin-right: 90px;">
                                        <i class="fas fa-clipboard" style="color: white; font-size: 24px;"></i> <!-- Icône de clipboard -->
                                    </div>
                                    <h3 class="card-title mb-0">List of Maintenance</h3>
                                    <div class="d-flex justify-content-between">
                                        <form method="post" style="display: inline;">
                                            <button type="submit" name="sort_date" class="btn btn-unigreen" >
                                                <i class="fas fa-sort"></i> Sort by Date
                                            </button>
                                        </form>
                                        <form method="post" style="margin-left: 20px;">
                                            <button type="submit" name="refresh_btn" class="btn btn-unigreen" >
                                                <i class="fas fa-refresh"></i> Refresh
                                            </button>
                                        </form>
                                        <form method="get" action="historique.php" style="margin-left: 20px;">
                                            <button type="submit" class="btn btn-unigreen" >
                                                <i class="fas fa-history"></i> History
                                            </button>
                                        </form>
                                        
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-hover table-bordered text-center">
                                        <thead class="table-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Vehice ID</th>
                                                <th>Date</th>
                                                <th> Type of Intervention</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($entretiens as $ent): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($ent['id_entretien']) ?></td>
                                                    <td><?= htmlspecialchars($ent['id_vehicule']) ?></td>
                                                    <td><?= htmlspecialchars($ent['Date']) ?></td>
                                                    <td><?= htmlspecialchars($ent['Type_intervention']) ?></td>
                                                    <td>
                                                        <a href="listeentretiens.php?id=<?= htmlspecialchars($ent['id_entretien']) ?>" class="btn btn-warning btn-sm">✏️</a>
                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmDeleteModal" data-id="<?= htmlspecialchars($ent['id_entretien']) ?>">
                                                            🗑️
                                                        </button>

                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        

                    </div>
                </div>
            </div>

            <?php require_once '../includes/footer.php'; ?>
        </div>
        <!-- Modal de confirmation de suppression -->
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">Deletion confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    Are you sure you want to delete this  maintenance?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        <a href="#" class="btn btn-danger" id="confirmDeleteBtn">Yes</a>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var confirmDeleteModal = document.getElementById('confirmDeleteModal');
                var confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

                $('#confirmDeleteModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget); // Le bouton qui a déclenché
                    var id = button.data('id'); // Récupère l'ID
                    confirmDeleteBtn.href = "listeentretiens.php?delete=" + id;
                });
            });
        </script>

    </div>
</body>

</html>