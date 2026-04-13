<div class="card shadow-lg">
  <div class="card-header card-header-gradient">
    <i class="bi bi-box-seam me-2"></i> Gestión de Inventario
  </div>
  
  <div class="card-body">
    <div class="alert alert-info d-flex align-items-center mb-4">
      <i class="bi bi-info-circle me-2"></i>
      Aquí puedes visualizar, registrar, editar y eliminar los registros de inventario.
    </div>

    <!-- Botón nuevo inventario -->
    <a href="/Inventario/Registro" class="btn btn-success mb-3">
      <i class="bi bi-plus-circle-fill"></i> Nuevo Registro
    </a>

    <!-- Botón Descargar Reporte -->
    <a href="/Reporte/Inventario" class="btn btn-primary mb-3">
      <i class="bi bi-file-earmark-pdf"></i> Descargar Reporte PDF
    </a>

    <!-- Botón Ir al Dashboard -->
    <a href="/Dashboard/Index" class="btn btn-danger mb-3 text-white">
      <i class="bi bi-house-door-fill"></i> Ir al Dashboard
    </a>

    <!-- Campo de Búsqueda -->
    <div class="row mb-3">
      <div class="col-md-6">
        <label for="busquedaInventario" class="form-label fw-bold">Buscar inventario:</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-search"></i></span>
          <input type="text" id="busquedaInventario" name="busqueda" class="form-control" 
                 placeholder="Buscar por nombre..." 
                 value="<?= htmlspecialchars($_GET['busqueda'] ?? '') ?>">
        </div>
      </div>
    </div>

    <!-- Mostrar mensaje de búsqueda -->
    <?php if (!empty($_GET['busqueda'])): ?>
      <div class="alert alert-info d-flex align-items-center mb-3">
        <i class="bi bi-info-circle me-2"></i>
        Resultados de búsqueda para: <strong><?= htmlspecialchars($_GET['busqueda']) ?></strong>
        <a href="/Inventario/Index" class="btn btn-sm btn-outline-secondary ms-auto">
          <i class="bi bi-x-circle"></i> Limpiar búsqueda
        </a>
      </div>
    <?php endif; ?>

    <!-- Script para búsqueda en tiempo real -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const busquedaInput = document.getElementById('busquedaInventario');
    const tabla = document.querySelector('.table');
    const filas = tabla.querySelectorAll('tbody tr');

    // Búsqueda en tiempo real mientras el usuario escribe
    busquedaInput.addEventListener('input', function() {
        const terminoBusqueda = this.value.toLowerCase();
        let hayResultados = false;

        filas.forEach(fila => {
            // Buscar en la columna Nombre (índice 1)
            const nombreInventario = fila.cells[1].textContent.toLowerCase();
            
            // Buscar también en Producto (índice 2) para mayor flexibilidad
            const producto = fila.cells[2].textContent.toLowerCase();
            
            if (nombreInventario.includes(terminoBusqueda) || producto.includes(terminoBusqueda)) {
                fila.style.display = '';
                hayResultados = true;
            } else {
                fila.style.display = 'none';
            }
        });

        // Mostrar mensaje si no hay resultados
        const tbody = tabla.querySelector('tbody');
        const mensajeNoResultados = tbody.querySelector('.no-resultados');
        
        if (!hayResultados && terminoBusqueda !== '') {
            if (!mensajeNoResultados) {
                const filaMensaje = document.createElement('tr');
                filaMensaje.className = 'no-resultados';
                filaMensaje.innerHTML = `
                    <td colspan="9" class="text-center text-muted py-3">
                        <i class="bi bi-search me-2"></i>
                        No se encontraron resultados para "${busquedaInput.value}"
                    </td>
                `;
                tbody.appendChild(filaMensaje);
            } else {
                mensajeNoResultados.cells[0].innerHTML = `
                    <i class="bi bi-search me-2"></i>
                    No se encontraron resultados para "${busquedaInput.value}"
                `;
            }
        } else if (mensajeNoResultados) {
            mensajeNoResultados.remove();
        }
    });

    // También permitir búsqueda con Enter para consistencia
    busquedaInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
        }
    });
});
</script>

    <table class="table table-bordered table-striped align-middle">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Producto</th>
          <th>Cantidad</th>
          <th>Ubicación</th>
          <th>Estado</th>
          <th>Fecha Registro</th>
          <th>Responsable</th>
          <th class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($inventarios as $i): ?>
          <tr>
            <td><?= $i['Id'] ?></td>
            <td><?= $i['Nombre'] ?></td>
            <td><?= $i['Producto'] ?></td>
            <td><?= $i['Cantidad'] ?></td>
            <td><?= $i['Ubicacion'] ?></td>
            <td><?= $i['Estado'] ?></td>
            <td><?= $i['FechaRegistro'] ?></td>
            <td><?= $i['Responsable'] ?></td>
            <td class="text-center">
              <!-- Botón Editar -->
              <a href="/Inventario/Registro&id=<?= $i['Id'] ?>" 
                 class="btn btn-warning btn-sm me-1">
                <i class="bi bi-pencil"></i>
              </a>
              <!-- Botón Eliminar -->
              <a href="/Inventario/Delete&id=<?= $i['Id'] ?>" 
                 class="btn btn-danger btn-sm text-white"
                 onclick="return confirm('¿Seguro que deseas eliminar este registro de inventario?');">
                <i class="bi bi-trash"></i>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
