<div class="card shadow-lg">
  <!-- Encabezado con gradiente -->
  <div class="card-header card-header-gradient">
    <i class="bi bi-truck me-2"></i> Gestión de Proveedores
  </div>
  
  <div class="card-body">
    <!-- Breve explicación -->
    <div class="alert alert-info d-flex align-items-center mb-4">
      <i class="bi bi-info-circle me-2"></i>
      Aquí puedes visualizar, registrar, editar y eliminar los proveedores registrados en el sistema.
    </div>

    <!-- Botón nuevo proveedor -->
    <a href="/Proveedor/Registro" class="btn btn-success mb-3">
      <i class="bi bi-plus-circle-fill"></i> Nuevo Proveedor
    </a>

    <!-- Botón Descargar Reporte -->
    <a href="/Reporte/Proveedores" class="btn btn-primary mb-3">
      <i class="bi bi-file-earmark-pdf"></i> Descargar Reporte PDF
    </a>

    <!-- Botón Ir al Dashboard -->
    <a href="/Dashboard/Index" class="btn btn-danger mb-3 text-white">
      <i class="bi bi-house-door-fill"></i> Ir al Dashboard
    </a>

    <!-- Filtros -->
    <div class="row mb-3">
      <div class="col-md-6">
        <form method="GET" action="/Proveedor/Index">
          <label for="categoria" class="form-label fw-bold">Filtrar por categoría:</label>
          <div class="input-group">
            <select name="categoria" id="categoria" class="form-select">
              <option value="">Todas</option>
              <?php foreach($categorias as $cat): ?>
                <option value="<?= $cat['Id'] ?>" 
                  <?= isset($_GET['categoria']) && $_GET['categoria'] == $cat['Id'] ? 'selected' : '' ?>>
                  <?= $cat['Nombre'] ?>
                </option>
              <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-filter-circle"></i> Filtrar
            </button>
          </div>
        </form>
      </div>
      <div class="col-md-6">
        <label for="busquedaDireccion" class="form-label fw-bold">Buscar dirección:</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-search"></i></span>
          <input type="text" id="busquedaDireccion" class="form-control" placeholder="Buscar por dirección...">
        </div>
      </div>
    </div>

    <!-- Tabla -->
    <table class="table table-bordered table-striped align-middle">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Teléfono</th>
          <th>Correo</th>
          <th>Dirección</th>
          <th>Categoría</th>
          <th>Estado</th>
          <th class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($proveedores as $p): ?>
          <tr>
            <td><?= $p['Id'] ?></td>
            <td><?= $p['Nombre'] ?></td>
            <td><?= $p['Telefono'] ?></td>
            <td><?= $p['Correo'] ?></td>
            <td><?= $p['Direccion'] ?></td>
            <td><?= $p['Categoria'] ?? 'Sin categoría' ?></td>
            <td><?= $p['Estado'] ?></td>
            <td class="text-center">
              <!-- Botón editar -->
              <a href="/Proveedor/Registro&id=<?= $p['Id'] ?>" 
                 class="btn btn-warning btn-sm me-1">
                <i class="bi bi-pencil"></i>
              </a>
              <!-- Botón eliminar -->
              <a href="/Proveedor/Delete&id=<?= $p['Id'] ?>" 
                 class="btn btn-danger btn-sm text-white"
                 onclick="return confirm('¿Seguro que deseas eliminar este proveedor?');">
                <i class="bi bi-trash"></i>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const busquedaInput = document.getElementById('busquedaDireccion');
    const tabla = document.querySelector('.table');
    const filas = tabla.querySelectorAll('tbody tr');

    busquedaInput.addEventListener('input', function() {
        const terminoBusqueda = this.value.toLowerCase();

        filas.forEach(fila => {
            const direccion = fila.cells[4].textContent.toLowerCase();
            const nombre = fila.cells[1].textContent.toLowerCase();
            const categoria = fila.cells[5].textContent.toLowerCase();
            
            if (direccion.includes(terminoBusqueda) || 
                nombre.includes(terminoBusqueda) || 
                categoria.includes(terminoBusqueda)) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    });
});
</script>
