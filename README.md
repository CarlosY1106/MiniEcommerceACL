# MiniEcommerceACL

Un sistema de e-commerce minimalista desarrollado en PHP con arquitectura MVC y control de acceso basado en listas de control (ACL).

## Características

- **Arquitectura MVC**: Separación clara entre Modelo, Vista y Controlador
- **Sistema de ACL**: Control de acceso granular basado en roles y permisos
- **Conexión PDO**: Base de datos segura con prepared statements
- **Router personalizado**: Sistema de enrutamiento URL amigable
- **Auto-carga de clases**: Gestión automática de dependencias

## Estructura del Proyecto

```
MiniEcommerceACL/
|-- Config/              # Configuración y conexión a base de datos
|-- Controllers/         # Controladores de la aplicación
|-- Models/             # Modelos de datos
|-- Views/              # Vistas de la aplicación
|-- Server/             # Clases del servidor (Router, AutoLoad, Request)
|-- Content/            # Assets públicos (CSS, JS, imágenes)
|-- Styles/             # Hojas de estilo
|-- Script/             # Scripts JavaScript
|-- Template/           # Plantillas base
|-- Images/             # Imágenes del proyecto
|-- libraries/          # Librerías adicionales
```

## Requisitos

- PHP 7.4 o superior
- MySQL/MariaDB
- Servidor web (Apache/Nginx)
- XAMPP (opcional, para desarrollo local)

## Instalación

1. Clonar el repositorio:
```bash
git clone https://github.com/CarlosY1106/MiniEcommerceACL.git
```

2. Configurar la base de datos:
   - Crear la base de datos `MiniEcommerceACL`
   - Importar el esquema desde el archivo SQL (si está disponible)

3. Configurar la conexión:
   - Editar `Config/Config.php` con sus credenciales de base de datos
   - Ajustar el puerto si es necesario (por defecto: 3307)

4. Configurar el servidor web:
   - Asegurar que el document root apunte a la carpeta del proyecto
   - Configurar URL rewriting si es necesario

## Configuración

### Base de Datos
Edita `Config/Config.php` para ajustar los parámetros de conexión:

```php
$config = [
    'db_data' => [
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'MiniEcommerceACL',
        'port' => '3307',
    ]
];
```

## Uso

El sistema utiliza un router basado en URL amigables. Las URLs siguen el patrón:
```
http://dominio.com/Controlador/Método/Parámetros
```

Por ejemplo:
- `http://localhost/MiniEcommerceACL/Usuario/Login` - Página de login
- `http://localhost/MiniEcommerceACL/Producto/Index` - Listado de productos

## Autores

- **Angie Pineda** - Desarrolladora
- **Carlitos Chávez** - Desarrollador
- **Lurvin Ramos** - Desarrollador

## Licencia

Este proyecto está bajo la Licencia MIT.

## Contribuciones

Las contribuciones son bienvenidas. Por favor, sigue los siguientes pasos:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/NuevaCaracteristica`)
3. Commit tus cambios (`git commit -m 'Añadir nueva característica'`)
4. Push a la rama (`git push origin feature/NuevaCaracteristica`)
5. Abre un Pull Request

## Estado del Proyecto

Este es un proyecto educativo/demostrativo de un sistema de e-commerce con control de acceso.
