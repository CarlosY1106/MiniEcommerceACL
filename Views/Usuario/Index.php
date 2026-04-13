<div class="card shadow-lg">
  <!-- Encabezado con gradiente -->
  <div class="card-header card-header-gradient">
    <i class="bi bi-people-fill me-2"></i> Gestión de Usuarios
  </div>
  
  <div class="card-body">
    <!-- Breve explicación -->
    <div class="alert alert-info d-flex align-items-center mb-4">
      <i class="bi bi-info-circle me-2"></i>
      Aquí puedes visualizar, registrar, editar y eliminar usuarios del sistema.
    </div>

    <!-- Botón nuevo usuario -->
    <a href="/Usuario/Registro" class="btn btn-success mb-3">
      <i class="bi bi-person-plus-fill"></i> Nuevo Usuario
    </a>

    <!-- Botón Descargar Reporte -->
    <a href="/Reporte/Usuarios" class="btn btn-primary mb-3">
      <i class="bi bi-file-earmark-pdf"></i> Descargar Reporte PDF
    </a>

    <!-- Botón Ir al Dashboard -->
    <a href="/Dashboard/Index" class="btn btn-danger mb-3 text-white">
      <i class="bi bi-house-door-fill"></i> Ir al Dashboard
    </a>

    <!-- Campo de búsqueda -->
    <div class="row mb-3">
      <div class="col-md-6">
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-search"></i></span>
          <input type="text" id="busquedaUsuario" class="form-control" placeholder="Buscar por nombre de usuario...">
        </div>
      </div>
    </div>

    <!-- Tabla -->
    <table class="table table-bordered table-striped align-middle">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Usuario</th>
          <th>Correo</th>
          <th>Teléfono</th>
          <th>Rol</th>
          <th class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($usuarios as $u): ?>
          <tr>
            <td><?= $u['Id'] ?></td>
            <td><?= $u['NombreUsuario'] ?></td>
            <td><?= $u['Correo'] ?></td>
            <td><?= $u['Telefono'] ?></td>
            <td><?= $u['Rol_Id'] == 1 ? "Administrador" : "Cliente" ?></td>
            <td class="text-center">
              <!-- Botón editar -->
              <a href="/Usuario/Registro&id=<?= $u['Id'] ?>" 
                 class="btn btn-warning btn-sm me-1">
                <i class="bi bi-pencil"></i>
              </a>
              <!-- Botón eliminar -->
              <a href="/Usuario/Delete&id=<?= $u['Id'] ?>" 
                 class="btn btn-danger btn-sm text-white"
                 onclick="return confirm('¿Seguro que deseas eliminar este usuario?');">
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
    const busquedaInput = document.getElementById('busquedaUsuario');
    const tabla = document.querySelector('.table');
    const filas = tabla.querySelectorAll('tbody tr');

    busquedaInput.addEventListener('input', function() {
        const terminoBusqueda = this.value.toLowerCase();

        filas.forEach(fila => {
            const nombreUsuario = fila.cells[1].textContent.toLowerCase();
            const correo = fila.cells[2].textContent.toLowerCase();
            
            if (nombreUsuario.includes(terminoBusqueda) || correo.includes(terminoBusqueda)) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    });
});
</script>
