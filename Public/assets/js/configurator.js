// === Utility: Save and Get from LocalStorage ===
function saveToStorage(key, value) {
    localStorage.setItem(key, value);
  }
  
  function getFromStorage(key) {
    return localStorage.getItem(key);
  }
  
  // === Configurator Button Color Setter ===
  function setConfiguratorButtonColor(color) {
    const button = document.querySelector(".fixed-plugin-button");
  
    if (button) {
      button.classList.remove(
        "bg-gradient-primary", "bg-gradient-dark", "bg-gradient-info",
        "bg-gradient-success", "bg-gradient-warning", "bg-gradient-danger"
      );
  
      button.classList.add(`bg-gradient-${color}`);
      saveToStorage("configButtonColor", color);
    }
  
    document.querySelectorAll(".badge.filter").forEach(badge => {
      badge.classList.toggle("active", badge.getAttribute("data-color") === color);
    });
  }
  
  // === Sidebar Type Setter ===
  function sidebarType(el) {
    const sidenav = document.getElementById('sidenav-main');
    const type = el.getAttribute('data-class');
  
    if (sidenav) {
      sidenav.classList.remove('bg-gradient-dark', 'bg-transparent', 'bg-white');
      sidenav.classList.add(type);
      saveToStorage("sidebarType", type);
    }
  
    // Update button active state
    document.querySelectorAll('[onclick^="sidebarType"]').forEach(btn => {
      btn.classList.remove('active');
    });
    el.classList.add('active');
  }
  
  // === Navbar Fixed ===
  function navbarFixed(checkbox) {
    const navbar = document.querySelector('nav.navbar-main');
    const isFixed = checkbox.checked;
  
    if (navbar) {
      navbar.classList.toggle('position-sticky', isFixed);
      saveToStorage("navbarFixed", isFixed ? "true" : "false");
    }
  }
  
  // === Mini Sidebar Toggle ===
  function navbarMinimize(checkbox) {
    const body = document.body;
    const isMini = checkbox.checked;
  
    body.classList.toggle("g-sidenav-hidden", isMini);
    saveToStorage("miniSidebar", isMini ? "true" : "false");
  }
  
  // === Dark Mode Toggle ===
  function darkMode(checkbox) {
    const body = document.body;
    const isDark = checkbox.checked;
  
    body.classList.toggle("dark-version", isDark);
    saveToStorage("darkMode", isDark ? "true" : "false");
  }
  
  // === Load Settings on Page Load ===
  window.addEventListener("DOMContentLoaded", () => {
    // Restore Configurator Button Color
    const savedColor = getFromStorage("configButtonColor");
    if (savedColor) setConfiguratorButtonColor(savedColor);
  
    // Restore Sidebar Type
    const savedSidebar = getFromStorage("sidebarType");
    if (savedSidebar) {
      const btn = document.querySelector(`[data-class="${savedSidebar}"]`);
      if (btn) sidebarType(btn);
    }
  
    // Restore Navbar Fixed
    const savedNavbar = getFromStorage("navbarFixed");
    if (savedNavbar === "true") {
      document.getElementById("navbarFixed").checked = true;
      navbarFixed(document.getElementById("navbarFixed"));
    }
  
    // Restore Mini Sidebar
    const savedMini = getFromStorage("miniSidebar");
    if (savedMini === "true") {
      document.getElementById("navbarMinimize").checked = true;
      navbarMinimize(document.getElementById("navbarMinimize"));
    }
  
    // Restore Dark Mode
    const savedDark = getFromStorage("darkMode");
    if (savedDark === "true") {
      document.getElementById("dark-version").checked = true;
      darkMode(document.getElementById("dark-version"));
    }
  });
  