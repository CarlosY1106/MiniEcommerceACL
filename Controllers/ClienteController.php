<?php
namespace Controllers;
use \Models\Cliente as Cliente;

class ClienteController {
    private $data;

    public function __construct(){
        $this->data = new Cliente();
    }

    // Listado de clientes
    public function Index(){
        $clientes = $this->data->getAll();
        $pageTitle = "Clientes";
        ob_start();
        require "Views/Cliente/Index.php";
        $content = ob_get_clean();
        require "Template/Default/Index.php";
    }

    // Registrar o editar cliente
    public function Registro(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $datos = [
                'Nombre'            => $_POST['Nombre'],
                'Direccion'         => $_POST['Direccion'],
                'Telefono'          => $_POST['Telefono'],
                'Correo'            => $_POST['Correo'],
                'Estado'            => $_POST['Estado'],
                'DocumentoIdentidad'=> $_POST['DocumentoIdentidad'],
                'Observaciones'     => $_POST['Observaciones']
            ];

            // Validaciones en servidor
            if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/", $datos['Nombre'])) {
                $error = "El nombre solo puede contener letras y espacios.";
            } elseif (!preg_match("/^[0-9]{8,15}$/", $datos['Telefono'])) {
                $error = "El teléfono debe tener entre 8 y 15 dígitos.";
            } elseif (!filter_var($datos['Correo'], FILTER_VALIDATE_EMAIL)) {
                $error = "El correo no tiene un formato válido.";
            } elseif (!preg_match("/^[0-9A-Za-z-]{6,20}$/", $datos['DocumentoIdentidad'])) {
                $error = "El documento debe tener entre 6 y 20 caracteres alfanuméricos.";
            }

            if (isset($error)) {
                $cliente = $datos;
                $pageTitle = isset($_GET['id']) ? "Editar Cliente" : "Registrar Cliente";
                ob_start();
                require "Views/Cliente/Registro.php";
                $content = ob_get_clean();
                require "Template/Default/Index.php";
                return;
            }

            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $this->data->update($_GET['id'], $datos);
            } else {
                $this->data->insert($datos);
            }

            header("Location: /Cliente/Index");
            exit;
        }

        $cliente = null;
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $cliente = $this->data->getById($_GET['id']);
        }

        $pageTitle = isset($cliente) ? "Editar Cliente" : "Registrar Cliente";
        ob_start();
        require "Views/Cliente/Registro.php";
        $content = ob_get_clean();
        require "Template/Default/Index.php";
    }

    // Eliminar cliente
    public function Delete(){
        if (isset($_GET['id'])) {
            $this->data->delete($_GET['id']);
        }
        header("Location: /Cliente/Index");
        exit;
    }
}
