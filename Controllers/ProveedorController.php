<?php
namespace Controllers;
use \Models\Proveedor as Proveedor;

class ProveedorController {
    private $data;

    public function __construct(){
        $this->data = new Proveedor();
    }

    // Listado de proveedores
    public function Index(){
        $categoriaId = isset($_GET['categoria']) ? $_GET['categoria'] : null;
        $proveedores = $this->data->getAll($categoriaId);
        $categorias = $this->data->getAllCategories();
        $pageTitle = "Proveedores";
        ob_start();
        require "Views/Proveedor/Index.php";
        $content = ob_get_clean();
        require "Template/Default/Index.php";
    }

    // Registrar o editar proveedor
    public function Registro(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $datos = [
                'Nombre'            => $_POST['Nombre'],
                'Telefono'          => $_POST['Telefono'],
                'Correo'            => $_POST['Correo'],
                'Direccion'         => $_POST['Direccion'],
                'Estado'            => $_POST['Estado'],
                'ContactoPrincipal' => $_POST['ContactoPrincipal'],
                'Observaciones'     => $_POST['Observaciones']
            ];

            // Validaciones en servidor
            if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/", $datos['Nombre'])) {
                $error = "El nombre solo puede contener letras y espacios.";
            } elseif (!preg_match("/^[0-9]{8,15}$/", $datos['Telefono'])) {
                $error = "El teléfono debe tener entre 8 y 15 dígitos.";
            } elseif (!filter_var($datos['Correo'], FILTER_VALIDATE_EMAIL)) {
                $error = "El correo no tiene un formato válido.";
            } elseif (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/", $datos['ContactoPrincipal'])) {
                $error = "El contacto principal solo puede contener letras y espacios.";
            }

            if (isset($error)) {
                $proveedor = $datos;
                $pageTitle = isset($_GET['id']) ? "Editar Proveedor" : "Registrar Proveedor";
                ob_start();
                require "Views/Proveedor/Registro.php";
                $content = ob_get_clean();
                require "Template/Default/Index.php";
                return;
            }

            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $this->data->update($_GET['id'], $datos);
            } else {
                $this->data->insert($datos);
            }

            header("Location: /Proveedor/Index");
            exit;
        }

        $proveedor = null;
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $proveedor = $this->data->getById($_GET['id']);
        }

        $pageTitle = isset($proveedor) ? "Editar Proveedor" : "Registrar Proveedor";
        ob_start();
        require "Views/Proveedor/Registro.php";
        $content = ob_get_clean();
        require "Template/Default/Index.php";
    }

    // Eliminar proveedor
    public function Delete(){
        if (isset($_GET['id'])) {
            $this->data->delete($_GET['id']);
        }
        header("Location: /Proveedor/Index");
        exit;
    }
}
