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
        $phone_number = $_POST['phone_number'];

        $utilisateur = new Utilisateur($nom, $prenom, $email, $motDePasse, $type, $phone_number);

        // Try to add the user
        $result = $utilisateurC->ajouterUtilisateur($utilisateur);

        if ($result === "Email already exists!") {
            // Show error message if email already exists
            echo "<p class='error'>Email already exists! Please use a different one.</p>";
        } else {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
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
            'Livreur',
            $_POST['phone_number']

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
<html lang="en">
<?php require_once '../includes/header.php'; ?>

<style>
    .card-header {
        display: flex;
        align-items: center;
        background-color: #2ecc71;
        /* Unigreen color */
        color: white;
        padding: 15px;
        border-radius: 10px;
        /* Rounded edges for the header */
        position: absolute;
        top: -35px;
        left: 2px;
        width: calc(100% - 10px);
        /* To fit with the card width */
    }

    .icon {
        background: #2ecc71;
        /* Unigreen color */
        color: white;
        border-radius: 5px;
        /* Now it's rectangular */
        padding: 20px;
        margin-right: 10px;
        margin-bottom: 15px;
    }

    .card {
        border: none;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        margin-bottom: 30px;
    }

    .form-label {
        font-weight: 600;
    }

    .btn-primary {
        background-color: #2ecc71;
        border-color: #2ecc71;
    }

    .btn-primary:hover {
        background-color: #27ae60;
        border-color: #27ae60;
    }
    
  table.dataTable {
    font-size: 15px;
    font-weight: 400;
  }

  table.dataTable thead {
    background-color: #2ecc71;
    color: white;
    font-weight: 600;
    font-size: 16px;
  }

  table.dataTable tbody td {
    vertical-align: middle;
    padding: 12px 10px;
  }

  table.dataTable tbody tr:hover {
    background-color: #f9f9f9;
    cursor: pointer;
  }

  .btn-sm i {
    margin-right: 5px;
  }
</style>


<body class="">

    <div class="wrapper">
        <?php require_once '../includes/configurator.php'; ?>
        <?php require_once '../includes/sidenav.php'; ?>
        <div class="main-panel">
            <?php require_once '../includes/navbar.php'; ?>
            <div class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="card mb-4">
                            <div class="card-header pb-0 d-flex justify-content-between align-items-center">

                            </div>
                            <div class="card-body px-0 pt-0 pb-2">
                                <div class="table-responsive p-3">
                                    <table id="livreursTable" class="table table-bordered table-striped table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>User Id</th>
                                                <th>Name</th>
                                                <th>Last Name</th>
                                                <th>E-mail</th>
                                                <th>Password</th>
                                                <th>Type</th>
                                                <th>PhoneNumber</th>
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
                                                    <td><?= htmlspecialchars($livreur['Mot_de_passe']) ?></td>
                                                    <td><span
                                                            class="badge bg-info"><?= htmlspecialchars($livreur['Type']) ?></span>
                                                    </td>
                                                    <td><?= htmlspecialchars($livreur['phone_number']) ?></td>

                                                    <td class="d-flex gap-2 justify-content-center">
                                                        <!-- Delete Button -->
                                                        <form method="POST" class="d-inline">
                                                            <input type="hidden" name="supprimer_id" value="<?= $livreur['id_utilisateur'] ?>">
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce livreur ?')">
                                                                <i class="fas fa-trash-alt"></i> Supprimer
                                                            </button>
                                                        </form>

                                                        <!-- Modify Button -->
                                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                            data-bs-target="#modifierLivreurModal<?= $livreur['id_utilisateur'] ?>">
                                                            <i class="fas fa-edit"></i> Modifier
                                                        </button>
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
                                    <button class="btn btn-sm btn-unigreen" data-bs-toggle="modal"
                                        data-bs-target="#ajoutLivreurModal">Add a Courrier</button>
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
                                                value="<?= htmlspecialchars($livreur['Nom']) ?>" >
                                        </div>
                                        <div class="mb-3">
                                            <label>Prénom</label>
                                            <input type="text" name="prenom" class="form-control"
                                                value="<?= htmlspecialchars($livreur['Prénom']) ?>" >
                                        </div>
                                        <div class="mb-3">
                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control"
                                                value="<?= htmlspecialchars($livreur['Email']) ?>" >
                                        </div>
                                        <div class="mb-3">
                                            <label>Mot de Passe</label>
                                            <input type="text" name="mot_de_passe" class="form-control" value="<?= htmlspecialchars($livreur['Mot_de_passe']) ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Phone</label>
                                            <input type="number" name="phone_number" class="form-control" value="<?= htmlspecialchars($livreur['phone_number']) ?>">
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
                                        <input type="text" name="nom" class="form-control" >
                                    </div>
                                    <div class="mb-3">
                                        <label>Prénom</label>
                                        <input type="text" name="prenom" class="form-control" >
                                    </div>
                                    <div class="mb-3">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" >
                                    </div>
                                    <div class="mb-3">
                                        <label>Mot de passe</label>
                                        <input type="password" name="mot_de_passe" class="form-control" >
                                    </div>
                                    <div class="mb-3">
                                        <label>Phone</label>
                                        <input type="number" name="phone_number" class="form-control" >
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






                </div>
            </div>
            <?php require_once '../includes/footer.php'; ?>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#livreursTable').DataTable({
                language: {
                    search: "🔍 Recherche :",
                    lengthMenu: "Afficher _MENU_ entrées",
                    info: "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
                    paginate: {
                        previous: "⬅️ Précédent",
                        next: "➡️ Suivant"
                    }
                },
                columnDefs: [{
                        targets: -1,
                        orderable: false
                    } // Désactive le tri sur la dernière colonne (Actions)
                ],
                order: [
                    [0, "asc"]
                ]
            });
        });
    </script>
<script>
    function validateForm(form) {
        const nom = form.nom.value.trim();
        const prenom = form.prenom.value.trim();
        const email = form.email.value.trim();
        const motDePasse = form.mot_de_passe.value.trim();
        const phone = form.phone_number.value.trim();

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const phoneRegex = /^[0-9]{8}$/;

        let errors = [];
        let errorMessages = {};

        // Check required fields and apply validations
        if (nom === "") {
            errors.push("Nom est requis.");
            errorMessages.nom = "Nom est requis.";
        }
        if (prenom === "") {
            errors.push("Prénom est requis.");
            errorMessages.prenom = "Prénom est requis.";
        }
        if (!emailRegex.test(email)) {
            errors.push("Email invalide.");
            errorMessages.email = "Email invalide.";
        }
        if (motDePasse.length < 6) {
            errors.push("Mot de passe doit contenir au moins 6 caractères.");
            errorMessages.mot_de_passe = "Mot de passe doit contenir au moins 6 caractères.";
        }
        if (!phoneRegex.test(phone)) {
            errors.push("Numéro de téléphone invalide (au moins 8 chiffres).");
            errorMessages.phone_number = "Numéro de téléphone invalide (au moins 8 chiffres).";
        }

        // Clear previous error messages
        document.querySelectorAll(".error-message").forEach(el => el.remove());

        // Display errors under the corresponding fields
        if (errors.length > 0) {
            for (const field in errorMessages) {
                const inputElement = form.querySelector(`[name="${field}"]`);
                if (inputElement) {
                    const errorElement = document.createElement("div");
                    errorElement.classList.add("error-message");
                    errorElement.style.color = "red"; // You can style it as needed
                    errorElement.textContent = errorMessages[field];
                    inputElement.insertAdjacentElement("afterend", errorElement);
                }
            }
            return false;
        }

        return true;
    }

    // Attach the validate function to all forms on the page
    document.querySelectorAll("form").forEach(form => {
        form.addEventListener("submit", function (e) {
            if (!validateForm(this)) {
                e.preventDefault(); // Prevent form submission if validation fails
            }
        });
    });
</script>



</body>

</html>