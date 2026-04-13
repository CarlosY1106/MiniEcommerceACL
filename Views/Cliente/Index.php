<div class="card shadow-lg">
  <div class="card-header card-header-gradient">
    <i class="bi bi-person-lines-fill me-2"></i> Gestión de Clientes
  </div>
  
  <div class="card-body">
    <div class="alert alert-info d-flex align-items-center mb-4">
      <i class="bi bi-info-circle me-2"></i>
      Aquí puedes visualizar, registrar, editar y eliminar los clientes registrados en el sistema.
    </div>

    <!-- Botón Nuevo Cliente -->
    <a href="/Cliente/Registro" class="btn btn-success mb-3">
      <i class="bi bi-plus-circle-fill"></i> Nuevo Cliente
    </a>

    <!-- Botón Descargar Reporte -->
    <a href="/Reporte/Clientes" class="btn btn-primary mb-3">
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
          <th>Documento</th>
          <th class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($clientes as $c): ?>
          <tr>
            <td><?= $c['Id'] ?></td>
            <td><?= $c['Nombre'] ?></td>
            <td><?= $c['Direccion'] ?></td>
            <td><?= $c['Telefono'] ?></td>
            <td><?= $c['Correo'] ?></td>
            <td><?= $c['Estado'] ?></td>
            <td><?= $c['DocumentoIdentidad'] ?></td>
            <td class="text-center">
              <!-- Botón Editar -->
              <a href="/Cliente/Registro&id=<?= $c['Id'] ?>" 
                 class="btn btn-warning btn-sm me-1">
                <i class="bi bi-pencil"></i>
              </a>
              <!-- Botón Eliminar -->
              <a href="/Cliente/Delete&id=<?= $c['Id'] ?>" 
                 class="btn btn-danger btn-sm text-white"
                 onclick="return confirm('¿Seguro que deseas eliminar este cliente?');">
                <i class="bi bi-trash"></i>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
