<?php
namespace Controllers;
use \Models\Sucursal as Sucursal;

class SucursalController {
    private $data;

    public function __construct(){
        $this->data = new Sucursal();
    }

    // Listado de sucursales
    public function Index(){
        $sucursales = $this->data->getAll();
        $pageTitle = "Sucursales";
        ob_start();
        require "Views/Sucursal/Index.php";
        $content = ob_get_clean();
        require "Template/Default/Index.php";
    }

    // Registrar o editar sucursal
    public function Registro(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $datos = [
                'Nombre'        => $_POST['Nombre'],
                'Direccion'     => $_POST['Direccion'],
                'Telefono'      => $_POST['Telefono'],
                'Correo'        => $_POST['Correo'],
                'Estado'        => $_POST['Estado'],
                'FechaApertura' => $_POST['FechaApertura'],
                'Responsable'   => $_POST['Responsable'],
                'Observaciones' => $_POST['Observaciones']
            ];

            // Validaciones en servidor
            if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/", $datos['Nombre'])) {
                $error = "El nombre solo puede contener letras y espacios.";
            } elseif (!preg_match("/^[0-9]{8,15}$/", $datos['Telefono'])) {
                $error = "El teléfono debe tener entre 8 y 15 dígitos.";
            } elseif (!filter_var($datos['Correo'], FILTER_VALIDATE_EMAIL)) {
                $error = "El correo no tiene un formato válido.";
            } elseif (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/", $datos['Responsable'])) {
                $error = "El responsable solo puede contener letras y espacios.";
            } elseif (empty($datos['FechaApertura'])) {
                $error = "Debe ingresar la fecha de apertura.";
            }

            if (isset($error)) {
                $sucursal = $datos;
                $pageTitle = isset($_GET['id']) ? "Editar Sucursal" : "Registrar Sucursal";
                ob_start();
                require "Views/Sucursal/Registro.php";
                $content = ob_get_clean();
                require "Template/Default/Index.php";
                return;
            }

            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $this->data->update($_GET['id'], $datos);
            } else {
                $this->data->insert($datos);
            }

            header("Location: /Sucursal/Index");
            exit;
        }

        $sucursal = null;
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $sucursal = $this->data->getById($_GET['id']);
        }

        $pageTitle = isset($sucursal) ? "Editar Sucursal" : "Registrar Sucursal";
        ob_start();
        require "Views/Sucursal/Registro.php";
        $content = ob_get_clean();
        require "Template/Default/Index.php";
    }

    // Eliminar sucursal
    public function Delete(){
        if (isset($_GET['id'])) {
            $this->data->delete($_GET['id']);
        }
        header("Location: /Sucursal/Index");
        exit;
    }
}
