<?php
spl_autoload_register(function($class){
    // Convertir namespace a ruta
    $class = str_replace("\\", "/", $class);
    $path = $class . ".php";

    if(file_exists($path)){
        require_once $path;
    }
});