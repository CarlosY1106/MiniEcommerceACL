<!-- Custom CSS -->
<link href="/Styles/dashboard.css" rel="stylesheet">

<div class="text-center mb-5">
  <!-- Logo redondo con sombra elegante -->
  <img src="/Images/Logotipo.jpg" alt="Logo" class="logo-medium" 
       class="mb-3">
  
  <h2 class="fw-bold text-gradient">Bienvenido (a) al Dashboard, 
    <?php 
      if(isset($_SESSION['usuario']->NombreUsuario)) {
        echo htmlspecialchars($_SESSION['usuario']->NombreUsuario);
      } elseif(isset($_SESSION['nombre_usuario'])) {
        echo htmlspecialchars($_SESSION['nombre_usuario']);
      }
    ?>.</h2>
  <p class="text-white">Selecciona una opción para gestionar el sistema según tus necesidades.</p>
</div>

<div class="row g-4 mb-4">
  <!-- Usuarios -->
  <div class="col-lg-3 col-md-6">
    <div class="dashboard-card card-usuarios">
      <div class="icon-wrapper">
        <i class="bi bi-people"></i>
      </div>
      <h5>Usuarios</h5>
      <p class="text-white-50 mb-4">Gestión de usuarios del sistema</p>
      <a href="/Usuario/Index" class="btn btn-primary w-100">Gestionar</a>
    </div>
  </div>

  <!-- Productos -->
  <div class="col-lg-3 col-md-6">
    <div class="dashboard-card card-productos">
      <div class="icon-wrapper">
        <i class="bi bi-box-seam"></i>
      </div>
      <h5>Productos</h5>
      <p class="text-white-50 mb-4">Catálogo de productos</p>
      <a href="/Producto/Index" class="btn btn-success w-100">Gestionar</a>
    </div>
  </div>

  <!-- Proveedores -->
  <div class="col-lg-3 col-md-6">
    <div class="dashboard-card card-proveedores">
      <div class="icon-wrapper">
        <i class="bi bi-truck"></i>
      </div>
      <h5>Proveedores</h5>
      <p class="text-white-50 mb-4">Gestión de proveedores</p>
      <a href="/Proveedor/Index" class="btn btn-warning w-100">Gestionar</a>
    </div>
  </div>

  <!-- Clientes -->
  <div class="col-lg-3 col-md-6">
    <div class="dashboard-card card-clientes">
      <div class="icon-wrapper">
        <i class="bi bi-person-check"></i>
      </div>
      <h5>Clientes</h5>
      <p class="text-white-50 mb-4">Base de datos de clientes</p>
      <a href="/Cliente/Index" class="btn btn-info w-100">Gestionar</a>
    </div>
  </div>
</div>

<div class="row g-4">
  <!-- Empleados -->
  <div class="col-lg-3 col-md-6">
    <div class="dashboard-card card-empleados">
      <div class="icon-wrapper">
        <i class="bi bi-person-workspace"></i>
      </div>
      <h5>Empleados</h5>
      <p class="text-white-50 mb-4">Gestión de empleados</p>
      <a href="/Empleado/Index" class="btn btn-danger w-100">Gestionar</a>
    </div>
  </div>

  <!-- Sucursales -->
  <div class="col-lg-3 col-md-6">
    <div class="dashboard-card card-sucursales">
      <div class="icon-wrapper">
        <i class="bi bi-building"></i>
      </div>
      <h5>Sucursales</h5>
      <p class="text-white-50 mb-4">Gestión de sucursales</p>
      <a href="/Sucursal/Index" class="btn btn-secondary w-100">Gestionar</a>
    </div>
  </div>

  <!-- Inventario -->
  <div class="col-lg-3 col-md-6">
    <div class="dashboard-card card-inventario">
      <div class="icon-wrapper">
        <i class="bi bi-clipboard-data"></i>
      </div>
      <h5>Inventario</h5>
      <p class="text-white-50 mb-4">Control de inventario</p>
      <a href="/Inventario/Index" class="btn btn-teal w-100">Gestionar</a>
    </div>
  </div>

  <!-- Autores -->
  <div class="col-lg-3 col-md-6">
    <div class="dashboard-card card-autores">
      <div class="icon-wrapper">
        <i class="bi bi-pencil-square"></i>
      </div>
      <h5>Autores</h5>
      <p class="text-white-50 mb-4">Gestión de autores</p>
      <a href="/Autores/Index" class="btn btn-purple w-100">Gestionar</a>
    </div>
  </div>
</div>


