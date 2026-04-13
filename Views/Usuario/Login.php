<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <title>Login - Mini-Ecommerce-ACL</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link href="/Styles/login.css" rel="stylesheet">
</head>
<body>
  <!-- Contenido principal -->
  <div class="main-content">
    <!-- Tarjeta de login -->
    <div class="card login-card shadow-lg p-4 text-center">
      
      <!-- Logo centrado -->
      <div class="mb-4">
        <img src="/Images/Logotipo.jpg" alt="Logo" class="logo-large">
      </div>
      
      <h4 class="fw-bold mb-4 title-spacing">Iniciar Sesión</h4>
      
      <?php if(isset($error)): ?>
        <div class="alert alert-danger d-flex align-items-center">
          <i class="bi bi-exclamation-circle me-2"></i> <?= $error ?>
        </div>
      <?php endif; ?>
      
      <form method="POST" action="/Usuario/Login" id="loginForm">
        <!-- Usuario -->
        <div class="mb-3 text-start">
          <label class="form-label text-white">Usuario</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-person"></i></span>
            <input type="text" name="NombreUsuario" class="form-control" required>
          </div>
        </div>
        
        <!-- Contraseña con toggle -->
        <div class="mb-3 text-start">
          <label class="form-label text-white">Contraseña</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-key"></i></span>
            <input type="password" name="Contraseña" id="password" class="form-control" required>
            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
              <i class="bi bi-eye"></i>
            </button>
          </div>
        </div>
        
        <!-- Recordarme -->
        <div class="form-check mb-3 text-start">
          <input class="form-check-input" type="checkbox" id="recordarme">
          <label class="form-check-label text-white" for="recordarme">Recordarme</label>
        </div>
        
        <!-- Botón con gradiente -->
        <button type="submit" class="btn w-100 btn-gradient">
          <i class="bi bi-shield-lock me-2"></i> Acceder al Sistema
        </button>
      </form>

      <!-- Eslogan -->
      <div class="slogan">Gestiona, vende, crece.</div>
    </div>
  </div>

  <!-- Scripts -->
  <script>
    // Función para cambiar el tema
    function setTheme(theme) {
      // Guardar tema en localStorage
      localStorage.setItem('theme', theme);
      
      // Aplicar tema al html
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
    
    // Cargar tema guardado al iniciar la página
    document.addEventListener('DOMContentLoaded', function() {
      const savedTheme = localStorage.getItem('theme') || 'dark';
      document.documentElement.setAttribute('data-theme', savedTheme);
    });

    // Mostrar/Ocultar contraseña
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");
    togglePassword.addEventListener("click", function () {
      const type = password.getAttribute("type") === "password" ? "text" : "password";
      password.setAttribute("type", type);
      this.innerHTML = type === "password" ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
    });

    // Enviar con Enter
    document.getElementById("loginForm").addEventListener("keypress", function(e) {
      if (e.key === "Enter") {
        this.submit();
      }
    });
  </script>
</body>
</html>
