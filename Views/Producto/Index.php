<div class="card shadow-lg">
  <!-- Encabezado con gradiente -->
  <div class="card-header card-header-gradient">
    <i class="bi bi-box-seam me-2"></i> Gestión de Productos
  </div>
  
  <div class="card-body">
    <!-- Breve explicación -->
    <div class="alert alert-info d-flex align-items-center mb-4">
      <i class="bi bi-info-circle me-2"></i>
      Aquí puedes visualizar, registrar, editar y eliminar los productos disponibles en el sistema.
    </div>

    <!-- Botón nuevo producto -->
    <a href="/Producto/Registro" class="btn btn-success mb-3">
      <i class="bi bi-plus-circle-fill"></i> Nuevo Producto
    </a>

    <!-- Botón Descargar Reporte -->
    <a href="/Reporte/Productos" class="btn btn-primary mb-3">
      <i class="bi bi-file-earmark-pdf"></i> Descargar Reporte PDF
    </a>

    <!-- Botón Ir al Dashboard -->
    <a href="/Dashboard/Index" class="btn btn-danger mb-3 text-white">
      <i class="bi bi-house-door-fill"></i> Ir al Dashboard
    </a>

    <!-- Filtros -->
    <div class="row mb-3">
      <div class="col-md-6">
        <form method="GET" action="/Producto/Index">

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
        <label for="busquedaProducto" class="form-label fw-bold">Buscar producto:</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-search"></i></span>
          <input type="text" id="busquedaProducto" class="form-control" placeholder="Buscar por nombre...">
        </div>
      </div>
    </div>

    <!-- Tabla -->
    <table class="table table-bordered table-striped align-middle">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Precio</th>
          <th>Existencia</th>
          <th>Categoría</th>
          <th class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($productos)): ?>
          <?php foreach ($productos as $p): ?>
            <tr>
              <td><?= $p['Id'] ?></td>
              <td><?= $p['Nombre'] ?></td>
              <td><?= $p['Precio'] ?></td>
              <td><?= $p['Existencia'] ?></td>
              <!-- Ahora mostramos el nombre de la categoría -->
              <td><?= $p['Categoria'] ?></td>
              <td class="text-center">
                <!-- Botón editar -->
                <a href="/Producto/Registro&id=<?= $p['Id'] ?>" 
                   class="btn btn-warning btn-sm me-1">
                  <i class="bi bi-pencil"></i>
                </a>
                <!-- Botón eliminar -->
                <a href="/Producto/Delete&id=<?= $p['Id'] ?>" 
                   class="btn btn-danger btn-sm text-white"
                   onclick="return confirm('¿Seguro que deseas eliminar este producto?');">
                  <i class="bi bi-trash"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" class="text-center text-muted">No hay productos en esta categoría.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const busquedaInput = document.getElementById('busquedaProducto');
    const tabla = document.querySelector('.table');
    const filas = tabla.querySelectorAll('tbody tr');

    busquedaInput.addEventListener('input', function() {
        const terminoBusqueda = this.value.toLowerCase();

        filas.forEach(fila => {
            const nombreProducto = fila.cells[1].textContent.toLowerCase();
            const categoria = fila.cells[4].textContent.toLowerCase();
            
            if (nombreProducto.includes(terminoBusqueda) || categoria.includes(terminoBusqueda)) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    });
});
</script>
