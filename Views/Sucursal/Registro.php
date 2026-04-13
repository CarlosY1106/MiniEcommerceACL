<div class="card shadow-lg">
  <div class="card-header card-header-gradient">
    <i class="bi bi-building me-2"></i> <?= isset($sucursal) ? "Editar Sucursal" : "Registrar Sucursal" ?>
  </div>
  
  <div class="card-body">
    <div class="alert alert-info d-flex align-items-center mb-4">
      <i class="bi bi-info-circle me-2"></i>
      <?= isset($sucursal) 
          ? "Modifica los campos de la sucursal y guarda los cambios." 
          : "Completa el formulario para registrar una nueva sucursal en el sistema." ?>
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
            
            // Validar Fecha Apertura
            const fechaApertura = document.getElementById('FechaApertura');
            if (!fechaApertura.value) {
                errors.push('La fecha de apertura es obligatoria');
                fechaApertura.classList.add('is-invalid');
            } else {
                fechaApertura.classList.remove('is-invalid');
            }
            
            // Validar Responsable
            const responsable = document.getElementById('Responsable');
            if (!responsable.value.trim()) {
                errors.push('El responsable es obligatorio');
                responsable.classList.add('is-invalid');
            } else if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/.test(responsable.value)) {
                errors.push('El responsable solo puede contener letras y espacios');
                responsable.classList.add('is-invalid');
            } else {
                responsable.classList.remove('is-invalid');
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

    <form method="POST" action="/Sucursal/Registro<?= isset($sucursal['Id']) ? "?id=".$sucursal['Id'] : "" ?>">
      
      <!-- Nombre -->
      <div class="mb-3">
        <label for="Nombre" class="form-label">Nombre</label>
        <input type="text" name="Nombre" id="Nombre" class="form-control" 
               value="<?= $sucursal['Nombre'] ?? '' ?>" 
               required pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" 
               title="Solo letras y espacios">
      </div>

      <!-- Dirección -->
      <div class="mb-3">
        <label for="Direccion" class="form-label">Dirección</label>
        <input type="text" name="Direccion" id="Direccion" class="form-control" 
               value="<?= $sucursal['Direccion'] ?? '' ?>">
      </div>

      <!-- Teléfono -->
      <div class="mb-3">
        <label for="Telefono" class="form-label">Teléfono</label>
        <input type="tel" name="Telefono" id="Telefono" class="form-control" 
               value="<?= $sucursal['Telefono'] ?? '' ?>" 
               required pattern="[0-9]{8,15}" 
               title="Debe contener entre 8 y 15 dígitos">
      </div>

      <!-- Correo -->
      <div class="mb-3">
        <label for="Correo" class="form-label">Correo</label>
        <input type="email" name="Correo" id="Correo" class="form-control" 
               value="<?= $sucursal['Correo'] ?? '' ?>" required>
      </div>

      <!-- Estado -->
      <div class="mb-3">
        <label for="Estado" class="form-label">Estado</label>
        <select name="Estado" id="Estado" class="form-select">
          <option value="Activo" <?= (isset($sucursal) && $sucursal['Estado']=="Activo") ? "selected" : "" ?>>Activo</option>
          <option value="Inactivo" <?= (isset($sucursal) && $sucursal['Estado']=="Inactivo") ? "selected" : "" ?>>Inactivo</option>
        </select>
      </div>

      <!-- Fecha Apertura -->
      <div class="mb-3">
        <label for="FechaApertura" class="form-label">Fecha de Apertura</label>
        <input type="date" name="FechaApertura" id="FechaApertura" class="form-control" 
               value="<?= $sucursal['FechaApertura'] ?? '' ?>" required>
      </div>

      <!-- Responsable -->
      <div class="mb-3">
        <label for="Responsable" class="form-label">Responsable</label>
        <input type="text" name="Responsable" id="Responsable" class="form-control" 
               value="<?= $sucursal['Responsable'] ?? '' ?>" 
               required pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" 
               title="Solo letras y espacios">
      </div>

      <!-- Observaciones -->
      <div class="mb-3">
        <label for="Observaciones" class="form-label">Observaciones</label>
        <textarea name="Observaciones" id="Observaciones" class="form-control"><?= $sucursal['Observaciones'] ?? '' ?></textarea>
      </div>

      <!-- Botones -->
      <button type="submit" class="btn btn-primary">
        <i class="bi <?= isset($sucursal) ? 'bi-pencil-square' : 'bi-save' ?>"></i>
        <?= isset($sucursal) ? "Actualizar" : "Guardar" ?>
      </button>
      <a href="/index.php?url=Sucursal/Index" class="btn btn-secondary">Cancelar</a>
    </form>
  </div>
</div>
