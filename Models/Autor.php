<?php
namespace Models;

class Autor {
    // Retorna un arreglo con los autores
    public function getAll(){
        return [
            [
                'Nombre' => 'Carlos Chávez',
                'Rol'    => 'Desarrollador Principal',
                'Foto'   => '/Images/FotoC.jpg',
                'Descripcion' => 'Responsable del desarrollo backend y la lógica principal del sistema.'
            ],
            [
                'Nombre' => 'Angie Pineda',
                'Rol'    => 'Diseñadora Frontend',
                'Foto'   => '/Images/FotoA.jpg',
                'Descripcion' => 'Encargada del diseño visual, estilos y experiencia de usuario.'
            ],
            [
                'Nombre' => 'Lurvin Ramos',
                'Rol'    => 'Base de Datos y Documentación',
                'Foto'   => '/Images/FotoL.jpg',
                'Descripcion' => 'Responsable de la estructura de la base de datos y documentación técnica.'
            ]
        ];
    }
}
