<?php
namespace Server;

class JRouter {
    public function dispatch($url){
        // Sanitizar y validar la URL
        $url = filter_var($url, FILTER_SANITIZE_STRING);
        $parts = explode("/", $url);

        // Validar nombre del controlador y método
        $controllerName = isset($parts[0]) ? ucfirst(preg_replace('/[^a-zA-Z0-9]/', '', $parts[0])) . "Controller" : "DashboardController";
        $method = isset($parts[1]) ? preg_replace('/[^a-zA-Z0-9]/', '', $parts[1]) : "Index";

        // Verificar autenticación - todas las rutas excepto login requieren sesión
        if (!$this->isPublicRoute($controllerName, $method)) {
            if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
                // Redirigir al login si no hay sesión activa
                header("Location: /Usuario/Login");
                exit();
            }
        }

        $controllerClass = "\\Controllers\\" . $controllerName;

        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();
            if (method_exists($controller, $method)) {
                // Ejecutar método de forma segura
                call_user_func([$controller, $method]);
            } else {
                http_response_code(404);
                echo "Método <b>$method</b> no encontrado en <b>$controllerName</b>";
            }
        } else {
            http_response_code(404);
            echo "Controlador <b>$controllerName</b> no encontrado";
        }
    }

    /**
     * Verifica si la ruta es pública (no requiere autenticación)
     */
    private function isPublicRoute($controllerName, $method) {
        // Rutas públicas permitidas sin autenticación
        $publicRoutes = [
            'UsuarioController' => ['Login'],
            // Agregar aquí otras rutas públicas si es necesario
        ];

        // Verificar si el controlador y método están en las rutas públicas
        if (isset($publicRoutes[$controllerName])) {
            return in_array($method, $publicRoutes[$controllerName]);
        }

        return false;
    }
}
