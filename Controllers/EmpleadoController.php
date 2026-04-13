<?php
namespace Controllers;
use \Models\Empleado as Empleado;

class EmpleadoController {
    private $data;

    public function __construct(){
        $this->data = new Empleado();
    }

    // Listado de empleados
    public function Index(){
        $empleados = $this->data->getAll();
        $pageTitle = "Empleados";
        ob_start();
        require "Views/Empleado/Index.php";
        $content = ob_get_clean();
        require "Template/Default/Index.php";
    }

    // Registrar o editar empleado
    public function Registro(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $datos = [
                'Nombre'        => $_POST['Nombre'],
                'Cargo'         => $_POST['Cargo'],
                'Salario'       => $_POST['Salario'],
                'Telefono'      => $_POST['Telefono'],
                'Correo'        => $_POST['Correo'],
                'Estado'        => $_POST['Estado'],
                'FechaIngreso'  => $_POST['FechaIngreso'],
                'Observaciones' => $_POST['Observaciones']
            ];

            // Validaciones en servidor
            if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/", $datos['Nombre'])) {
                $error = "El nombre solo puede contener letras y espacios.";
            } elseif (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/", $datos['Cargo'])) {
                $error = "El cargo solo puede contener letras y espacios.";
            } elseif (!preg_match("/^\d+(\.\d{1,2})?$/", $datos['Salario'])) {
                $error = "El salario debe ser un número válido con hasta 2 decimales.";
            } elseif (!preg_match("/^[0-9]{8,15}$/", $datos['Telefono'])) {
                $error = "El teléfono debe tener entre 8 y 15 dígitos.";
            } elseif (!filter_var($datos['Correo'], FILTER_VALIDATE_EMAIL)) {
                $error = "El correo no tiene un formato válido.";
            } elseif (empty($datos['FechaIngreso'])) {
                $error = "Debe ingresar la fecha de ingreso.";
            }

            if (isset($error)) {
                $empleado = $datos;
                $pageTitle = isset($_GET['id']) ? "Editar Empleado" : "Registrar Empleado";
                ob_start();
                require "Views/Empleado/Registro.php";
                $content = ob_get_clean();
                require "Template/Default/Index.php";
                return;
            }

            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $this->data->update($_GET['id'], $datos);
            } else {
                $this->data->insert($datos);
            }

            header("Location: /Empleado/Index");
            exit;
        }

        $empleado = null;
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $empleado = $this->data->getById($_GET['id']);
        }

        $pageTitle = isset($empleado) ? "Editar Empleado" : "Registrar Empleado";
        ob_start();
        require "Views/Empleado/Registro.php";
        $content = ob_get_clean();
        require "Template/Default/Index.php";
    }

    // Eliminar empleado
    public function Delete(){
        if (isset($_GET['id'])) {
            $this->data->delete($_GET['id']);
        }
        header("Location: /Empleado/Index");
        exit;
    }
}
