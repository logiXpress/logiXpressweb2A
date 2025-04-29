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
require "../../../controller/entretienC.php";
$entretienC = new entretienC();

// Function to fetch initial interview data
function fetchInterviews($entretienC) {
    $tab = $entretienC->listeEntretien();
    $interviews = [];
    foreach ($tab as $entretien) {
        $interviews[] = [
            'title' => $entretien['nom'] . ' ' . $entretien['prenom'],
            'start' => $entretien['date_entretien'],
            'className' => 'bg-gradient-info'
            
        ];
    }
    return $interviews;
}

// Function to get upcoming interviews
function getUpcomingInterviews($entretienC, $limit = 5) {
    $tab = $entretienC->listeEntretien();
    $upcomingInterviews = [];
    $currentDateTime = new DateTime();

    foreach ($tab as $entretien) {
        $interviewDateTime = new DateTime($entretien['date_entretien']);
        if ($interviewDateTime > $currentDateTime) {
            $upcomingInterviews[] = $entretien;
        }
    }

    // Sort by date and limit the results
    usort($upcomingInterviews, function($a, $b) {
        return strtotime($a['date_entretien']) - strtotime($b['date_entretien']);
    });

    return array_slice($upcomingInterviews, 0, $limit); // Return limited number of upcoming interviews
}

// Function to count interviews by status
function countInterviewsByStatus($entretienC) {
  $tab = $entretienC->listeEntretien();
  $statusCounts = [
      'planifié' => 0,
      'effectué' => 0,
      'annulé' => 0
  ];

  foreach ($tab as $entretien) {
      $status = strtolower($entretien['Statut']);
      if (array_key_exists($status, $statusCounts)) {
          $statusCounts[$status]++;
      }
  }

  error_log("Status Counts: " . print_r($statusCounts, true));
  return $statusCounts;
}



// Fetch initial interviews
$initialInterviews = fetchInterviews($entretienC);

// Fetch upcoming interviews
$upcomingInterviews = getUpcomingInterviews($entretienC);

// Fetch status counts
$statusCounts = countInterviewsByStatus($entretienC);
$totalInterviews = array_sum($statusCounts);

// Calculate percentages
$planifiePercent = $totalInterviews > 0 ? round(($statusCounts['planifié'] / $totalInterviews) * 100) : 0;
$effectuePercent = $totalInterviews > 0 ? round(($statusCounts['effectué'] / $totalInterviews) * 100) : 0;
$annulePercent = $totalInterviews > 0 ? round(($statusCounts['annulé'] / $totalInterviews) * 100) : 0;

// Log percentages for debugging
error_log("Total Interviews: $totalInterviews");
error_log("Percentages - Planifié: $planifiePercent, Effectué: $effectuePercent, Annulé: $annulePercent");

?>

<!DOCTYPE html>
<html lang="en">
<?php require_once '../includes/header.php'; ?>
<!-- FullCalendar CSS and JS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

<body class="">
<?php require_once '../includes/configurator.php'; ?>
<?php require_once '../includes/sidenav.php'; ?>
    <div class="main-panel">
    <?php require_once '../includes/navbar.php'; ?>
    <div class="content">
        <div class="container-fluid">
        <div class="row">
    <div class="col-lg-9 col-md-12">
        <div class="card">
            <div class="card-header card-header-unigreen card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">calendar_today</i>
                </div>
                <h4 class="card-title">Interviews calendar</h4>
            </div>
            <div class="card-body">
                <div class="toolbar">
                    <!-- Here you can write extra buttons/actions for the toolbar -->
                </div>
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <!-- Next Events Column -->
<div class="col-lg-3 col-md-12">
    <div class="card next-events-card">
        <div class="card-header card-header-unigreen card-header-icon">
            <div class="card-icon">
                <i class="material-icons">notifications</i>
            </div>
            <h4 class="card-title">Next Interviews</h4>
        </div>
        <div class="card-body border-radius-lg p-3">
            <?php if ($upcomingInterviews): ?>
                <?php foreach ($upcomingInterviews as $interview): ?>
                    <div class="d-flex mt-4 ">
                        <div class="icon icon-shape bg-gradient-dark shadow text-center">
                            <i class="material-icons">notifications</i>
                        </div>
                        <div class="ms-5">
                            <div class="numbers">
                                <h6 class="mb-1 text-dark text-sm">Interview with <?php echo htmlspecialchars($interview['nom'] . ' ' . $interview['prenom']); ?></h6>
                                <span class="text-sm"><?php echo date('d F Y, \a\t H:i A', strtotime($interview['date_entretien'])); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="d-flex">
                    
                    <div class="ms-5">
                        <div class="numbers">
                            <h6 class="mb-1 text-dark text-sm">No upcoming interviews</h6>
                        </div>
                    </div>
            </div>
                <?php endif; ?>
                        </div>
                    </div>
                <!-- Pie Chart Section -->
                <div class="card card-chart">
            <div class="card-header card-header-unigreen card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">pie_chart</i>
                </div>
                <h4 class="card-title">Pie Chart</h4>
            </div>
            <div class="card-body">
                <div id="chartPreferences" class="ct-chart"></div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="card-category">Legend</h6>
                    </div>
                    <div class="col-md-12">
                    <i class="fa fa-circle text-info"></i> Planifié
                    <i class="fa fa-circle text-warning"></i> Effectué
                    <i class="fa fa-circle text-danger"></i> Annulé
                    </div>
                    </div>
                </div>
            </div>
        
                
                
                  </div>
            </div>
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
  <<!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
  <script src="../../../assets/js/plugins/jquery.dataTables.min.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../../../assets/js/material-dashboard.min6c54.js?v=2.2.2" type="text/javascript"></script>
  <!-- Material Dashboard DEMO methods, don't include it in your project! -->
  
  <!-- FullCalendar JS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<!-- Initialize FullCalendar -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: <?php echo json_encode($initialInterviews); ?>,
        eventClick: function(info) {
            alert('Interview: ' + info.event.title + '\nDate: ' + info.event.start.toLocaleString());
        },
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        }
    });
    calendar.render();
});
</script>
  

<script src="../../../Public/assets/js/plugins/chartist.min.js"></script>

<script>
// Initialize Pie Chart with dynamic data
$(document).ready(function() {
    var planifiePercent = <?php echo $planifiePercent; ?>;
    
    var annulePercent = <?php echo $annulePercent; ?>;
    var effectuePercent = <?php echo $effectuePercent; ?>;

    // If all percentages are 0, show a placeholder chart
    if (planifiePercent === 0  && annulePercent === 0 && effectuePercent === 0) {
        var dataPreferences = {
            labels: ['No Data'],
            series: [100] // Single segment for placeholder
        };
    } else {
        // Build labels and series, excluding 0% values
        var labels = [];
        var series = [];

        if (planifiePercent > 0) {
            labels.push('' + planifiePercent + '%');
            series.push(planifiePercent);
        }
        
        if (annulePercent > 0) {
            labels.push('' + annulePercent + '%');
            series.push(annulePercent);
        }
        if (effectuePercent > 0) {
            labels.push(' ' + effectuePercent + '%');
            series.push(effectuePercent);
        }

        var dataPreferences = {
            labels: labels,
            series: series
        };
    }

    var optionsPreferences = {
        height: '230px',
        labelInterpolationFnc: function(value) {
            if (value === 'No Data') {
                return 'No Data';
            }
            return value; // Display the full label (e.g., "Planifié 25%")
        }
    };

    new Chartist.Pie('#chartPreferences', dataPreferences, optionsPreferences);
});
</script>
  
  
  
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

</body>


<!-- Mirrored from demos.creative-tim.com/material-dashboard-pro-bs4/examples/tables/datatables.net.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 25 Mar 2025 23:11:05 GMT -->
</html>