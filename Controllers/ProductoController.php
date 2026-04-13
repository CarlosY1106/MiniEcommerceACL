<?php
namespace Controllers;
use \Models\Producto as Producto;

class ProductoController {
    private $data;

    public function __construct(){
        $this->data = new Producto();
    }

    // Listado de productos con filtro por categoría
    public function Index(){
        $categoriaId = $_GET['categoria'] ?? null;

        if ($categoriaId) {
            $productos = $this->data->getByCategoria($categoriaId);
        } else {
            $productos = $this->data->getAll();
        }

        // Traer todas las categorías para el select
        $categorias = $this->data->getCategorias();

        $pageTitle = "Productos";
        ob_start();
        require "Views/Producto/Index.php";
        $content = ob_get_clean();
        require "Template/Default/Index.php";
    }

    // Registrar o editar producto
    public function Registro(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $datos = [
                'Nombre'       => $_POST['Nombre'],
                'Precio'       => $_POST['Precio'],
                'Existencia'   => $_POST['Existencia'],
                'Categoria_Id' => $_POST['Categoria_Id']
            ];

            // Validaciones en servidor
            if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s]+$/", $datos['Nombre'])) {
                $error = "El nombre solo puede contener letras, números y espacios.";
            } elseif (!preg_match("/^\d+(\.\d{1,2})?$/", $datos['Precio'])) {
                $error = "El precio debe ser un número válido con hasta 2 decimales.";
            } elseif (!preg_match("/^\d+$/", $datos['Existencia'])) {
                $error = "La existencia debe ser un número entero.";
            } elseif (empty($datos['Categoria_Id'])) {
                $error = "Debe seleccionar una categoría.";
            }

            if (isset($error)) {
                $producto = $datos;
                $categorias = $this->data->getCategorias();
                $pageTitle = isset($_GET['id']) ? "Editar Producto" : "Registrar Producto";
                ob_start();
                require "Views/Producto/Registro.php";
                $content = ob_get_clean();
                require "Template/Default/Index.php";
                return;
            }

            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $this->data->update($datos, $_GET['id']);
            } else {
                $this->data->insert($datos);
            }

            header("Location: /Producto/Index");
            exit;
        }

        $producto = null;
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $producto = $this->data->getForId($_GET['id']);
        }

        // Traer categorías para el select en el formulario
        $categorias = $this->data->getCategorias();

        $pageTitle = isset($producto) ? "Editar Producto" : "Registrar Producto";
        ob_start();
        require "Views/Producto/Registro.php";
        $content = ob_get_clean();
        require "Template/Default/Index.php";
    }

    // Eliminar producto
    public function Delete(){
        if (isset($_GET['id'])) {
            $this->data->delete($_GET['id']);
        }
        header("Location: /Producto/Index");
        exit;
    }
}
?>
