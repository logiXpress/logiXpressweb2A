<!--
=========================================================
* Material Dashboard 2 PRO - v3.1.0
=========================================================

* Product Page:  https://www.creative-tim.com/product/material-dashboard-pro 
* Copyright 2024 Creative Tim (https://www.creative-tim.com)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->


<?php

require "../../../controller/candidatC.php"; // Changed backslashes to forward slashes
$candidatC= new CandidatC();
$tab=$candidatC->listeCandidat();



?>

<!DOCTYPE html>
<html lang="en">
<?php require_once '../includes/header.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<style>
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
<?php require_once '../includes/configurator.php'; ?>
<?php require_once '../includes/sidenav.php'; ?>
    <div class="main-panel">
    <?php require_once '../includes/navbar.php'; ?>
    <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-unigreen card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">assignment</i>
                  </div>
                  <h4 class="card-title">List of Candidates</h4>
                </div>
                <!-- ... keep the header part the same until the card-body div ... -->
<div class="card-body">
    <div class="toolbar">
        <!--        Here you can write extra buttons/actions for the toolbar              -->
    </div>
    <div class="material-datatables">
    
        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
            <thead>
                <tr>
                    <th><h6 style="text-align: center; ">Name</h6></th>
                    <th><h6 style="text-align: center; ">Last Name</h6></th>
                    <th><h6 style="text-align: center; ">Email</h6></th>
                    <th><h6 style="text-align: center; ">Telephone</h6></th>
                    <th><h6 style="text-align: center; ">Application Date</h6></th>
                    <th class="disabled-sorting text-right"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $uploadDir = '../../Acceuil/entretienRH/';
                foreach ($tab as $candidat) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($candidat["nom"]) . "</td>";
                    echo "<td>" . htmlspecialchars($candidat["prenom"]) . "</td>";
                    echo "<td>" . htmlspecialchars($candidat["email"]) . "</td>";
                    echo "<td>" . htmlspecialchars($candidat["telephone"]) . "</td>";
                    echo "<td>" . htmlspecialchars($candidat["Date_Candidature"]) . "</td>";
                    echo "<td class='text-right'>";
                    
                    // View CV Button
                    $cvPath = !empty($candidat["CV"]) ? $uploadDir . htmlspecialchars($candidat["CV"]) : '#';
                    echo "<a href='" . $cvPath . "' target='_blank' class='btn btn-info btn-round' style='margin-right:5px;'" . (empty($candidat["CV"]) ? ' disabled' : '') . ">
                            Check CV
                          </a>";
                    
                    // Schedule Button
                    echo "<form action='forumAjouterEntretient.php' method='post' style='display:inline;'>
                            <input type='hidden' name='idCandidat' value='" . htmlspecialchars($candidat["id_candidat"]) . "'>
                            <button type='submit' class='btn btn-success btn-round'>
                                <i class='material-icons'></i>schedule
                            </button>
                          </form>";
                    
                    echo "</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <br><button onclick="exportPDF()" class="btn btn-round btn-info">Export PDF</button>
    </div>
</div>
                <!-- end content-->
              </div>
              <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
          </div>
          <!-- end row -->
        </div>
      </div>



      <?php require_once '../includes/footer.php'; ?>
      
      <script src="../../../Public/assets/js/plugins/dragula/dragula.min.js"></script>
      <script src="../../../Public/assets/js/plugins/jkanban/jkanban.min.js"></script>
  <!--   Core JS Files   -->
  <script src="../../../assets/js/core/jquery.min.js"></script>
  <script src="../../../assets/js/core/popper.min.js"></script>
  <script src="../../../assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="../../../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
  <script src="../../../assets/js/plugins/jquery.dataTables.min.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../../../assets/js/material-dashboard.min6c54.js?v=2.2.2" type="text/javascript"></script>
  <!-- Material Dashboard DEMO methods, don't include it in your project! -->
  <script>
    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');

        $sidebar_img_container = $sidebar.find('.sidebar-background');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');

        window_width = $(window).width();

        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

        if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
          if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
            $('.fixed-plugin .dropdown').addClass('open');
          }

        }

        $('.fixed-plugin a').click(function(event) {
          // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });

        $('.fixed-plugin .active-color span').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-color', new_color);
          }

          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data-color', new_color);
          }
        });

        $('.fixed-plugin .background-color .badge').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('background-color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-background-color', new_color);
          }
        });

        $('.fixed-plugin .img-holder').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).parent('li').siblings().removeClass('active');
          $(this).parent('li').addClass('active');


          var new_image = $(this).find("img").attr('src');

          if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            $sidebar_img_container.fadeOut('fast', function() {
              $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
              $sidebar_img_container.fadeIn('fast');
            });
          }

          if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $full_page_background.fadeOut('fast', function() {
              $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
              $full_page_background.fadeIn('fast');
            });
          }

          if ($('.switch-sidebar-image input:checked').length == 0) {
            var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
          }
        });

        $('.switch-sidebar-image input').change(function() {
          $full_page_background = $('.full-page-background');

          $input = $(this);

          if ($input.is(':checked')) {
            if ($sidebar_img_container.length != 0) {
              $sidebar_img_container.fadeIn('fast');
              $sidebar.attr('data-image', '#');
            }

            if ($full_page_background.length != 0) {
              $full_page_background.fadeIn('fast');
              $full_page.attr('data-image', '#');
            }

            background_image = true;
          } else {
            if ($sidebar_img_container.length != 0) {
              $sidebar.removeAttr('data-image');
              $sidebar_img_container.fadeOut('fast');
            }

            if ($full_page_background.length != 0) {
              $full_page.removeAttr('data-image', '#');
              $full_page_background.fadeOut('fast');
            }

            background_image = false;
          }
        });

        $('.switch-sidebar-mini input').change(function() {
          $body = $('body');

          $input = $(this);

          if (md.misc.sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            md.misc.sidebar_mini_active = false;

            if ($(".sidebar").length != 0) {
              var ps = new PerfectScrollbar('.sidebar');
            }
            if ($(".sidebar-wrapper").length != 0) {
              var ps1 = new PerfectScrollbar('.sidebar-wrapper');
            }
            if ($(".main-panel").length != 0) {
              var ps2 = new PerfectScrollbar('.main-panel');
            }
            if ($(".main").length != 0) {
              var ps3 = new PerfectScrollbar('main');
            }

          } else {

            if ($(".sidebar").length != 0) {
              var ps = new PerfectScrollbar('.sidebar');
              ps.destroy();
            }
            if ($(".sidebar-wrapper").length != 0) {
              var ps1 = new PerfectScrollbar('.sidebar-wrapper');
              ps1.destroy();
            }
            if ($(".main-panel").length != 0) {
              var ps2 = new PerfectScrollbar('.main-panel');
              ps2.destroy();
            }
            if ($(".main").length != 0) {
              var ps3 = new PerfectScrollbar('main');
              ps3.destroy();
            }


            setTimeout(function() {
              $('body').addClass('sidebar-mini');

              md.misc.sidebar_mini_active = true;
            }, 300);
          }

          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);

        });
      });
    });
  </script>
  <!-- Sharrre libray -->
  <script src="../../../assets/demo/jquery.sharrre.js"></script>
  <script>
    $(document).ready(function() {


      $('#facebook').sharrre({
        share: {
          facebook: true
        },
        enableHover: false,
        enableTracking: false,
        enableCounter: false,
        click: function(api, options) {
          api.simulateClick();
          api.openPopup('facebook');
        },
        template: '<i class="fab fa-facebook-f"></i> Facebook',
        url: 'https://demos.creative-tim.com/material-dashboard-pro/examples/dashboard.html'
      });

      $('#google').sharrre({
        share: {
          googlePlus: true
        },
        enableCounter: false,
        enableHover: false,
        enableTracking: true,
        click: function(api, options) {
          api.simulateClick();
          api.openPopup('googlePlus');
        },
        template: '<i class="fab fa-google-plus"></i> Google',
        url: 'https://demos.creative-tim.com/material-dashboard-pro/examples/dashboard.html'
      });

      $('#twitter').sharrre({
        share: {
          twitter: true
        },
        enableHover: false,
        enableTracking: false,
        enableCounter: false,
        buttons: {
          twitter: {
            via: 'CreativeTim'
          }
        },
        click: function(api, options) {
          api.simulateClick();
          api.openPopup('twitter');
        },
        template: '<i class="fab fa-twitter"></i> Twitter',
        url: 'https://demos.creative-tim.com/material-dashboard-pro/examples/dashboard.html'
      });


      // Facebook Pixel Code Don't Delete
      ! function(f, b, e, v, n, t, s) {
        if (f.fbq) return;
        n = f.fbq = function() {
          n.callMethod ?
            n.callMethod.apply(n, arguments) : n.queue.push(arguments)
        };
        if (!f._fbq) f._fbq = n;
        n.push = n;
        n.loaded = !0;
        n.version = '2.0';
        n.queue = [];
        t = b.createElement(e);
        t.async = !0;
        t.src = v;
        s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s)
      }(window,
        document, 'script', '../../../../connect.facebook.net/en_US/fbevents.js');

      try {
        fbq('init', '111649226022273');
        fbq('track', "PageView");

      } catch (err) {
        console.log('Facebook Track Error:', err);
      }

    });
  </script>
  <script>
    // Facebook Pixel Code Don't Delete
    ! function(f, b, e, v, n, t, s) {
      if (f.fbq) return;
      n = f.fbq = function() {
        n.callMethod ?
          n.callMethod.apply(n, arguments) : n.queue.push(arguments)
      };
      if (!f._fbq) f._fbq = n;
      n.push = n;
      n.loaded = !0;
      n.version = '2.0';
      n.queue = [];
      t = b.createElement(e);
      t.async = !0;
      t.src = v;
      s = b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t, s)
    }(window,
      document, 'script', '../../../../connect.facebook.net/en_US/fbevents.js');

    try {
      fbq('init', '111649226022273');
      fbq('track', "PageView");

    } catch (err) {
      console.log('Facebook Track Error:', err);
    }
  </script>
  <noscript>
    <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=111649226022273&amp;ev=PageView&amp;noscript=1" />
  </noscript>
  <script>
$(document).ready(function() {
    // Check if DataTable is already initialized
    if (!$.fn.DataTable.isDataTable('#datatables')) {
        $('#datatables').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            },
            columnDefs: [{
                targets: -1,
                orderable: false
            }]
        });

        // Add custom styling to the search box
        $('.dataTables_filter input').addClass('form-control');
        $('.dataTables_length select').addClass('form-control');
    }
});
</script>
<script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"926215487d4a5bca","version":"2025.3.0","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"1b7cbb72744b40c580f8633c6b62637e","b":1}' crossorigin="anonymous"></script>

<script>
    if (document.getElementById('TableEntretien')) {
      const dataTableSearch = new simpleDatatables.DataTable("#TableEntretien", {
        searchable: true,
        fixedHeight: false,
        
      });

      document.querySelectorAll(".export").forEach(function(el) {
        el.addEventListener("click", function(e) {
          var type = el.dataset.type;

          var data = {
            type: type,
            filename: "Interviews-" + type,
          };

          if (type === "csv") {
            data.columnDelimiter = " | ";
          }

          dataTableSearch.export(data);
        });
      });
    };
  </script>

  <script>
    if (document.getElementById('TableEntretien')) {
      const dataTableSearch = new simpleDatatables.DataTable("#TableEntretien", {
        searchable: true,
        fixedHeight: false,
        
      });

      document.querySelectorAll(".export").forEach(function(el) {
        el.addEventListener("click", function(e) {
          var type = el.dataset.type;

          var data = {
            type: type,
            filename: "Interviews-" + type,
          };

          if (type === "csv") {
            data.columnDelimiter = " | ";
          }

          dataTableSearch.export(data);
        });
      });
    };
  </script>
  <!-- Kanban scripts -->
  <script src="../../../Public/assets/js/plugins/dragula/dragula.min.js"></script>
  <script src="../../../Public/assets/js/plugins/jkanban/jkanban.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>











<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
<script src="exportPDF.js"></script>
</body>


<!-- Mirrored from demos.creative-tim.com/material-dashboard-pro-bs4/examples/tables/datatables.net.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 25 Mar 2025 23:11:05 GMT -->
</html>