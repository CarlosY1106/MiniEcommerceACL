<?php
namespace Controllers;
use \Models\Autor as Autor;

class AutoresController {
    private $data;

    public function __construct(){
        $this->data = new Autor();
    }

    // Mostrar autores
    public function Index(){
        $autores = $this->data->getAll();
        $pageTitle = "Autores del Proyecto";
        ob_start();
        require "Views/Autores/Index.php";
        $content = ob_get_clean();
        require "Template/Default/Index.php";
    }
}
