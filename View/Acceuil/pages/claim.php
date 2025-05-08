<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap"
    rel="stylesheet">

  <title>Secure Checkout | LogiXpress</title>

  <!-- Bootstrap core CSS -->
  <link href="../../../Public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Additional CSS Files -->
  <link rel="stylesheet" href="../../../Public/assets/css/fontawesome.css">
  <link rel="stylesheet" href="../../../Public/assets/css/style.css">
  <link rel="stylesheet" href="../../../Public/assets/css/owl.css">
</head>

<body>

  <!-- *** Preloader Start *** -->
  <div id="preloader">
    <div class="jumper">
      <div></div>
      <div></div>
      <div></div>
    </div>
  </div>
  <!-- *** Preloader End *** -->

  <!-- Header -->
  <div class="sub-header">
    <div class="container">
      <div class="row">
        <div class="col-md-8 col-xs-12">
          <ul class="left-info">
            <li><a href="#"><i class="fa fa-envelope"></i>logixpress@gmail.com</a></li>
            <li><a href="#"><i class="fa fa-phone"></i>+216 56 207 742</a></li>
          </ul>
        </div>
        <div class="col-md-4">
          <ul class="right-icons">
            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <header class="background-header">
    <nav class="navbar navbar-expand-lg">
      <div class="container">
        <a class="navbar-brand" href="../index.php">
          <h2>LogiXpress<em> Website</em></h2>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
          aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="../index.php">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="products.html">Products</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="claim.php">Claims</a>
            </li>
            <li class="nav-item dropdown">
              <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                aria-expanded="false">About</a>

              <div class="dropdown-menu">
                <a class="dropdown-item" href="about.html">About Us</a>
                <a class="dropdown-item" href="blog.html">Blog</a>
                <a class="dropdown-item" href="testimonials.html">Testimonials</a>
                <a class="dropdown-item" href="terms.html">Terms</a>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.html">Contact Us</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <div class="page-heading header-text">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1>Your Claims</h1>
          <span>If there's any issue, issue your claim here</span>
        </div>
      </div>
    </div>
  </div>


  <!-- Page Content -->
  <?php
  session_start();
  include '../../../Controller/ReclamationC.php';
  include '../../../Controller/ReponsesAdminC.php';
  include '../../../Model/ReponsesAdmin.php';

  $reclamationC = new ReclamationC();
  $liste = [];
  $editMode = false;
  $reclamationToEdit = null;

  $sortColumn = $_GET['sort'] ?? 'id_reclamation';
  $sortOrder = $_GET['order'] ?? 'asc';
  $statusFilter = $_GET['status_filter'] ?? null;

  // Récupération des réclamations
  if (!empty($_SESSION['id_client'])) {
    $id_client = $_SESSION['id_client'];
    $liste = $reclamationC->getReclamationsByClientId($id_client, $sortColumn, $sortOrder, $statusFilter);
  }

  $reponsesAdminC = new ReponsesAdminC();
  $reponses = $reponsesAdminC->getAllReponsesAdmin();
  $reponsesByReclamation = [];
  foreach ($reponses as $reponse) {
    $reponsesByReclamation[$reponse['id_reclamation']] = $reponse;
  }

  // Filtrage par statut
  if (!empty($statusFilter)) {
    $liste = array_filter($liste, function ($rec) use ($statusFilter) {
      return strtolower($rec['Statut']) === strtolower($statusFilter);
    });
  }

  // Tri
  usort($liste, function ($a, $b) use ($sortColumn, $sortOrder) {
    $valA = strtolower($a[$sortColumn]);
    $valB = strtolower($b[$sortColumn]);

    if (is_numeric($valA) && is_numeric($valB)) {
      return ($sortOrder === 'asc') ? $valA - $valB : $valB - $valA;
    } else {
      return ($sortOrder === 'asc') ? strcmp($valA, $valB) : strcmp($valB, $valA);
    }
  });

  // Pagination
  $perPage = 3;
  $totalClaims = count($liste);
  $totalPages = ceil($totalClaims / $perPage);
  $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
  $currentPage = max(1, min($totalPages, $currentPage));
  $startIndex = ($currentPage - 1) * $perPage;
  $liste = array_slice($liste, $startIndex, $perPage);

  // Mode édition
  if (isset($_GET['id_reclamation'])) {
    $editMode = true;
    $idReclam = intval($_GET['id_reclamation']);
    foreach ($liste as $rec) {
      if ($rec['id_reclamation'] == $idReclam) {
        $reclamationToEdit = $rec;
        break;
      }
    }
  }

  // Tri visuel
  function renderSortIcons($column, $currentSort, $currentOrder)
  {
    $ascUrl = "?sort=$column&order=asc";
    $descUrl = "?sort=$column&order=desc";
    $ascColor = ($currentSort === $column && $currentOrder === 'asc') ? '#f1c40f' : 'white';
    $descColor = ($currentSort === $column && $currentOrder === 'desc') ? '#f1c40f' : 'white';

    return <<<HTML
    <span style="float: right;">
      <a href="$ascUrl" class="sort-arrow" data-sort="$column" data-order="asc" style="color: $ascColor; text-decoration: none;">↑</a>
      <a href="$descUrl" class="sort-arrow" data-sort="$column" data-order="desc" style="color: $descColor; text-decoration: none; margin-left: 5px;">↓</a>
    </span>
  HTML;
  }
  ?>
  <?php require_once '../../../View/Back_Office/includes/header.php'; ?>
  <style>
    .card-header {
      display: flex;
      align-items: center;
      background-color: #2ecc71;
      color: white;
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 20px;
    }

    .icon {
      background: #2ecc71;
      color: white;
      border-radius: 5px;
      padding: 10px;
      margin-right: 10px;
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

    .btn-unigreen {
      background-color: #2ecc71;
      border-color: #2ecc71;
    }

    .btn-unigreen:hover {
      background-color: #27ae60;
      border-color: #27ae60;
    }

    .content-wrapper {
      display: flex;
      justify-content: space-between;
      gap: 40px;
      padding: 70 70px;
      /* Ajoute un padding sur les côtés */
    }


    .form-container {
      flex: 0.5;
      max-width: 1000px;
      margin-left: 10px;
    }


    .table-container {
      flex: 0.5;
      max-width: 80%;
    }



    .table-container h1 {
      text-align: center;
      font-weight: bold;
      font-size: 32px;
      margin-bottom: 20px;
    }


    table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0 10px;
      font-size: 14px;
    }

    table th {
      background-color: #2ecc71;
      color: white;
      text-align: left;
      /* Corrigé pour "left" uniquement */
      vertical-align: middle;
      padding: 15px;
      border: none;
      border-radius: 10px 10px 0 0;
      font-size: 14px;
    }

    table tbody tr {
      background: #ffffff;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
      text-align: left;
    }

    table tbody tr:hover {
      transform: scale(1.02);
    }

    table td {
      padding: 15px;
      vertical-align: middle;
      text-align: center;
      border: none;
      font-size: 14px;
    }

    .sort-arrow {
      font-size: 16px;
      cursor: pointer;
    }


    .text-center {
      text-align: center;
    }

    .popup-overlay {
      display: none;
      position: fixed;
      z-index: 999;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.4);
    }

    .popup-container {
      display: none;
      position: fixed;
      z-index: 1000;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: #fff;
      padding: 30px;
      width: 400px;
      max-width: 90%;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
      text-align: center;
      font-family: 'Segoe UI', sans-serif;
    }

    .popup-text {
      font-size: 18px;
      margin-bottom: 25px;
      color: #333;
    }

    .popup-buttons {
      display: flex;
      justify-content: space-around;
    }

    .popup-buttons button {
      padding: 10px 25px;
      font-size: 16px;
      color: #fff;
      background-color: #6c757d;
      /* initial grey */
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .popup-buttons button:active {
      transform: scale(0.97);
    }

    .popup-buttons button.clicked {
      background-color: #28a745 !important;
      /* green on click */
    }
  </style>
  <div class="row justify-content-center align-items-start">
    <!-- Form Column -->
    <div class="col-md-6 mb-4">
      <div class="card">
        <div class="card-header">
          <div class="icon"><i class="material-icons">contacts</i></div>
          <h3 class="card-title">Add a Claim</h3>
        </div>
        <div class="card-body">
          <!-- Formulaire -->
          <!-- Formulaire -->
          <form id="reclamationForm" action="Add.php" method="POST" onsubmit="return validateForm();">
            <?php if ($editMode): ?>
              <input type="hidden" name="id_reclamation" value="<?= $reclamationToEdit['id_reclamation']; ?>">
            <?php endif; ?>

            <!-- ID Client masqué, rempli automatiquement depuis la session -->
            <input type="hidden" name="id_client" value="<?= $_SESSION['id_client'] ?? 1; ?>">

            <div class="mb-3">
              <label for="Categorie" class="form-label">Category :</label>
              <select name="Categorie" id="Categorie" class="form-control" required>
                <option disabled <?= !isset($reclamationToEdit['Categorie']) ? 'selected' : '' ?>>-- Select
                  Category --</option>
                <?php
                $categories = [
                  "Late Delivery",
                  "Missed Delivery",
                  "Wrong Address Delivery",
                  "Package Not Received",
                  "Damaged Package",
                  "Missing Items",
                  "Tampered Package",
                  "Wrong Item Delivered",
                  "Rude Delivery Staff",
                  "Lack of Communication",
                  "Unresponsive Support",
                  "Inaccurate Tracking Information",
                  "Overcharged",
                  "Unauthorized Payment",
                  "Refund Not Processed",
                  "Coupon/Discount Not Applied",
                  "Order Canceled Without Notice",
                  "Order Not Processed",
                  "Duplicate Order"
                ];
                foreach ($categories as $cat) {
                  $selected = (isset($reclamationToEdit['Categorie']) && $reclamationToEdit['Categorie'] === $cat) ? 'selected' : '';
                  echo "<option value=\"$cat\" $selected>$cat</option>";
                }
                ?>
              </select>
              <small id="categorieError" class="text-danger"></small>
            </div>


            <div class="mb-3">
              <label for="Description" class="form-label">Description :</label>
              <input type="text" name="Description" id="Description" class="form-control"
                value="<?= htmlspecialchars($reclamationToEdit['Description'] ?? ''); ?>">
              <small id="descriptionError" class="text-danger"></small>
            </div>
            <div class="d-flex justify-content-center mt-4">
              <button type="submit" class="btn btn-unigreen btn-lg w-50" style="height: 50px;">
                <i class="material-icons">send</i> <?= $editMode ? 'Edit' : 'Submit' ?>
              </button>
            </div>

          </form>

        </div>
      </div>
    </div>

    <!-- Table Column -->
    <div class="col-md-6">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h3 class="card-title mb-0">My Claims</h3>
          <form method="GET" action="claim.php" class="d-flex align-items-center gap-2">
            <select name="status_filter" class="form-control">
              <option value="">-- Filter by Status --</option>
              <option value="In Progress" <?= (($_GET['status_filter'] ?? '') === 'In Progress') ? 'selected' : ''; ?>>In
                Progress</option>
              <option value="Resolved" <?= (($_GET['status_filter'] ?? '') === 'Resolved') ? 'selected' : ''; ?>>Resolved
              </option>
            </select>
            <button type="submit" class="btn btn-sm btn-unigreen">
              <i class="material-icons">search</i>
            </button>
          </form>
        </div>
        <div class="card-body">
          <div class="table-container">




            <?php if (!empty($liste)): ?>
              <table>
                <tr>
                  <th>ID Claim <?= renderSortIcons('id_reclamation', $sortColumn, $sortOrder); ?></th>
                  <th>ID Client</th>
                  <th>Category <?= renderSortIcons('Categorie', $sortColumn, $sortOrder); ?></th>
                  <th>Description <?= renderSortIcons('Description', $sortColumn, $sortOrder); ?></th>
                  <th>Status</th>
                  <th>Response</th>

                  <th>Actions</th>
                </tr>
                <?php foreach ($liste as $rec): ?>
                  <tr>
                    <td><?= htmlspecialchars($rec['id_reclamation']); ?></td>
                    <td><?= htmlspecialchars($rec['id_client']); ?></td>
                    <td><?= htmlspecialchars($rec['Categorie']); ?></td>
                    <td><?= htmlspecialchars($rec['Description']); ?></td>
                    <td><?= htmlspecialchars($rec['Statut']); ?></td>
                    <td>
                      <?php if (isset($reponsesByReclamation[$rec['id_reclamation']])): ?>
                        <?= htmlspecialchars($reponsesByReclamation[$rec['id_reclamation']]['Reponse']) ?>
                      <?php else: ?>
                        <em>No Response Yet !</em>
                      <?php endif; ?>
                    </td>

                    <td>
                      <a href="claim.php?id_reclamation=<?= $rec['id_reclamation']; ?>" title="Edit">
                        <i class="material-icons" style="color: #3498db; cursor: pointer; font-size: 14px;">edit</i>
                      </a>
                      |
                      <a href="delete.php?id_reclamation=<?= $rec['id_reclamation']; ?>"
                        onclick="return confirm('Are you sure you want to delete your claim?');" title="Delete">
                        <i class="material-icons" style="color: #e74c3c; cursor: pointer; font-size: 14px;">delete</i>
                      </a>

                      <button class="btn btn-info open-thread" data-id="<?= $rec['id_reclamation'] ?>"
                        style="border-radius: 50%; padding: 4px; width: 25px; height: 25px;">
                        <i class="fas fa-comment-dots" style="font-size: 10px;"></i>
                      </button>




                    </td>
                  </tr>
                <?php endforeach; ?>
              </table>
              <!-- Pagination -->
              <nav aria-label="Page navigation">
                <ul class="pagination mt-3">
                  <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                    <li class="page-item <?= ($page == $currentPage) ? 'active' : ''; ?>">
                      <a class="page-link"
                        href="?page=<?= $page ?>&sort=<?= $sortColumn ?>&order=<?= strtolower($sortOrder) ?>&status_filter=<?= urlencode($statusFilter) ?>">
                        <?= $page ?>
                      </a>
                    </li>
                  <?php endfor; ?>
                </ul>
              </nav>
            <?php else: ?>
              <p>No claim found! <?= htmlspecialchars($_SESSION['id_client'] ?? ''); ?>.</p>
            <?php endif; ?>

          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal UNIQUE pour tous -->
  <div id="threadModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Conversation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" id="threadContent"></div>
        <div class="modal-footer">
          <form id="messageForm">
            <input type="hidden" name="id_reclamation" id="idReclamationInput">
            <textarea name="contenu" class="form-control" required></textarea>
            <button type="submit" class="btn btn-unigreen mt-2">Send</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      document.querySelectorAll('.open-thread').forEach(button => {
        button.addEventListener('click', () => {
          const idReclamation = button.dataset.id;
          document.getElementById('idReclamationInput').value = idReclamation;

          fetch(load_thread.php ? id_reclamation = ${ idReclamation })
            .then(response => response.text())
            .then(data => {
              document.getElementById('threadContent').innerHTML = data;
              new bootstrap.Modal(document.getElementById('threadModal')).show();
            });
        });
      });

      document.getElementById('messageForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        const id = document.getElementById('idReclamationInput').value;

        fetch('send_message.php', {
          method: 'POST',
          body: formData
        }).then(() => {
          return fetch(load_thread.php ? id_reclamation = ${ id });
        }).then(response => response.text())
          .then(data => {
            document.getElementById('threadContent').innerHTML = data;
            document.getElementById('messageForm').reset();
          });
      });
    });
  </script>


  <script>
    document.querySelectorAll('.sort-arrow').forEach(link => {
      link.addEventListener('click', function (e) {
        e.preventDefault();
        const url = new URL(window.location.href);
        url.searchParams.set('sort', this.dataset.sort);
        url.searchParams.set('order', this.dataset.order);

        window.history.pushState({}, '', url);

        // Rafraîchir uniquement la table (tu peux améliorer avec AJAX plus tard)
        window.location.reload();
      });
    });
  </script>
  <!-- Overlay -->
  <div id="popupOverlay"
    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999;">
  </div>

  <!-- Popup -->
  <div id="popup"
    style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:25px; border-radius:15px; box-shadow:0 0 15px rgba(0,0,0,0.3); z-index:1000; width:350px; text-align:center;">
    <p style="font-size:18px; margin-bottom:20px;">Would you like to have an Automated Description?</p>
    <button id="yesBtn" onclick="handlePopupChoice(true)"
      style="padding:10px 20px; margin:10px; background-color:#6c757d; color:white; border:none; border-radius:8px; cursor:pointer;">Yes</button>
    <button id="noBtn" onclick="handlePopupChoice(false)"
      style="padding:10px 20px; margin:10px; background-color:#6c757d; color:white; border:none; border-radius:8px; cursor:pointer;">No</button>
  </div>



  <script>
    const descriptionInput = document.getElementById("Description");
    let selectedCategory = null;

    const descriptions = {
      "Late Delivery": "Your package arrived later than expected",
      "Missed Delivery": "The delivery was missed and no attempt was made to redeliver",
      "Wrong Address Delivery": "The package was delivered to the wrong address",
      "Package Not Received": "I havent received my package yet",
      "Damaged Package": "The package arrived damaged",
      "Missing Items": "Some items were missing from the package",
      "Tampered Package": "The package seems to have been tampered with",
      "Wrong Item Delivered": "I received a different item than what I ordered",
      "Rude Delivery Staff": "The delivery staff was rude and unprofessional",
      "Lack of Communication": "There was no communication regarding the delivery",
      "Unresponsive Support": "Customer support is not responding to my queries",
      "Inaccurate Tracking Information": "The tracking information provided is inaccurate",
      "Overcharged": "I was overcharged for my order",
      "Unauthorized Payment": "A payment was made without my authorization",
      "Refund Not Processed": "My refund has not been processed yet",
      "Coupon/Discount Not Applied": "The discount code was not applied to my order",
      "Order Canceled Without Notice": "My order was canceled without any notification",
      "Order Not Processed": "My order has not been processed yet",
      "Duplicate Order": "My order was placed twice accidentally"
    };

    function showPopup(category) {
      selectedCategory = category;
      document.getElementById("popup").style.display = "block";
      document.getElementById("popupOverlay").style.display = "block";
    }

    function hidePopup() {
      document.getElementById("popup").style.display = "none";
      document.getElementById("popupOverlay").style.display = "none";
    }

    function handlePopupChoice(useAuto) {
      const yesBtn = document.getElementById("yesBtn");
      const noBtn = document.getElementById("noBtn");

      yesBtn.style.backgroundColor = "#6c757d";
      noBtn.style.backgroundColor = "#6c757d";

      if (useAuto) {
        yesBtn.style.backgroundColor = "#28a745";
      } else {
        noBtn.style.backgroundColor = "#28a745";
      }

      setTimeout(() => {
        hidePopup();
        if (useAuto && selectedCategory && descriptions[selectedCategory]) {
          animateTyping(descriptionInput, descriptions[selectedCategory]);
        } else {
          descriptionInput.value = "";
        }
      }, 400);
    }

    function animateTyping(element, text, index = 0) {
      element.value = "";
      let interval = setInterval(() => {
        if (index < text.length) {
          element.value += text.charAt(index);
          index++;
        } else {
          clearInterval(interval);
        }
      }, 40); // vitesse de frappe
    }

    // Événement de changement sur le champ catégorie
    document.getElementById("Categorie").addEventListener("change", function () {
      const selected = this.value;
      if (descriptions[selected]) {
        showPopup(selected);
      }
    });
  </script>
  <script>
    const forbiddenWords = [
      "putain", "merde", "connard", "salope", "enculé", "bordel",
      "fuck", "shit", "bitch", "asshole", "bastard", "zebi", "asba",
      "3asba", "nikomek", "tahan", "ta7an", "mnayek", "fucking",
      "fucker", "zab", "kahba", "zokomek", "tetkouhb", "tetkouhbou",
      "nyak", "puta", "pendejo", "hijo de puta",
      "culero", "pendeja", "miboun", "mbachel"
    ];

    const descInput = document.getElementById('Description');
    const errorMsg = document.getElementById('descriptionError');
    const form = descInput.closest('form');

    // Fonction pour simplifier les mots (réduit les répétitions de lettres)
    function simplify(text) {
      return text.toLowerCase().replace(/(.)\1{1,}/g, '$1'); // ex: fuuuuck => fuuck => fuck
    }

    // Fonction principale de détection + masquage
    function maskProfanity(text) {
      const lowerOriginal = text.toLowerCase();
      let result = text;

      forbiddenWords.forEach(word => {
        // Construire une expression qui tolère les lettres répétées : f+u+c+k+
        const flexiblePattern = word
          .split('')
          .map(letter => ${ letter } +)
          .join('');
        const regex = new RegExp(flexiblePattern, 'gi');

        result = result.replace(regex, match => '*'.repeat(match.length));

        // En plus, chercher même dans les mots composés, en mode "simplifié"
        const simplified = simplify(lowerOriginal);
        if (simplified.includes(word)) {
          const originalIndex = simplified.indexOf(word);
          const before = result.substring(0, originalIndex);
          const stars = '*'.repeat(word.length);
          const after = result.substring(originalIndex + word.length);
          result = before + stars + after;
        }
      });

      return result;
    }

    descInput.addEventListener('input', () => {
      const original = descInput.value;
      const masked = maskProfanity(original);
      if (original !== masked) {
        descInput.value = masked;
        errorMsg.textContent = "⚠️ Inappropriate language detected and masked.";
      } else {
        errorMsg.textContent = "";
      }
    });

    form.addEventListener('submit', function (e) {
      if (descInput.value.includes('*')) {
        e.preventDefault();
        errorMsg.textContent = "Please remove inappropriate language before submitting.";
      }
    });
  </script>








  <script>
    function validateForm() {
      let isValid = true;

      const categorie = document.getElementById('Categorie').value.trim();
      const description = document.getElementById('Description').value.trim();

      document.getElementById('categorieError').textContent = '';
      document.getElementById('descriptionError').textContent = '';

      if (categorie === '') {
        document.getElementById('categorieError').textContent = 'Veuillez renseigner ce champ.';
        isValid = false;
      } else if (!/^[a-zA-ZÀ-ÿ\s]+$/.test(categorie)) {
        document.getElementById('categorieError').textContent = 'La catégorie doit être alphabétique.';
        isValid = false;
      }

      if (description === '') {
        document.getElementById('descriptionError').textContent = 'Veuillez renseigner ce champ.';
        isValid = false;
      } else if (!/^[a-zA-ZÀ-ÿ\s]+$/.test(description)) {
        document.getElementById('descriptionError').textContent = 'La description doit être alphabétique.';
        isValid = false;
      }

      return isValid;
    }
  </script>


  <!-- Footer Starts Here -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-3 footer-item">
          <h4>LogiXpress</h4>
          <p>Vivamus tellus mi. Nulla ne cursus elit,vulputate. Sed ne cursus augue hasellus lacinia sapien vitae.</p>
          <ul class="social-icons">
            <li><a rel="nofollow" href="#" target="_blank"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
          </ul>
        </div>
        <div class="col-md-3 footer-item">
          <h4>Useful Links</h4>
          <ul class="menu-list">
            <li><a href="#">Vivamus ut tellus mi</a></li>
            <li><a href="#">Nulla nec cursus elit</a></li>
            <li><a href="#">Vulputate sed nec</a></li>
            <li><a href="#">Cursus augue hasellus</a></li>
            <li><a href="#">Lacinia ac sapien</a></li>
          </ul>
        </div>
        <div class="col-md-3 footer-item">
          <h4>Additional Pages</h4>
          <ul class="menu-list">
            <li><a href="#">Products</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">Terms</a></li>
          </ul>
        </div>
        <div class="col-md-3 footer-item last-item">
          <h4>Contact Us</h4>
          <div class="contact-form">
            <form id="contact footer-contact" action="" method="post">
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <fieldset>
                    <input name="name" type="text" class="form-control" id="name" placeholder="Full Name" required="">
                  </fieldset>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <fieldset>
                    <input name="email" type="text" class="form-control" id="email" pattern="[^ @]*@[^ @]*"
                      placeholder="E-Mail Address" required="">
                  </fieldset>
                </div>
                <div class="col-lg-12">
                  <fieldset>
                    <textarea name="message" rows="6" class="form-control" id="message" placeholder="Your Message"
                      required=""></textarea>
                  </fieldset>
                </div>
                <div class="col-lg-12">
                  <fieldset>
                    <button type="submit" id="form-submit" class="filled-button">Send Message</button>
                  </fieldset>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <div class="sub-footer">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <p>
            Copyright © 2020 Company Name
            - Template by: <a href="https://www.phpjabbers.com/">PHPJabbers.com</a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript -->
  <script src="../../../Public/vendor/jquery/jquery.min.js"></script>
  <script src="../../../Public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Additional Scripts -->
  <script src="../../../Public/assets/js/custom.js"></script>
  <script src="../../../Public/assets/js/owl.js"></script>
  <script src="../../../Public/assets/js/slick.js"></script>
  <script src="../../../Public/assets/js/accordions.js"></script>

  <script language="text/Javascript">
    cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
    function clearField(t) { //declaring the array outside of the
      if (!cleared[t.id]) { // function makes it static and global
        cleared[t.id] = 1; // you could use true and false, but that's more typing
        t.value = ''; // with more chance of typos
        t.style.color = '#fff';
      }
    }
  </script>

</body>

</html>