<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../../../Public/assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../../../Public/assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Material Dashboard PRO by Creative Tim
  </title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <!-- Extra details for Live View on GitHub Pages -->
  <!-- Canonical SEO -->
  <link rel="canonical" href="https://www.creative-tim.com/product/material-dashboard-pro" />
  <!--  Social tags      -->
  <meta name="keywords" content="creative tim, html dashboard, html css dashboard, web dashboard, bootstrap 4 dashboard, bootstrap 4, css3 dashboard, bootstrap 4 admin, material dashboard bootstrap 4 dashboard, frontend, responsive bootstrap 4 dashboard, material design, material dashboard bootstrap 4 dashboard">
  <meta name="description" content="Material Dashboard PRO is a Premium Material Bootstrap 4 Admin with a fresh, new design inspired by Google's Material Design.">
  <!-- Schema.org markup for Google+ -->
  <meta itemprop="name" content="Material Dashboard PRO by Creative Tim">
  <meta itemprop="description" content="Material Dashboard PRO is a Premium Material Bootstrap 4 Admin with a fresh, new design inspired by Google's Material Design.">
  <meta itemprop="image" content="../../../s3.amazonaws.com/creativetim_bucket/products/51/original/opt_mdp_thumbnail.jpg">
  <!-- Twitter Card data -->
  <meta name="twitter:card" content="product">
  <meta name="twitter:site" content="@creativetim">
  <meta name="twitter:title" content="Material Dashboard PRO by Creative Tim">
  <meta name="twitter:description" content="Material Dashboard PRO is a Premium Material Bootstrap 4 Admin with a fresh, new design inspired by Google's Material Design.">
  <meta name="twitter:creator" content="@creativetim">
  <meta name="twitter:image" content="../../../s3.amazonaws.com/creativetim_bucket/products/51/original/opt_mdp_thumbnail.jpg">
  <!-- Open Graph data -->
  <meta property="fb:app_id" content="655968634437471">
  <meta property="og:title" content="Material Dashboard PRO by Creative Tim" />
  <meta property="og:type" content="article" />
  <meta property="og:url" content="http://demos.creative-tim.com/material-dashboard-pro/examples/dashboard.html" />
  <meta property="og:image" content="../../../s3.amazonaws.com/creativetim_bucket/products/51/original/opt_mdp_thumbnail.jpg" />
  <meta property="og:description" content="Material Dashboard PRO is a Premium Material Bootstrap 4 Admin with a fresh, new design inspired by Google's Material Design." />
  <meta property="og:site_name" content="Creative Tim" />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- CSS Files -->
  <link href="../../../public/assets/css/material-dashboard.min6c54.css?v=2.2.2" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet.locatecontrol/dist/L.Control.Locate.min.css" />
  <script>
    $(document).ready(function() {
      $(".open-modal").click(function() {
        var livraisonId = $(this).data("id"); // Récupérer l'ID de la livraison
        $.ajax({
          url: "get_livraison.php", // Fichier PHP qui retourne les données
          type: "GET",
          data: {
            id_livraison: livraisonId
          },
          success: function(response) {
            var data = JSON.parse(response); // Convertir la réponse JSON
            $("#exampleModal input[name='id_livraison']").val(data.id_livraison);
            $("#exampleModal textarea[name='adresse_livraison']").val(data.Adresse_livraison);
            $("#exampleModal input[name='etat']").val(data.Etat);
            $("#exampleModal input[name='montant']").val(data.Montant);
            $("#exampleModal input[name='statut_paiement']").val(data.Statut_paiement);
            $("#exampleModal select[name='mode_paiement']").val(data.Mode_paiement);
            $("#exampleModal textarea[name='description']").val(data.Description);
          }
        });
      });
    });
  </script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    (function(w, d, s, l, i) {
      w[l] = w[l] || [];
      w[l].push({
        'gtm.start': new Date().getTime(),
        event: 'gtm.js'
      });
      var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != 'dataLayer' ? '&l=' + l : '';
      j.async = true;
      j.src =
        '../../../../www.googletagmanager.com/gtm5445.html?id=' + i + dl;
      f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-NKDMSK6');
  </script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    $(document).ready(function() {
      $(".open-modal").click(function() {
        var livraisonId = $(this).data("id"); // Récupérer l'ID de la livraison
        $.ajax({
          url: "get_livraison.php", // Fichier PHP qui retourne les données
          type: "GET",
          data: {
            id_livraison: livraisonId
          },
          success: function(response) {
            var data = JSON.parse(response); // Convertir la réponse JSON
            $("#exampleModal input[name='id_livraison']").val(data.id_livraison);
            $("#exampleModal textarea[name='adresse_livraison']").val(data.Adresse_livraison);
            $("#exampleModal input[name='etat']").val(data.Etat);
            $("#exampleModal input[name='montant']").val(data.Montant);
            $("#exampleModal input[name='statut_paiement']").val(data.Statut_paiement);
            $("#exampleModal select[name='mode_paiement']").val(data.Mode_paiement);
            $("#exampleModal textarea[name='description']").val(data.Description);
          }
        });
      });
    });
  </script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    $(document).ready(function() {
      $(".clickable-row").on("click", function() {
        // Get data attributes from the clicked row
        var id = $(this).data("id");
        var adresse = $(this).data("adresse");
        var etat = $(this).data("etat");
        var montant = $(this).data("montant");
        var statut = $(this).data("statut");
        var mode = $(this).data("mode");
        var description = $(this).data("description");

        // Set the modal fields
        $("#livraison-id").text(id);
        $("#livraison-adresse").text(adresse);
        $("#livraison-etat").text(etat);
        $("#livraison-montant").text(montant);
        $("#livraison-statut").text(statut);
        $("#livraison-mode").text(mode);
        $("#livraison-description").val(description);
      });
    });
  </script>


<!--entretient rh script--> 


</head>