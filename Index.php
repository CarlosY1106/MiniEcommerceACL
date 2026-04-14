<?php
// Mostrar errores en desarrollo
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Requerir configuración y servidor
require_once "Config/Config.php";
require_once "Config/Conexion.php";
require_once "Server/AutoLoad.php";
require_once "Server/JRouter.php";
require_once "Server/JRequest.php";

// Iniciar sesión
session_start();

// Obtener URL desde parámetro GET
$url = isset($_GET['url']) ? $_GET['url'] : "Usuario/Login";

// Usar router para despachar controlador y método
$router = new \Server\JRouter();
$router->dispatch($url);
