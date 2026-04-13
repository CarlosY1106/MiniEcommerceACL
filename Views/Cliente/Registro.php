<div class="card shadow-lg">
  <!-- Encabezado dinámico con gradiente -->
  <div class="card-header card-header-gradient">
    <i class="bi bi-person-lines-fill me-2"></i> <?= isset($cliente) ? "Editar Cliente" : "Registrar Cliente" ?>
  </div>
  
  <div class="card-body">
    <!-- Breve explicación -->
    <div class="alert alert-info d-flex align-items-center mb-4">
      <i class="bi bi-info-circle me-2"></i>
      <?= isset($cliente) 
          ? "Modifica los campos del cliente y guarda los cambios." 
          : "Completa el formulario para registrar un nuevo cliente en el sistema." ?>
    </div>

    <!-- Mostrar errores -->
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
            
            // Validar Documento Identidad
            const documento = document.getElementById('DocumentoIdentidad');
            if (!documento.value.trim()) {
                errors.push('El documento de identidad es obligatorio');
                documento.classList.add('is-invalid');
            } else if (!/^[0-9A-Za-z-]{6,20}$/.test(documento.value)) {
                errors.push('El documento debe tener entre 6 y 20 caracteres alfanuméricos');
                documento.classList.add('is-invalid');
            } else {
                documento.classList.remove('is-invalid');
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

    <!-- Formulario -->
    <form method="POST" action="/Cliente/Registro<?= isset($cliente['Id']) ? "?id=".$cliente['Id'] : "" ?>">
      
      <!-- Nombre -->
      <div class="mb-3">
        <label for="Nombre" class="form-label">Nombre</label>
        <input type="text" name="Nombre" id="Nombre" class="form-control" 
               value="<?= $cliente['Nombre'] ?? '' ?>" 
               required pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" 
               title="El nombre solo puede contener letras y espacios">
      </div>

      <!-- Dirección -->
      <div class="mb-3">
        <label for="Direccion" class="form-label">Dirección</label>
        <input type="text" name="Direccion" id="Direccion" class="form-control" 
               value="<?= $cliente['Direccion'] ?? '' ?>">
      </div>

      <!-- Teléfono -->
      <div class="mb-3">
        <label for="Telefono" class="form-label">Teléfono</label>
        <input type="tel" name="Telefono" id="Telefono" class="form-control" 
               value="<?= $cliente['Telefono'] ?? '' ?>" 
               required pattern="[0-9]{8,15}" 
               title="El teléfono debe contener entre 8 y 15 dígitos">
      </div>

      <!-- Correo -->
      <div class="mb-3">
        <label for="Correo" class="form-label">Correo</label>
        <input type="email" name="Correo" id="Correo" class="form-control" 
               value="<?= $cliente['Correo'] ?? '' ?>" required>
      </div>

      <!-- Estado -->
      <div class="mb-3">
        <label for="Estado" class="form-label">Estado</label>
        <select name="Estado" id="Estado" class="form-select">
          <option value="Activo" <?= (isset($cliente) && $cliente['Estado']=="Activo") ? "selected" : "" ?>>Activo</option>
          <option value="Inactivo" <?= (isset($cliente) && $cliente['Estado']=="Inactivo") ? "selected" : "" ?>>Inactivo</option>
        </select>
      </div>

      <!-- Documento Identidad -->
      <div class="mb-3">
        <label for="DocumentoIdentidad" class="form-label">Documento de Identidad</label>
        <input type="text" name="DocumentoIdentidad" id="DocumentoIdentidad" class="form-control" 
               value="<?= $cliente['DocumentoIdentidad'] ?? '' ?>" 
               required pattern="[0-9A-Za-z-]{6,20}" 
               title="El documento debe tener entre 6 y 20 caracteres alfanuméricos">
      </div>

      <!-- Observaciones -->
      <div class="mb-3">
        <label for="Observaciones" class="form-label">Observaciones</label>
        <textarea name="Observaciones" id="Observaciones" class="form-control"><?= $cliente['Observaciones'] ?? '' ?></textarea>
      </div>

      <!-- Botón Guardar/Actualizar -->
      <button type="submit" class="btn btn-primary">
        <i class="bi <?= isset($cliente) ? 'bi-pencil-square' : 'bi-save' ?>"></i>
        <?= isset($cliente) ? "Actualizar" : "Guardar" ?>
      </button>
      <a href="/index.php?url=Cliente/Index" class="btn btn-secondary">Cancelar</a>
    </form>
  </div>
</div>
