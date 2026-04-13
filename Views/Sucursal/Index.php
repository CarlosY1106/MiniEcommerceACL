<div class="card shadow-lg">
  <div class="card-header card-header-gradient">
    <i class="bi bi-building me-2"></i> Gestión de Sucursales
  </div>
  
  <div class="card-body">
    <div class="alert alert-info d-flex align-items-center mb-4">
      <i class="bi bi-info-circle me-2"></i>
      Aquí puedes visualizar, registrar, editar y eliminar las sucursales del sistema.
    </div>

    <!-- Botón Nueva Sucursal -->
    <a href="/Sucursal/Registro" class="btn btn-success mb-3">
      <i class="bi bi-plus-circle-fill"></i> Nueva Sucursal
    </a>

    <!-- Botón Descargar Reporte -->
    <a href="/Reporte/Sucursales" class="btn btn-primary mb-3">
      <i class="bi bi-file-earmark-pdf"></i> Descargar Reporte PDF
    </a>

    <!-- Botón Ir al Dashboard -->
    <a href="/Dashboard/Index" class="btn btn-danger mb-3 text-white">
      <i class="bi bi-house-door-fill"></i> Ir al Dashboard
    </a>

    <table class="table table-bordered table-striped align-middle">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Dirección</th>
          <th>Teléfono</th>
          <th>Correo</th>
          <th>Estado</th>
          <th>Fecha Apertura</th>
          <th>Responsable</th>
          <th class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($sucursales as $s): ?>
          <tr>
            <td><?= $s['Id'] ?></td>
            <td><?= $s['Nombre'] ?></td>
            <td><?= $s['Direccion'] ?></td>
            <td><?= $s['Telefono'] ?></td>
            <td><?= $s['Correo'] ?></td>
            <td><?= $s['Estado'] ?></td>
            <td><?= $s['FechaApertura'] ?></td>
            <td><?= $s['Responsable'] ?></td>
            <td class="text-center">
              <!-- Botón editar -->
              <a href="/Sucursal/Registro&id=<?= $s['Id'] ?>" 
                 class="btn btn-warning btn-sm me-1">
                <i class="bi bi-pencil"></i>
              </a>
              <!-- Botón eliminar -->
              <a href="/Sucursal/Delete&id=<?= $s['Id'] ?>" 
                 class="btn btn-danger btn-sm text-white"
                 onclick="return confirm('¿Seguro que deseas eliminar esta sucursal?');">
                <i class="bi bi-trash"></i>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
