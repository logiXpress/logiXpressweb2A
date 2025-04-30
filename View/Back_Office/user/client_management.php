<?php
require_once '../../../Controller/UtilisateurC.php';
require_once '../../../Model/Utilisateur.php';
require_once '../../../config/config.php';

$utilisateurC = new UtilisateurC();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST['ajouter'])) {
    $utilisateur = new Utilisateur(
      htmlspecialchars($_POST['nom']),
      htmlspecialchars($_POST['prenom']),
      filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
      $_POST['mot_de_passe'],
      $_POST['type'],
      $_POST['phone_number']

    );
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
      'Client',
      $_POST['phone_number']

    );
    $utilisateur->setId(intval($_POST['modifier_id']));
    $utilisateurC->modifierUtilisateur($utilisateur);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
  }
}

$clients = array_filter($utilisateurC->getAllUtilisateurs(), fn($u) => $u['Type'] === 'Client');
?>
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

  body {
    font-family: 'Poppins', sans-serif;
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
                  <table id="clientsTable" class="table table-bordered table-striped table-hover align-middle">
                    <thead>
                      <tr>
                        <th>Client ID</th>
                        <th>Name</th>
                        <th>Last Name</th>
                        <th>E-mail</th>
                        <th>Password</th>
                        <th>Type</th>
                        <th>Phone Number</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (!empty($clients)): ?>
                        <?php foreach ($clients as $client): ?>
                          <tr>
                            <td><?= htmlspecialchars($client['id_utilisateur']) ?></td>
                            <td><?= htmlspecialchars($client['Nom']) ?></td>
                            <td><?= htmlspecialchars($client['Prénom']) ?></td>
                            <td><?= htmlspecialchars($client['Email']) ?></td>
                            <td><?= htmlspecialchars($client['Mot_de_passe']) ?></td>
                            <td><span class="badge bg-primary"><?= htmlspecialchars($client['Type']) ?></span></td>
                            <td><?= htmlspecialchars($client['phone_number']) ?></td>

                            <td>
                              <button class="btn btn-warning btn-sm edit-btn"
                                data-id="<?= $client['id_utilisateur'] ?>"
                                data-nom="<?= htmlspecialchars($client['Nom']) ?>"
                                data-prenom="<?= htmlspecialchars($client['Prénom']) ?>"
                                data-email="<?= htmlspecialchars($client['Email']) ?>"
                                data-motdepasse="<?= htmlspecialchars($client['Mot_de_passe']) ?>"
                                data-phonenumber="<?= htmlspecialchars($client['phone_number']) ?>"
                                data-bs-toggle="modal" data-bs-target="#modifierClientModal">
                                <i class="fas fa-edit"></i> Modify
                              </button>
                              <form method="POST" class="d-inline">
                                <input type="hidden" name="supprimer_id" value="<?= $client['id_utilisateur'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce client ?')">  <i class="fas fa-trash-alt"></i>Delete</button>
                              </form>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <tr>
                          <td colspan="7" class="text-center">Aucun client trouvé.</td>
                        </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                  <button class="btn btn-unigreen" data-bs-toggle="modal" data-bs-target="#ajoutClientModal">ADD a Client</button>

                </div>
              </div>
            </div>

          </div>

          <!-- Modal : Modifier un client -->
          <div class="modal fade" id="modifierClientModal" tabindex="-1" aria-labelledby="modifierClientModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <form method="POST" class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Modifier le Client</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="modifier_id" id="edit-id">
                  <div class="mb-3">
                    <label>Nom</label>
                    <input type="text" name="nom" id="edit-nom" class="form-control" >
                  </div>
                  <div class="mb-3">
                    <label>Prénom</label>
                    <input type="text" name="prenom" id="edit-prenom" class="form-control" >
                  </div>
                  <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" id="edit-email" class="form-control" >
                  </div>
                  <div class="mb-3">
                    <label>Mot de passe</label>
                    <input type="text" name="mot_de_passe" id="edit-motdepasse" class="form-control" >
                  </div>
                  <div class="mb-3">
                    <label>phone number</label>
                    <input type="text" name="phone_number" id="edit-phone_number" class="form-control" >
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" name="modifier" class="btn btn-primary">Modifier</button>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                </div>
              </form>
            </div>
          </div>

          <!-- Modal : Ajouter un client -->
          <div class="modal fade" id="ajoutClientModal" tabindex="-1" aria-labelledby="ajoutClientModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <form method="POST" class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Ajouter un Client</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                  <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="nom" id="add-nom" class="form-control" >
<div class="invalid-feedback" id="error-nom"></div>
                  </div>
                  <div class="mb-3">
                    <label>Last Name</label>
                    <input type="text" name="prenom" class="form-control" >
                  </div>
                  <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" >
                  </div>
                  <div class="mb-3">
                    <label>Password</label>
                    <input type="text" name="mot_de_passe" class="form-control" >
                  </div>
                  <div class="mb-3">
                    <label>Phone Number</label>
                    <input type="text" name="phone_number" class="form-control" >
                  </div>
                  <input type="hidden" name="type" value="Client">
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
  document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.edit-btn');

    editButtons.forEach(button => {
      button.addEventListener('click', function () {
        const id = this.dataset.id;
        const nom = this.dataset.nom;
        const prenom = this.dataset.prenom;
        const email = this.dataset.email;
        const motdepasse = this.dataset.motdepasse;
        const phoneNumber = this.dataset.phonenumber;

        document.getElementById('edit-id').value = id;
        document.getElementById('edit-nom').value = nom;
        document.getElementById('edit-prenom').value = prenom;
        document.getElementById('edit-email').value = email;
        document.getElementById('edit-motdepasse').value = motdepasse;
        document.getElementById('edit-phone_number').value = phoneNumber;
      });
    });
  });
</script>

<script>
  $(document).ready(function() {
    $('#clientsTable').DataTable({
      language: {
        search: "🔍 Recherche :",
        lengthMenu: "Afficher _MENU_ entrées",
        info: "Showing from _START_ To _END_ Of _TOTAL_ Entries",
        paginate: {
          previous: "⬅️ Précédent",
          next: "➡️ Previous"
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
  function showError(input, message) {
    const errorContainer = input.parentElement.querySelector('.error-message');
    if (errorContainer) {
      errorContainer.textContent = message;
    } else {
      const error = document.createElement('div');
      error.className = 'text-danger small error-message';
      error.textContent = message;
      input.parentElement.appendChild(error);
    }
  }

  function clearErrors(form) {
    const errors = form.querySelectorAll('.error-message');
    errors.forEach(err => err.remove());
  }

  function validateForm(form) {
    clearErrors(form); // Clear old messages

    const nom = form.querySelector('[name="nom"]');
    const prenom = form.querySelector('[name="prenom"]');
    const email = form.querySelector('[name="email"]');
    const motDePasse = form.querySelector('[name="mot_de_passe"]');
    const phoneNumber = form.querySelector('[name="phone_number"]');

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phonePattern = /^[0-9]{8}$/;

    let isValid = true;

    if (!nom.value.trim()) {
      showError(nom, "Veuillez entrer le nom.");
      isValid = false;
    }

    if (!prenom.value.trim()) {
      showError(prenom, "Veuillez entrer le prénom.");
      isValid = false;
    }

    if (!emailPattern.test(email.value.trim())) {
      showError(email, "Veuillez entrer un email valide.");
      isValid = false;
    }

    if (motDePasse.value.length < 6) {
      showError(motDePasse, "Le mot de passe doit contenir au moins 6 caractères.");
      isValid = false;
    }

    if (!phonePattern.test(phoneNumber.value.trim())) {
      showError(phoneNumber, "Le numéro de téléphone doit contenir 8 chiffres.");
      isValid = false;
    }

    return isValid;
  }

  document.addEventListener("DOMContentLoaded", function () {
    const ajoutForm = document.querySelector('#ajoutClientModal form');
    const modifierForm = document.querySelector('#modifierClientModal form');

    if (ajoutForm) {
      ajoutForm.onsubmit = () => validateForm(ajoutForm);
    }

    if (modifierForm) {
      modifierForm.onsubmit = () => validateForm(modifierForm);
    }
  });
</script>


</body>

</html>