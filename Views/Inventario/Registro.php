<div class="card shadow-lg">
  <div class="card-header card-header-gradient">
    <i class="bi bi-box-seam me-2"></i> <?= isset($inventario) ? "Editar Inventario" : "Registrar Inventario" ?>
  </div>
  
  <div class="card-body">
    <div class="alert alert-info d-flex align-items-center mb-4">
      <i class="bi bi-info-circle me-2"></i>
      <?= isset($inventario) 
          ? "Modifica los campos del inventario y guarda los cambios." 
          : "Completa el formulario para registrar un nuevo inventario en el sistema." ?>
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
            
            // Validar Producto
            const producto = document.getElementById('Producto');
            if (!producto.value.trim()) {
                errors.push('El producto es obligatorio');
                producto.classList.add('is-invalid');
            } else if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s]+$/.test(producto.value)) {
                errors.push('El producto solo puede contener letras, números y espacios');
                producto.classList.add('is-invalid');
            } else {
                producto.classList.remove('is-invalid');
            }
            
            // Validar Cantidad
            const cantidad = document.getElementById('Cantidad');
            if (!cantidad.value.trim()) {
                errors.push('La cantidad es obligatoria');
                cantidad.classList.add('is-invalid');
            } else if (!/^\d+$/.test(cantidad.value) || parseInt(cantidad.value) < 0) {
                errors.push('La cantidad debe ser un número entero positivo');
                cantidad.classList.add('is-invalid');
            } else {
                cantidad.classList.remove('is-invalid');
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

    <form method="POST" action="/Inventario/Registro<?= isset($inventario['Id']) ? "?id=".$inventario['Id'] : "" ?>">
      
      <!-- Nombre -->
      <div class="mb-3">
        <label for="Nombre" class="form-label">Nombre</label>
        <input type="text" name="Nombre" id="Nombre" class="form-control" 
               value="<?= $inventario['Nombre'] ?? '' ?>" 
               required pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" 
               title="Solo letras y espacios">
      </div>

      <!-- Producto -->
      <div class="mb-3">
        <label for="Producto" class="form-label">Producto</label>
        <input type="text" name="Producto" id="Producto" class="form-control" 
               value="<?= $inventario['Producto'] ?? '' ?>" 
               required pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s]+" 
               title="Solo letras, números y espacios">
      </div>

      <!-- Cantidad -->
      <div class="mb-3">
        <label for="Cantidad" class="form-label">Cantidad</label>
        <input type="number" name="Cantidad" id="Cantidad" class="form-control" 
               value="<?= $inventario['Cantidad'] ?? '' ?>" 
               required pattern="^\d+$" 
               title="Debe ser un número entero">
      </div>

      <!-- Ubicación -->
      <div class="mb-3">
        <label for="Ubicacion" class="form-label">Ubicación</label>
        <input type="text" name="Ubicacion" id="Ubicacion" class="form-control" 
               value="<?= $inventario['Ubicacion'] ?? '' ?>">
      </div>

      <!-- Estado -->
      <div class="mb-3">
        <label for="Estado" class="form-label">Estado</label>
        <select name="Estado" id="Estado" class="form-select">
          <option value="Disponible" <?= (isset($inventario) && $inventario['Estado']=="Disponible") ? "selected" : "" ?>>Disponible</option>
          <option value="Agotado" <?= (isset($inventario) && $inventario['Estado']=="Agotado") ? "selected" : "" ?>>Agotado</option>
          <option value="Reservado" <?= (isset($inventario) && $inventario['Estado']=="Reservado") ? "selected" : "" ?>>Reservado</option>
        </select>
      </div>

      <!-- Responsable -->
      <div class="mb-3">
        <label for="Responsable" class="form-label">Responsable</label>
        <input type="text" name="Responsable" id="Responsable" class="form-control" 
               value="<?= $inventario['Responsable'] ?? '' ?>" 
               required pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" 
               title="Solo letras y espacios">
      </div>

      <!-- Observaciones -->
      <div class="mb-3">
        <label for="Observaciones" class="form-label">Observaciones</label>
        <textarea name="Observaciones" id="Observaciones" class="form-control"><?= $inventario['Observaciones'] ?? '' ?></textarea>
      </div>

      <!-- Botones -->
      <button type="submit" class="btn btn-primary">
        <i class="bi <?= isset($inventario) ? 'bi-pencil-square' : 'bi-save' ?>"></i>
        <?= isset($inventario) ? "Actualizar" : "Guardar" ?>
      </button>
      <a href="/index.php?url=Inventario/Index" class="btn btn-secondary">Cancelar</a>
    </form>
  </div>
</div>
