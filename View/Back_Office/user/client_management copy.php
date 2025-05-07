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
      $_POST['type'],      $_POST['phone_number']

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
      'Client',      $_POST['phone_number']

    );
    $utilisateur->setId(intval($_POST['modifier_id']));
    $utilisateurC->modifierUtilisateur($utilisateur);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
  }
}

$clients = array_filter($utilisateurC->getAllUtilisateurs(), fn($u) => $u['Type'] === 'Client');
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
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Liste des Clients</h5>
              <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ajoutClientModal">Ajouter un Client</button>
            </div>
            <div class="card-body pt-0">
              <div class="table-responsive">
                <table class="table align-items-center mb-0 table-hover">
                  <thead class="bg-light">
                    <tr>
                      <th>ID</th>
                      <th>Nom</th>
                      <th>Prénom</th>
                      <th>Email</th>
                      <th>Mot de passe</th>
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
                              Modifier
                            </button>
                            <form method="POST" class="d-inline">
                              <input type="hidden" name="supprimer_id" value="<?= $client['id_utilisateur'] ?>">
                              <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce client ?')">Supprimer</button>
                            </form>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr><td colspan="7" class="text-center">Aucun client trouvé.</td></tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
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
              <input type="text" name="nom" id="edit-nom" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Prénom</label>
              <input type="text" name="prenom" id="edit-prenom" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Email</label>
              <input type="email" name="email" id="edit-email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Mot de passe</label>
              <input type="text" name="mot_de_passe" id="edit-motdepasse" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>phone number</label>
              <input type="text" name="phone_number" id="edit-phone_number" class="form-control" required>
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
            
            <input type="hidden" name="type" value="Client">
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
  <script>
  // Fonction de validation du formulaire d'ajout
  document.querySelector('#ajoutClientModal form').addEventListener('submit', function(e) {
    const nom = this.nom.value.trim();
    const prenom = this.prenom.value.trim();
    const email = this.email.value.trim();
    const motDePasse = this.mot_de_passe.value;
    const phone = this.phone_number?.value?.trim();

    if (!/^[a-zA-Z]+$/.test(nom)) {
      alert("Le nom ne doit contenir que des lettres.");
      e.preventDefault();
      return;
    }

    if (!/^[a-zA-Z]+$/.test(prenom)) {
      alert("Le prénom ne doit contenir que des lettres.");
      e.preventDefault();
      return;
    }

    if (!/^\S+@\S+\.\S+$/.test(email)) {
      alert("Email invalide.");
      e.preventDefault();
      return;
    }

    if (motDePasse.length < 6) {
      alert("Le mot de passe doit contenir au moins 6 caractères.");
      e.preventDefault();
      return;
    }

    if (phone && !/^\d{8}$/.test(phone)) {
      alert("Le numéro de téléphone doit contenir exactement 8 chiffres.");
      e.preventDefault();
      return;
    }
  });

  // Même chose pour le formulaire de modification
  document.querySelector('#modifierClientModal form').addEventListener('submit', function(e) {
    const nom = this.nom.value.trim();
    const prenom = this.prenom.value.trim();
    const email = this.email.value.trim();
    const motDePasse = this.mot_de_passe.value;
    const phone = this.phone_number.value.trim();

    if (!/^[a-zA-Z]+$/.test(nom)) {
      alert("Le nom ne doit contenir que des lettres.");
      e.preventDefault();
      return;
    }

    if (!/^[a-zA-Z]+$/.test(prenom)) {
      alert("Le prénom ne doit contenir que des lettres.");
      e.preventDefault();
      return;
    }

    if (!/^\S+@\S+\.\S+$/.test(email)) {
      alert("Email invalide.");
      e.preventDefault();
      return;
    }

    if (motDePasse.length < 6) {
      alert("Le mot de passe doit contenir au moins 6 caractères.");
      e.preventDefault();
      return;
    }

    if (!/^\d{8}$/.test(phone)) {
      alert("Le numéro de téléphone doit contenir exactement 8 chiffres.");
      e.preventDefault();
      return;
    }
  });
</script>


</body>
</html>
