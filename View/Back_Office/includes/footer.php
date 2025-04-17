<footer>
  <!--   Core JS Files   -->
  <script src="../../Public/assets/js/core/popper.min.js"></script>
  <script src="../../Public/assets/js/core/bootstrap.min.js"></script>
  <script src="../../Public/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../../Public/assets/js/plugins/smooth-scrollbar.min.js"></script>
  <!-- Kanban scripts -->
  <script src="../../Public/assets/js/plugins/dragula/dragula.min.js"></script>
  <script src="../../Public/assets/js/plugins/jkanban/jkanban.min.js"></script>
  <script src="../../Public/assets/js/plugins/chartjs.min.js"></script>
  <script src="../../Public/assets/js/plugins/world.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="../../Public/assets/buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../../public/assets/js/material-dashboard.mine63c.js?v=3.1.0"></script>
  <script
      defer
      src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
      integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
      data-cf-beacon='{"rayId":"9284c5f32fd10e85","version":"2025.1.0","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"1b7cbb72744b40c580f8633c6b62637e","b":1}'
      crossorigin="anonymous"
    ></script>
    <script src="/Project/Public/assets/js/configurator.js"></script>

<script>
    (function(a, s, y, n, c, h, i, d, e) {
      s.className += ' ' + y;
      h.start = 1 * new Date;
      h.end = i = function() {
        s.className = s.className.replace(RegExp(' ?' + y), '')
      };
      (a[n] = a[n] || []).hide = h;
      setTimeout(function() {
        i();
        h.end = null
      }, c);
      h.timeout = c;
    })(window, document.documentElement, 'async-hide', 'dataLayer', 4000, {
      'GTM-K9BGS8K': true
    });
  </script>

</footer>