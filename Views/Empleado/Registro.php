<div class="card shadow-lg">
  <div class="card-header card-header-gradient">
    <i class="bi bi-person-workspace me-2"></i> <?= isset($empleado) ? "Editar Empleado" : "Registrar Empleado" ?>
  </div>
  
  <div class="card-body">
    <div class="alert alert-info d-flex align-items-center mb-4">
      <i class="bi bi-info-circle me-2"></i>
      <?= isset($empleado) 
          ? "Modifica los campos del empleado y guarda los cambios." 
          : "Completa el formulario para registrar un nuevo empleado en el sistema." ?>
    </div>

    <!-- Mostrar errores del servidor -->
    <?php if(isset($error)): ?>
      <div class="alert alert-danger d-flex align-items-center mb-4">
        <i class="bi bi-exclamation-circle me-2"></i> <?= $error ?>
      </div>
    <?php endif; ?>

    <!-- Mostrar errores de validación -->
    <div id="error-container"></div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const errorContainer = document.getElementById('error-container');
        
        form.addEventListener('submit', function(e) {
            const errors = [];
            
            // Validar Nombre
            const nombre = document.getElementById('Nombre');
            if (!nombre.value.trim()) {
                errors.push('El nombre es obligatorio');
                nombre.classList.add('is-invalid');
            } else if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/.test(nombre.value)) {
                errors.push('El nombre solo puede contener letras y espacios');
                nombre.classList.add('is-invalid');
            } else {
                nombre.classList.remove('is-invalid');
            }
            
            // Validar Cargo
            const cargo = document.getElementById('Cargo');
            if (!cargo.value.trim()) {
                errors.push('El cargo es obligatorio');
                cargo.classList.add('is-invalid');
            } else if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/.test(cargo.value)) {
                errors.push('El cargo solo puede contener letras y espacios');
                cargo.classList.add('is-invalid');
            } else {
                cargo.classList.remove('is-invalid');
            }
            
            // Validar Salario
            const salario = document.getElementById('Salario');
            if (!salario.value.trim()) {
                errors.push('El salario es obligatorio');
                salario.classList.add('is-invalid');
            } else if (!/^\d+(\.\d{1,2})?$/.test(salario.value) || parseFloat(salario.value) <= 0) {
                errors.push('El salario debe ser un número positivo válido');
                salario.classList.add('is-invalid');
            } else {
                salario.classList.remove('is-invalid');
            }
            
            // Validar Teléfono
            const telefono = document.getElementById('Telefono');
            if (!telefono.value.trim()) {
                errors.push('El teléfono es obligatorio');
                telefono.classList.add('is-invalid');
            } else if (!/^[0-9]{8,15}$/.test(telefono.value)) {
                errors.push('El teléfono debe contener entre 8 y 15 dígitos');
                telefono.classList.add('is-invalid');
            } else {
                telefono.classList.remove('is-invalid');
            }
            
            // Validar Correo
            const correo = document.getElementById('Correo');
            if (!correo.value.trim()) {
                errors.push('El correo es obligatorio');
                correo.classList.add('is-invalid');
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo.value)) {
                errors.push('El correo no tiene un formato válido');
                correo.classList.add('is-invalid');
            } else {
                correo.classList.remove('is-invalid');
            }
            
            // Validar Fecha Ingreso
            const fechaIngreso = document.getElementById('FechaIngreso');
            if (!fechaIngreso.value) {
                errors.push('La fecha de ingreso es obligatoria');
                fechaIngreso.classList.add('is-invalid');
            } else {
                fechaIngreso.classList.remove('is-invalid');
            }
            
            // Mostrar errores si existen
            if (errors.length > 0) {
                e.preventDefault();
                errorContainer.innerHTML = `
                    <div class="alert alert-danger d-flex align-items-center mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <div>
                            <strong>Por favor corrige los siguientes errores:</strong>
                            <ul class="mb-0 mt-2">
                                ${errors.map(error => `<li>${error}</li>`).join('')}
                            </ul>
                        </div>
                    </div>
                `;
                // Scroll al inicio de los errores
                errorContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else {
                errorContainer.innerHTML = '';
            }
        });
        
        // Limpiar errores al modificar campos
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('is-invalid');
            });
        });
    });
    </script>

    <form method="POST" action="/Empleado/Registro<?= isset($empleado['Id']) ? "?id=".$empleado['Id'] : "" ?>">
      
      <!-- Nombre -->
      <div class="mb-3">
        <label for="Nombre" class="form-label">Nombre</label>
        <input type="text" name="Nombre" id="Nombre" class="form-control" 
               value="<?= $empleado['Nombre'] ?? '' ?>" 
               required pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" 
               title="Solo letras y espacios">
      </div>

      <!-- Cargo -->
      <div class="mb-3">
        <label for="Cargo" class="form-label">Cargo</label>
        <input type="text" name="Cargo" id="Cargo" class="form-control" 
               value="<?= $empleado['Cargo'] ?? '' ?>" 
               required pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" 
               title="Solo letras y espacios">
      </div>

      <!-- Salario -->
      <div class="mb-3">
        <label for="Salario" class="form-label">Salario</label>
        <input type="number" step="0.01" name="Salario" id="Salario" class="form-control" 
               value="<?= $empleado['Salario'] ?? '' ?>" 
               required pattern="^\d+(\.\d{1,2})?$" 
               title="Número válido con hasta 2 decimales">
      </div>

      <!-- Teléfono -->
      <div class="mb-3">
        <label for="Telefono" class="form-label">Teléfono</label>
        <input type="tel" name="Telefono" id="Telefono" class="form-control" 
               value="<?= $empleado['Telefono'] ?? '' ?>" 
               required pattern="[0-9]{8,15}" 
               title="Debe contener entre 8 y 15 dígitos">
      </div>

      <!-- Correo -->
      <div class="mb-3">
        <label for="Correo" class="form-label">Correo</label>
        <input type="email" name="Correo" id="Correo" class="form-control" 
               value="<?= $empleado['Correo'] ?? '' ?>" required>
      </div>

      <!-- Estado -->
      <div class="mb-3">
        <label for="Estado" class="form-label">Estado</label>
        <select name="Estado" id="Estado" class="form-select">
          <option value="Activo" <?= (isset($empleado) && $empleado['Estado']=="Activo") ? "selected" : "" ?>>Activo</option>
          <option value="Inactivo" <?= (isset($empleado) && $empleado['Estado']=="Inactivo") ? "selected" : "" ?>>Inactivo</option>
        </select>
      </div>

      <!-- Fecha de Ingreso -->
      <div class="mb-3">
        <label for="FechaIngreso" class="form-label">Fecha de Ingreso</label>
        <input type="date" name="FechaIngreso" id="FechaIngreso" class="form-control" 
               value="<?= $empleado['FechaIngreso'] ?? '' ?>" required>
      </div>

      <!-- Observaciones -->
      <div class="mb-3">
        <label for="Observaciones" class="form-label">Observaciones</label>
        <textarea name="Observaciones" id="Observaciones" class="form-control"><?= $empleado['Observaciones'] ?? '' ?></textarea>
      </div>

      <!-- Botones -->
      <button type="submit" class="btn btn-primary">
        <i class="bi <?= isset($empleado) ? 'bi-pencil-square' : 'bi-save' ?>"></i>
        <?= isset($empleado) ? "Actualizar" : "Guardar" ?>
      </button>
      <a href="/index.php?url=Empleado/Index" class="btn btn-secondary">Cancelar</a>
    </form>
  </div>
</div>
