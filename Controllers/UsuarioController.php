<?php
namespace Controllers;
use \Models\Usuario as Usuario;

class UsuarioController {
    private $data;

    public function __construct(){
        $this->data = new Usuario();
    }

    // Mostrar login y procesar acceso
    public function Login(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario    = $_POST['NombreUsuario'];
            $contraseña = $_POST['Contraseña'];

            $user = $this->data->verificarLogin($usuario, $contraseña);

            if ($user) {
                session_start();
                $_SESSION['usuario'] = $user;
                $_SESSION['nombre_usuario'] = $user->NombreUsuario;
                $_SESSION['rol']     = $user->Rol_Id;

                header("Location: /Dashboard/Index");
                exit;
            } else {
                $error = "Usuario o contraseña incorrectos.";
                $pageTitle = "Iniciar Sesión";
                ob_start();
                require "Views/Usuario/Login.php";
                $content = ob_get_clean();
                require "Template/Default/Index.php";
                return;
            }
        }

        $pageTitle = "Iniciar Sesión";
        ob_start();
        require "Views/Usuario/Login.php";
        $content = ob_get_clean();
        require "Template/Default/Index.php";
    }

    // Cerrar sesión
    public function Logout(){
        session_start();
        session_destroy();
        header("Location: /Usuario/Login");
        exit;
    }

    // Listado de usuarios
    public function Index(){
        $usuarios = $this->data->getAll();
        $pageTitle = "Usuarios";
        ob_start();
        require "Views/Usuario/Index.php";
        $content = ob_get_clean();
        require "Template/Default/Index.php";
    }

    // Registrar o editar usuario
    public function Registro(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $datos = [
                'NombreUsuario' => $_POST['NombreUsuario'],
                'Contraseña'    => $_POST['Contraseña'],
                'Correo'        => $_POST['Correo'],
                'Telefono'      => $_POST['Telefono'],
                'Rol_Id'        => $_POST['Rol_Id']
            ];

            // Validaciones en servidor
            if (!preg_match("/^[A-Za-z0-9_]{4,20}$/", $datos['NombreUsuario'])) {
                $error = "El usuario debe tener entre 4 y 20 caracteres, solo letras, números y guiones bajos.";
            } elseif (!preg_match("/^(?=.*[A-Z])(?=.*[0-9]).{6,}$/", $datos['Contraseña'])) {
                $error = "La contraseña debe tener al menos 6 caracteres, una mayúscula y un número.";
            } elseif (!filter_var($datos['Correo'], FILTER_VALIDATE_EMAIL)) {
                $error = "El correo no tiene un formato válido.";
            } elseif (!preg_match("/^[0-9]{8,15}$/", $datos['Telefono'])) {
                $error = "El teléfono debe tener entre 8 y 15 dígitos.";
            }

            if (isset($error)) {
                $usuario = $datos;
                $pageTitle = isset($_GET['id']) ? "Editar Usuario" : "Registrar Usuario";
                ob_start();
                require "Views/Usuario/Registro.php";
                $content = ob_get_clean();
                require "Template/Default/Index.php";
                return;
            }

            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $this->data->update($datos, $_GET['id']);
            } else {
                $this->data->insert($datos);
            }

            header("Location: /Usuario/Index");
            exit;
        }

        $usuario = null;
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $usuario = $this->data->getForId($_GET['id']);
        }

        $pageTitle = isset($usuario) ? "Editar Usuario" : "Registrar Usuario";
        ob_start();
        require "Views/Usuario/Registro.php";
        $content = ob_get_clean();
        require "Template/Default/Index.php";
    }

    // Eliminar usuario
    public function Delete(){
        if (isset($_GET['id'])) {
            $this->data->delete($_GET['id']);
        }
        header("Location: /Usuario/Index");
        exit;
    }
}
