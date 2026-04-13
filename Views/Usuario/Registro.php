<div class="card shadow-lg">
  <div class="card-header card-header-gradient">
    <i class="bi bi-person-fill me-2"></i> <?= isset($usuario) ? "Editar Usuario" : "Registrar Usuario" ?>
  </div>
  
  <div class="card-body">
    <div class="alert alert-info d-flex align-items-center mb-4">
      <i class="bi bi-info-circle me-2"></i>
      <?= isset($usuario) 
          ? "Modifica los campos del usuario y guarda los cambios." 
          : "Completa el formulario para registrar un nuevo usuario en el sistema." ?>
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
            
            // Validar Usuario
            const nombreUsuario = document.getElementById('NombreUsuario');
            if (!nombreUsuario.value.trim()) {
                errors.push('El nombre de usuario es obligatorio');
                nombreUsuario.classList.add('is-invalid');
            } else if (!/^[A-Za-z0-9_]{4,20}$/.test(nombreUsuario.value)) {
                errors.push('El usuario debe tener entre 4 y 20 caracteres, solo letras, números y guiones bajos');
                nombreUsuario.classList.add('is-invalid');
            } else {
                nombreUsuario.classList.remove('is-invalid');
            }
            
            // Validar Contraseña
            const contraseña = document.getElementById('Contraseña');
            if (!contraseña.value.trim()) {
                errors.push('La contraseña es obligatoria');
                contraseña.classList.add('is-invalid');
            } else if (!/(?=.*[A-Z])(?=.*[0-9]).{6,}/.test(contraseña.value)) {
                errors.push('La contraseña debe tener al menos 6 caracteres, una mayúscula y un número');
                contraseña.classList.add('is-invalid');
            } else {
                contraseña.classList.remove('is-invalid');
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
            
            // Validar Rol
            const rol = document.getElementById('Rol_Id');
            if (!rol.value) {
                errors.push('El rol es obligatorio');
                rol.classList.add('is-invalid');
            } else {
                rol.classList.remove('is-invalid');
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

    <form method="POST" action="/Usuario/Registro<?= isset($usuario['Id']) ? "?id=".$usuario['Id'] : "" ?>">
      
      <!-- Usuario -->
      <div class="mb-3">
        <label for="NombreUsuario" class="form-label">Usuario</label>
        <input type="text" name="NombreUsuario" id="NombreUsuario" class="form-control"
               value="<?= $usuario['NombreUsuario'] ?? '' ?>" 
               required pattern="[A-Za-z0-9_]{4,20}" 
               title="Debe tener entre 4 y 20 caracteres, solo letras, números y guiones bajos">
      </div>

      <!-- Contraseña -->
      <div class="mb-3">
        <label for="Contraseña" class="form-label">Contraseña</label>
        <input type="password" name="Contraseña" id="Contraseña" class="form-control"
               value="<?= $usuario['Contraseña'] ?? '' ?>" 
               required pattern="(?=.*[A-Z])(?=.*[0-9]).{6,}" 
               title="Debe tener al menos 6 caracteres, una mayúscula y un número">
      </div>

      <!-- Correo -->
      <div class="mb-3">
        <label for="Correo" class="form-label">Correo</label>
        <input type="email" name="Correo" id="Correo" class="form-control"
               value="<?= $usuario['Correo'] ?? '' ?>" required>
      </div>

      <!-- Teléfono -->
      <div class="mb-3">
        <label for="Telefono" class="form-label">Teléfono</label>
        <input type="tel" name="Telefono" id="Telefono" class="form-control"
               value="<?= $usuario['Telefono'] ?? '' ?>" 
               required pattern="[0-9]{8,15}" 
               title="Debe contener entre 8 y 15 dígitos">
      </div>

      <!-- Rol -->
      <div class="mb-3">
        <label for="Rol_Id" class="form-label">Rol</label>
        <select name="Rol_Id" id="Rol_Id" class="form-select" required>
          <option value="1" <?= (isset($usuario) && $usuario['Rol_Id']==1) ? 'selected' : '' ?>>Administrador</option>
        </select>
      </div>

      <!-- Botón -->
      <button type="submit" class="btn btn-primary">
        <i class="bi <?= isset($usuario) ? 'bi-pencil-square' : 'bi-save' ?>"></i>
        <?= isset($usuario) ? "Actualizar" : "Guardar" ?>
      </button>
      <a href="/index.php?url=Usuario/Index" class="btn btn-secondary">Cancelar</a>
    </form>
  </div>
</div>
