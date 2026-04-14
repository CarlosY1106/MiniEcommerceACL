<?php
// Detectar si estamos en local o en hosting
$is_local = ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1' || strpos($_SERVER['HTTP_HOST'], 'localhost') !== false);

if ($is_local) {
    // Configuración para desarrollo local (XAMPP)
    $config = [
        'db_data' => [
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'database' => 'MiniEcommerceACL',
            'port' => '3307',  // Puerto local
            'copyright_holder' => 'Angie Pineda, Carlitos Chávez, Lurvin Ramos',
        ]
    ];
} else {
    // Configuración para producción (InfinityFree)
    $config = [
        'db_data' => [
            'host' => 'sql311.infinityfree.com',
            'username' => 'if0_41646435',
            'password' => 'CarAng1906',
            'database' => 'if0_41646435_miniecommerceacl',
            'port' => '3306',  // Puerto hosting
            'copyright_holder' => 'Angie Pineda, Carlitos Chávez, Lurvin Ramos',
        ]
    ];
}
?>

