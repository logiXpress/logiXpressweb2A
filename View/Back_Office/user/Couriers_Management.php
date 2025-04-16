<?php
require_once '../../../Controller/UtilisateurC.php';
require_once '../../../Model/Utilisateur.php';
require_once '../../../config/config.php';

$utilisateurC = new UtilisateurC();

// Traitement des formulaires
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['ajouter'])) {
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $motDePasse = $_POST['mot_de_passe'];
        $type = $_POST['type']; // "Livreur"

        $utilisateur = new Utilisateur($nom, $prenom, $email, $motDePasse, $type);
        $utilisateurC->ajouterUtilisateur($utilisateur);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    if (isset($_POST['supprimer_id'])) {
        $utilisateurC->deleteUtilisateur(intval($_POST['supprimer_id']));
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    if (isset($_POST['modifier'])) {
        $utilisateur = new Utilisateur(
            htmlspecialchars($_POST['nom']),
            htmlspecialchars($_POST['prenom']),
            filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
            $_POST['mot_de_passe'],
            'Livreur' // Assuming 'Livreur' as default, adjust if needed
        );
        $utilisateur->setId(intval($_POST['modifier_id'])); // Use modifier_id here
        $utilisateurC->modifierUtilisateur($utilisateur);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

$utilisateurs = $utilisateurC->getAllUtilisateurs();
$livreurs = array_filter($utilisateurs, fn($u) => $u['Type'] === 'Livreur');
?>

<!DOCTYPE html>
<html lang="fr">
<?php require_once '../includes/header.php'; ?>

<body class="g-sidenav-show bg-gray-100">
    <?php include_once '../includes/sidenav.php'; ?>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <?php include_once '../includes/navbar.php'; ?>
        <?php include_once '../includes/configurator.php'; ?>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Liste des Livreurs</h6>
                            <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                data-bs-target="#ajoutLivreurModal">Ajouter un Livreur</button>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-3">
                                <table class="table align-items-center mb-0 table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th>Email</th>
                                            <th>Type</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($livreurs as $livreur): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($livreur['id_utilisateur']) ?></td>
                                                <td><?= htmlspecialchars($livreur['Nom']) ?></td>
                                                <td><?= htmlspecialchars($livreur['Prénom']) ?></td>
                                                <td><?= htmlspecialchars($livreur['Email']) ?></td>
                                                <td><span
                                                        class="badge bg-info"><?= htmlspecialchars($livreur['Type']) ?></span>
                                                </td>
                                                <td>
                                                    <form method="POST" class="d-inline">
                                                        <input type="hidden" name="supprimer_id"
                                                            value="<?= $livreur['id_utilisateur'] ?>">
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Supprimer ce livreur ?')">Supprimer</button>
                                                    </form>
                                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#modifierLivreurModal<?= $livreur['id_utilisateur'] ?>">Modifier</button>
                                                </td>
                                            </tr>

                                        <?php endforeach; ?>
                                        <?php if (empty($livreurs)): ?>
                                            <tr>
                                                <td colspan="6" class="text-center">Aucun livreur trouvé.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de modification pour ce livreur -->
        <?php foreach ($livreurs as $livreur): ?>
        <div class="modal fade" id="modifierLivreurModal<?= $livreur['id_utilisateur'] ?>" tabindex="-1"
            aria-labelledby="modifierLivreurModalLabel<?= $livreur['id_utilisateur'] ?>" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modifier le Livreur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="modifier_id" value="<?= $livreur['id_utilisateur'] ?>">
                        <div class="mb-3">
                            <label>Nom</label>
                            <input type="text" name="nom" class="form-control"
                                value="<?= htmlspecialchars($livreur['Nom']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Prénom</label>
                            <input type="text" name="prenom" class="form-control"
                                value="<?= htmlspecialchars($livreur['Prénom']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control"
                                value="<?= htmlspecialchars($livreur['Email']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Mot de Passe</label>
                            <input type="password" name="mot_de_passe" class="form-control">
                        </div>
                        <input type="hidden" name="type" value="Livreur">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="modifier" class="btn btn-warning">Modifier</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
        <?php endforeach; ?>

        <!-- Modal : Ajouter un livreur -->
        <div class="modal fade" id="ajoutLivreurModal" tabindex="-1" aria-labelledby="ajoutLivreurModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ajouter un Livreur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nom</label>
                            <input type="text" name="nom" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Prénom</label>
                            <input type="text" name="prenom" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Mot de passe</label>
                            <input type="password" name="mot_de_passe" class="form-control" required>
                        </div>
                        <input type="hidden" name="type" value="Livreur">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="ajouter" class="btn btn-success">Ajouter</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php include_once '../includes/footer.php'; ?>
</body>

</html>
