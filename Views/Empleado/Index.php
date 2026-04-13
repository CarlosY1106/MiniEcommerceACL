<div class="card shadow-lg">
  <div class="card-header card-header-gradient">
    <i class="bi bi-person-workspace me-2"></i> Gestión de Empleados
  </div>
  
  <div class="card-body">
    <div class="alert alert-info d-flex align-items-center mb-4">
      <i class="bi bi-info-circle me-2"></i>
      Aquí puedes visualizar, registrar, editar y eliminar los empleados del sistema.
    </div>

    <!-- Botón Nuevo Empleado -->
    <a href="/Empleado/Registro" class="btn btn-success mb-3">
      <i class="bi bi-plus-circle-fill"></i> Nuevo Empleado
    </a>

    <!-- Botón Descargar Reporte -->
    <a href="/Reporte/Empleados" class="btn btn-primary mb-3">
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
          <th>Cargo</th>
          <th>Salario</th>
          <th>Teléfono</th>
          <th>Correo</th>
          <th>Estado</th>
          <th>Fecha Ingreso</th>
          <th class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($empleados as $e): ?>
          <tr>
            <td><?= $e['Id'] ?></td>
            <td><?= $e['Nombre'] ?></td>
            <td><?= $e['Cargo'] ?></td>
            <td><?= $e['Salario'] ?></td>
            <td><?= $e['Telefono'] ?></td>
            <td><?= $e['Correo'] ?></td>
            <td><?= $e['Estado'] ?></td>
            <td><?= $e['FechaIngreso'] ?></td>
            <td class="text-center">
              <!-- Botón Editar -->
              <a href="/Empleado/Registro&id=<?= $e['Id'] ?>" 
                 class="btn btn-warning btn-sm me-1">
                <i class="bi bi-pencil"></i>
              </a>
              <!-- Botón Eliminar -->
              <a href="/Empleado/Delete&id=<?= $e['Id'] ?>" 
                 class="btn btn-danger btn-sm text-white"
                 onclick="return confirm('¿Seguro que deseas eliminar este empleado?');">
                <i class="bi bi-trash"></i>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
