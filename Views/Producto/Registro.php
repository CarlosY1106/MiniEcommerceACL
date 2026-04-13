<div class="card shadow-lg">
  <div class="card-header card-header-gradient">
    <i class="bi bi-box-seam me-2"></i> <?= isset($producto) ? "Editar Producto" : "Registrar Producto" ?>
  </div>
  
  <div class="card-body">
    <div class="alert alert-info d-flex align-items-center mb-4">
      <i class="bi bi-info-circle me-2"></i>
      <?= isset($producto) 
          ? "Modifica los campos del producto y guarda los cambios." 
          : "Completa el formulario para registrar un nuevo producto en el sistema." ?>
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
            
            // Validar Precio
            const precio = document.getElementById('Precio');
            if (!precio.value.trim()) {
                errors.push('El precio es obligatorio');
                precio.classList.add('is-invalid');
            } else if (!/^\d+(\.\d{1,2})?$/.test(precio.value) || parseFloat(precio.value) <= 0) {
                errors.push('El precio debe ser un número positivo válido');
                precio.classList.add('is-invalid');
            } else {
                precio.classList.remove('is-invalid');
            }
            
            // Validar Existencia
            const existencia = document.getElementById('Existencia');
            if (!existencia.value.trim()) {
                errors.push('La existencia es obligatoria');
                existencia.classList.add('is-invalid');
            } else if (!/^\d+$/.test(existencia.value) || parseInt(existencia.value) < 0) {
                errors.push('La existencia debe ser un número entero positivo');
                existencia.classList.add('is-invalid');
            } else {
                existencia.classList.remove('is-invalid');
            }
            
            // Validar Categoría
            const categoria = document.getElementById('Categoria_Id');
            if (!categoria.value) {
                errors.push('La categoría es obligatoria');
                categoria.classList.add('is-invalid');
            } else {
                categoria.classList.remove('is-invalid');
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

    <form method="POST" action="/Producto/Registro<?= isset($producto['Id']) ? "?id=".$producto['Id'] : "" ?>">
      
      <!-- Nombre -->
      <div class="mb-3">
        <label for="Nombre" class="form-label">Nombre</label>
        <input type="text" name="Nombre" id="Nombre" class="form-control" 
               value="<?= $producto['Nombre'] ?? '' ?>" 
               required pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s]+" 
               title="Solo letras, números y espacios">
      </div>

      <!-- Precio -->
      <div class="mb-3">
        <label for="Precio" class="form-label">Precio</label>
        <input type="number" step="0.01" name="Precio" id="Precio" class="form-control" 
               value="<?= $producto['Precio'] ?? '' ?>" 
               required pattern="^\d+(\.\d{1,2})?$" 
               title="Número válido con hasta 2 decimales">
      </div>

      <!-- Existencia -->
      <div class="mb-3">
        <label for="Existencia" class="form-label">Existencia</label>
        <input type="number" name="Existencia" id="Existencia" class="form-control" 
               value="<?= $producto['Existencia'] ?? '' ?>" 
               required pattern="^\d+$" 
               title="Debe ser un número entero">
      </div>

      <!-- Categoría -->
      <div class="mb-3">
        <label for="Categoria_Id" class="form-label">Categoría</label>
        <select name="Categoria_Id" id="Categoria_Id" class="form-select" required>
          <option value="">Seleccione una categoría</option>
          <?php foreach($categorias as $cat): ?>
            <option value="<?= $cat['Id'] ?>" 
              <?= (isset($producto) && $producto['Categoria_Id'] == $cat['Id']) ? 'selected' : '' ?>>
              <?= $cat['Nombre'] ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Botón -->
      <button type="submit" class="btn btn-primary">
        <i class="bi <?= isset($producto) ? 'bi-pencil-square' : 'bi-save' ?>"></i>
        <?= isset($producto) ? "Actualizar" : "Guardar" ?>
      </button>
      <a href="/index.php?url=Producto/Index" class="btn btn-secondary">Cancelar</a>
    </form>
  </div>
</div>
