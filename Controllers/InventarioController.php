<?php
namespace Controllers;
use \Models\Inventario as Inventario;

class InventarioController {
    private $data;

    public function __construct(){
        $this->data = new Inventario();
    }

    // Listado de inventario
    public function Index(){
        // Verificar si hay una búsqueda por nombre
        $busqueda = $_GET['busqueda'] ?? '';
        
        if (!empty($busqueda)) {
            $inventarios = $this->data->searchByNombre($busqueda);
        } else {
            $inventarios = $this->data->getAll();
        }
        
        $pageTitle = "Inventario";
        ob_start();
        require "Views/Inventario/Index.php";
        $content = ob_get_clean();
        require "Template/Default/Index.php";
    }

    // Registrar o editar inventario
    public function Registro(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $datos = [
                'Nombre'        => $_POST['Nombre'],
                'Producto'      => $_POST['Producto'],
                'Cantidad'      => $_POST['Cantidad'],
                'Ubicacion'     => $_POST['Ubicacion'],
                'Estado'        => $_POST['Estado'],
                'Responsable'   => $_POST['Responsable'],
                'Observaciones' => $_POST['Observaciones']
            ];

            // Validaciones en servidor
            $errores = [];
            
            if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/", $datos['Nombre'])) {
                $errores[] = "El nombre solo puede contener letras y espacios.";
            }
            if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s]+$/", $datos['Producto'])) {
                $errores[] = "El producto solo puede contener letras, números y espacios.";
            }
            if (!preg_match("/^\d+$/", $datos['Cantidad'])) {
                $errores[] = "La cantidad debe ser un número entero.";
            }
            if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/", $datos['Responsable'])) {
                $errores[] = "El responsable solo puede contener letras y espacios.";
            }

            // Validar duplicados
            try {
                if (isset($_GET['id']) && !empty($_GET['id'])) {
                    $this->data->update($_GET['id'], $datos);
                } else {
                    $this->data->insert($datos);
                }
                header("Location: /Inventario/Index");
                exit;
            } catch (\Exception $e) {
                $erroresDuplicados = explode('|', $e->getMessage());
                $errores = array_merge($errores, $erroresDuplicados);
            }

            if (!empty($errores)) {
                $inventario = $datos;
                $error = implode('<br>', $errores);
                $pageTitle = isset($_GET['id']) ? "Editar Inventario" : "Registrar Inventario";
                ob_start();
                require "Views/Inventario/Registro.php";
                $content = ob_get_clean();
                require "Template/Default/Index.php";
                return;
            }

            header("Location: /Inventario/Index");
            exit;
        }

        $inventario = null;
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $inventario = $this->data->getById($_GET['id']);
        }

        $pageTitle = isset($inventario) ? "Editar Inventario" : "Registrar Inventario";
        ob_start();
        require "Views/Inventario/Registro.php";
        $content = ob_get_clean();
        require "Template/Default/Index.php";
    }

    // Eliminar inventario
    public function Delete(){
        if (isset($_GET['id'])) {
            $this->data->delete($_GET['id']);
        }
        header("Location: /Inventario/Index");
        exit;
    }
}
