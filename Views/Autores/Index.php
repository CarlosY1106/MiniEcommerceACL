<!-- Custom CSS -->
<link href="/Styles/autores.css" rel="stylesheet">

<!-- Botón Ir al Dashboard -->
<a href="/Dashboard/Index" class="btn btn-danger mb-3 text-white">
  <i class="bi bi-house-door-fill"></i> Ir al Dashboard
</a>

<!-- Encabezado mejorado -->
<div class="section-header text-center">
  <div class="position-relative">
    <!-- Logo del sistema -->
    <div class="mb-4">
      <img src="/Images/Logotipo.jpg" alt="Logo" class="logo-small">
    </div>
    
    <h1 class="text-white mb-3">
      <i class="bi bi-people-fill me-3"></i>Autores del Proyecto
    </h1>
    <p class="text-white-50 mb-0">Desarrolladores detrás de Mini-Ecommerce-ACL</p>
  </div>
</div>

<!-- Grid de autores mejorado -->
<div class="row g-4">
  <?php foreach ($autores as $a): ?>
    <div class="col-lg-6 col-xl-4">
      <div class="card autor-card h-100 p-4">
        <div class="text-center">
          <!-- Imagen del autor -->
          <div class="mb-3">
            <img src="<?= $a['Foto'] ?>" 
                 alt="<?= htmlspecialchars($a['Nombre']) ?>" 
                 class="rounded-circle autor-image shadow-lg">
          </div>
          
          <!-- Contenido del autor -->
          <div class="text-start">
            <!-- Nombre -->
            <h3 class="autor-name"><?= htmlspecialchars($a['Nombre']) ?></h3>
            
            <!-- Rol/Badge -->
            <div class="text-center mb-3">
              <span class="autor-badge">
                <i class="bi bi-star-fill me-1"></i><?= htmlspecialchars($a['Rol']) ?>
              </span>
            </div>
            
            <!-- Descripción -->
            <div class="autor-description">
              <?= htmlspecialchars($a['Descripcion']) ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
