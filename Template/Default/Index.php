<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?= $pageTitle ?> - Mini-Ecommerce-ACL</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link href="/Styles/template.css" rel="stylesheet">
  <link href="/Styles/components.css" rel="stylesheet">
</head>
<body>
  <!-- Navbar mejorado -->
  <nav class="navbar navbar-expand-lg navbar-dark" id="mainNavbar">
    <div class="container">
      <a href="/Dashboard/Index" class="navbar-brand d-flex align-items-center">
        <img src="/Images/LogoNuevo.jpg" alt="Logo" class="logo-navbar">
        <span>Mini-Ecommerce-ACL</span>
      </a>
      
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-center">
          <!-- Selector de tema -->
          <li class="nav-item dropdown me-3">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="themeDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-palette me-1"></i> 
              <span>Tema</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item d-flex align-items-center" href="#" onclick="setTheme('dark')">
                  <i class="bi bi-moon-fill me-2"></i> 
                  <span>Oscuro</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item d-flex align-items-center" href="#" onclick="setTheme('light')">
                  <i class="bi bi-sun-fill me-2"></i> 
                  <span>Claro</span>
                </a>
              </li>
            </ul>
          </li>
          
          <?php if(isset($_SESSION['usuario'])): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle me-1"></i> 
                <span>
                  <?php 
                    if(isset($_SESSION['usuario']->NombreUsuario)) {
                      echo htmlspecialchars($_SESSION['usuario']->NombreUsuario);
                    } elseif(isset($_SESSION['nombre_usuario'])) {
                      echo htmlspecialchars($_SESSION['nombre_usuario']);
                    }
                  ?>
                </span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li>
                  <a class="dropdown-item d-flex align-items-center" href="/Usuario/Logout">
                    <i class="bi bi-box-arrow-right me-2"></i> 
                    <span>Cerrar Sesión</span>
                  </a>
                </li>
              </ul>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Contenido dinámico -->
  <main class="container mt-4 flex-grow-1">
    <?= $content ?>
  </main>

  <!-- Footer fijo -->
  <footer>
    <div class="container">
      <p>&copy; <?= date('Y') ?> Mini-Ecommerce-ACL. Todos los derechos reservados</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- JavaScript para cambio de tema -->
  <script>
    // Función para cambiar el tema
    function setTheme(theme) {
      // Guardar tema en localStorage
      localStorage.setItem('theme', theme);
      
      // Aplicar tema al body
      document.documentElement.setAttribute('data-theme', theme);
      
      // Prevenir que el enlace se comporte como enlace normal
      event.preventDefault();
      
      // Mostrar notificación sutil
      showThemeNotification(theme);
    }
    
    // Función para mostrar notificación de cambio de tema
    function showThemeNotification(theme) {
      const notification = document.createElement('div');
      notification.className = 'alert alert-success position-fixed top-0 start-50 translate-middle-x mt-3';
      notification.style.zIndex = '9999';
      notification.style.minWidth = '200px';
      notification.innerHTML = `
        <i class="bi bi-${theme === 'dark' ? 'moon' : 'sun'}-fill me-2"></i>
        Tema ${theme === 'dark' ? 'oscuro' : 'claro'} activado
      `;
      
      document.body.appendChild(notification);
      
      // Remover notificación después de 2 segundos
      setTimeout(() => {
        notification.remove();
      }, 2000);
    }
    
    // Efecto de scroll en navbar
    window.addEventListener('scroll', function() {
      const navbar = document.getElementById('mainNavbar');
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });
    
    // Cargar tema guardado al iniciar la página
    document.addEventListener('DOMContentLoaded', function() {
      const savedTheme = localStorage.getItem('theme') || 'dark';
      document.documentElement.setAttribute('data-theme', savedTheme);
      
      // Inicializar efecto de scroll
      const navbar = document.getElementById('mainNavbar');
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      }
    });
  </script>
</body>
</html>
