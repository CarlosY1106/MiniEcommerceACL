<?php
namespace Controllers;

class DashboardController {
    public function Index(){
        $pageTitle = "Inicio";
        ob_start();
        require "Views/Dashboard/Index.php";
        $content = ob_get_clean();
        require "Template/Default/Index.php";
    }
}
