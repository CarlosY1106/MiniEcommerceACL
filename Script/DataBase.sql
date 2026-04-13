-- =====================================================
-- Base de Datos: MiniEcommerceACL
-- Sistema de E-commerce con Control de Acceso Lógico
-- =====================================================

-- Crear base de datos y usarla
-- CREATE DATABASE IF NOT EXISTS MiniEcommerceACL;
-- USE MiniEcommerceACL;

-- =====================================================
-- ESTRUCTURA DE TABLAS
-- =====================================================

-- Tabla de Roles
CREATE TABLE Rol (
  Id INT AUTO_INCREMENT PRIMARY KEY,
  Nombre VARCHAR(50) NOT NULL
);

-- Tabla de Usuarios
CREATE TABLE Usuario (
  Id INT AUTO_INCREMENT PRIMARY KEY,
  NombreUsuario VARCHAR(50) NOT NULL,
  Contraseña VARCHAR(255) NOT NULL,
  Correo VARCHAR(100),
  Telefono VARCHAR(20),
  Rol_Id INT,
  FOREIGN KEY (Rol_Id) REFERENCES Rol(Id)
);

-- Tabla de Direcciones
CREATE TABLE Direccion (
  Id INT AUTO_INCREMENT PRIMARY KEY,
  Usuario_Id INT,
  Calle VARCHAR(100),
  Ciudad VARCHAR(50),
  Departamento VARCHAR(50),
  CodigoPostal VARCHAR(10),
  FOREIGN KEY (Usuario_Id) REFERENCES Usuario(Id)
);

-- Tabla de Categorías
CREATE TABLE Categoria (
  Id INT AUTO_INCREMENT PRIMARY KEY,
  Nombre VARCHAR(50) NOT NULL
);

-- Tabla de Productos
CREATE TABLE Producto (
  Id INT AUTO_INCREMENT PRIMARY KEY,
  Nombre VARCHAR(100) NOT NULL,
  Precio DECIMAL(10,2) NOT NULL,
  Existencia INT NOT NULL,
  Categoria_Id INT,
  FOREIGN KEY (Categoria_Id) REFERENCES Categoria(Id)
);

-- Tabla de Proveedores
CREATE TABLE Proveedor (
  Id INT AUTO_INCREMENT PRIMARY KEY,
  Nombre VARCHAR(150) NOT NULL,
  Telefono VARCHAR(20),
  Correo VARCHAR(100),
  Direccion VARCHAR(200),
  Estado ENUM('Activo','Inactivo') DEFAULT 'Activo',
  FechaRegistro DATETIME DEFAULT CURRENT_TIMESTAMP,
  ContactoPrincipal VARCHAR(100),
  Observaciones TEXT,
  Categoria_Id INT NULL,
  FOREIGN KEY (Categoria_Id) REFERENCES Categoria(Id)
);

-- Tabla de Clientes
CREATE TABLE Cliente (
  Id INT AUTO_INCREMENT PRIMARY KEY,
  Nombre VARCHAR(150) NOT NULL,
  Direccion VARCHAR(200),
  Telefono VARCHAR(20),
  Correo VARCHAR(100),
  Estado ENUM('Activo','Inactivo') DEFAULT 'Activo',
  FechaRegistro DATETIME DEFAULT CURRENT_TIMESTAMP,
  DocumentoIdentidad VARCHAR(50) UNIQUE,
  Observaciones TEXT
);

-- Tabla de Empleados
CREATE TABLE Empleado (
  Id INT AUTO_INCREMENT PRIMARY KEY,
  Nombre VARCHAR(150) NOT NULL,
  Cargo VARCHAR(100),
  Salario DECIMAL(10,2),
  Telefono VARCHAR(20),
  Correo VARCHAR(100),
  Estado ENUM('Activo','Inactivo') DEFAULT 'Activo',
  FechaIngreso DATE,
  Observaciones TEXT
);

-- Tabla de Sucursales
CREATE TABLE Sucursal (
  Id INT AUTO_INCREMENT PRIMARY KEY,
  Nombre VARCHAR(150) NOT NULL,
  Direccion VARCHAR(200),
  Telefono VARCHAR(20),
  Correo VARCHAR(100),
  Estado ENUM('Activo','Inactivo') DEFAULT 'Activo',
  FechaApertura DATE,
  Responsable VARCHAR(100),
  Observaciones TEXT
);

-- Tabla de Inventario
CREATE TABLE Inventario (
  Id INT AUTO_INCREMENT PRIMARY KEY,
  Nombre VARCHAR(150) NOT NULL,          
  Producto VARCHAR(150) NOT NULL,       
  Cantidad INT NOT NULL,                 
  Ubicacion VARCHAR(100),               
  Estado ENUM('Disponible','Agotado','Reservado') DEFAULT 'Disponible',
  FechaRegistro DATETIME DEFAULT CURRENT_TIMESTAMP,
  Responsable VARCHAR(100),              
  Observaciones TEXT                     
);

-- =====================================================
-- INSERCIÓN DE DATOS INICIALES
-- =====================================================

-- Roles del Sistema
INSERT INTO Rol (Nombre) VALUES ('Administrador');

-- Usuarios del Sistema
INSERT INTO Usuario (NombreUsuario, Contraseña, Correo, Telefono, Rol_Id) VALUES
('Carlos_06', 'C123456', 'carlos.chavez@correo.com', '98062155', 1),
('Angie_19', 'A123456', 'angie.pineda@correo.com', '99653958', 1),
('Lurvin_01', 'L123456', 'lurvin.ramos@correo.com', '98363156', 1);

-- Categorías de Productos
INSERT INTO Categoria (Nombre) VALUES
('Informática'),
('Electrónica'),
('Electrodomésticos'),
('Ropa'),
('Accesorios');

-- Productos por Categoría
INSERT INTO Producto (Nombre, Precio, Existencia, Categoria_Id) VALUES
-- Informática
('Laptop Dell Inspiron 15', 750.00, 10, 1),
('Laptop HP Pavilion', 680.00, 8, 1),
('Laptop Lenovo ThinkPad', 900.00, 12, 1),
('Laptop Acer Aspire', 620.00, 6, 1),
('Laptop Asus VivoBook', 700.00, 7, 1),

-- Electrónica
('Monitor LG 24"', 180.00, 15, 2),
('Monitor Samsung 27"', 250.00, 10, 2),
('Televisor Sony 50"', 600.00, 5, 2),
('Monitor Dell 22"', 160.00, 12, 2),
('Televisor LG 42"', 450.00, 7, 2),

-- Electrodomésticos
('Refrigerador Samsung', 1200.00, 5, 3),
('Microondas Panasonic', 180.00, 10, 3),
('Lavadora Whirlpool', 950.00, 4, 3),
('Cafetera Oster', 75.00, 20, 3),
('Licuadora Black+Decker', 60.00, 15, 3),

-- Ropa
('Camisa Azul M', 25.00, 50, 4),
('Pantalón Jeans Levis', 45.00, 30, 4),
('Chaqueta Negra XL', 80.00, 15, 4),
('Zapatos Nike Air', 120.00, 20, 4),
('Gorra Adidas', 20.00, 40, 4),

-- Accesorios
('Bolso de Cuero', 60.00, 20, 5),
('Cinturón de Piel', 35.00, 25, 5),
('Reloj Casio', 50.00, 30, 5),
('Lentes Ray-Ban', 150.00, 10, 5),
('Cartera Fossil', 70.00, 18, 5);

-- Proveedores por Categoría
INSERT INTO Proveedor (Nombre, Telefono, Correo, Direccion, Estado, ContactoPrincipal, Observaciones, Categoria_Id) VALUES
-- Informática
('Tech Import S.A.', '22334455', 'ventas@techimport.com', 'San Pedro Sula', 'Activo', 'Juan Pérez', 'Proveedor principal de laptops', 1),
('Distribuidora LG', '22446688', 'contacto@lgdistrib.com', 'Tegucigalpa', 'Activo', 'María López', 'Proveedor oficial de monitores', 1),
('Redragon Honduras', '22557799', 'info@redragonhn.com', 'La Ceiba', 'Activo', 'Carlos Mejía', 'Distribuidor autorizado de periféricos', 1),
('Logitech Centroamérica', '22668800', 'ventas@logitechca.com', 'San Salvador', 'Activo', 'Ana Torres', 'Proveedor de mouses gamer', 1),
('HyperX Latinoamérica', '22779911', 'support@hyperxlatam.com', 'Ciudad de México', 'Activo', 'Luis García', 'Proveedor de audífonos gamer', 1),

-- Electrónica
('Samsung Honduras', '23336677', 'samsung@hn.com', 'San Pedro Sula', 'Activo', 'Ana Gómez', 'Proveedor de monitores Samsung', 2),
('LG Honduras', '23447788', 'lg@hn.com', 'Tegucigalpa', 'Activo', 'Carlos Pérez', 'Proveedor de televisores LG', 2),
('Sony LATAM', '23558899', 'sony@latam.com', 'Ciudad de México', 'Activo', 'María Torres', 'Proveedor de televisores Sony', 2),
('Dell Monitores', '23669900', 'monitores@dell.com', 'San Salvador', 'Activo', 'Luis Hernández', 'Proveedor de monitores Dell', 2),
('Panasonic Honduras', '23770011', 'panasonic@hn.com', 'La Ceiba', 'Activo', 'Paola Díaz', 'Proveedor de electrónicos Panasonic', 2),

-- Electrodomésticos
('Whirlpool Honduras', '23881122', 'ventas@whirlpoolhn.com', 'San Pedro Sula', 'Activo', 'Roberto Castillo', 'Proveedor de lavadoras Whirlpool', 3),
('Oster Centroamérica', '23992233', 'oster@ca.com', 'Tegucigalpa', 'Activo', 'Laura Méndez', 'Proveedor de licuadoras Oster', 3),
('Mabe LATAM', '24003344', 'mabe@latam.com', 'Ciudad de México', 'Activo', 'Fernando López', 'Proveedor de electrodomésticos Mabe', 3),
('Black+Decker Honduras', '24114455', 'ventas@blackdeckerhn.com', 'San Pedro Sula', 'Activo', 'Patricia Reyes', 'Proveedor de planchas y licuadoras', 3),
('Samsung Electrodomésticos', '24225566', 'electro@samsung.com', 'La Ceiba', 'Activo', 'Ricardo Ramírez', 'Proveedor de refrigeradores Samsung', 3),

-- Ropa
('Levis Honduras', '24336677', 'ventas@levishn.com', 'San Pedro Sula', 'Activo', 'Andrea Gómez', 'Proveedor de jeans Levis', 4),
('Nike Centroamérica', '24447788', 'nike@ca.com', 'Tegucigalpa', 'Activo', 'Daniel Pérez', 'Proveedor de zapatos Nike', 4),
('Adidas LATAM', '24558899', 'adidas@latam.com', 'Ciudad de México', 'Activo', 'Sofía Torres', 'Proveedor de ropa deportiva Adidas', 4),
('Puma Honduras', '24669900', 'ventas@pumahn.com', 'San Salvador', 'Activo', 'Gabriel Hernández', 'Proveedor de gorras Puma', 4),
('Zara Honduras', '24770011', 'zara@hn.com', 'La Ceiba', 'Activo', 'Claudia Díaz', 'Proveedor de ropa Zara', 4),

-- Accesorios
('Ray-Ban Honduras', '24881122', 'ventas@raybanhn.com', 'San Pedro Sula', 'Activo', 'Héctor Castillo', 'Proveedor de lentes Ray-Ban', 5),
('Casio Centroamérica', '24992233', 'casio@ca.com', 'Tegucigalpa', 'Activo', 'Isabel Méndez', 'Proveedor de relojes Casio', 5),
('Fossil LATAM', '25003344', 'fossil@latam.com', 'Ciudad de México', 'Activo', 'Javier López', 'Proveedor de carteras Fossil', 5),
('Gucci Honduras', '25114455', 'ventas@guccihn.com', 'San Pedro Sula', 'Activo', 'Patricia Reyes', 'Proveedor de accesorios Gucci', 5),
('Michael Kors Honduras', '25225566', 'contacto@michaelkorshn.com', 'La Ceiba', 'Activo', 'Ricardo Ramírez', 'Proveedor de bolsos Michael Kors', 5);

-- Empleados
INSERT INTO Empleado (Nombre, Cargo, Salario, Telefono, Correo, Estado, FechaIngreso, Observaciones) VALUES
('José Martínez', 'Vendedor', 8000.00, '98765432', 'jose.martinez@empresa.com', 'Activo', '2024-01-15', 'Empleado con experiencia en ventas'),
('Carla Gómez', 'Soporte Técnico', 9000.00, '99887766', 'carla.gomez@empresa.com', 'Activo', '2024-02-20', 'Especialista en soporte'),
('Mario López', 'Administrador', 12000.00, '91234567', 'mario.lopez@empresa.com', 'Activo', '2024-03-10', 'Encargado de administración'),
('Lucía Torres', 'Marketing', 9500.00, '93456789', 'lucia.torres@empresa.com', 'Activo', '2024-04-05', 'Encargada de campañas'),
('Andrés Díaz', 'Inventario', 8500.00, '94567890', 'andres.diaz@empresa.com', 'Activo', '2024-05-01', 'Responsable de inventario');

-- Clientes
INSERT INTO Cliente (Nombre, Direccion, Telefono, Correo, Estado, DocumentoIdentidad, Observaciones) VALUES
('Pedro Martínez', 'Barrio Abajo, SPS', '98765432', 'pedro.martinez@gmail.com', 'Activo', '0801199912345', 'Cliente frecuente'),
('Laura Gómez', 'Col. Trejo, SPS', '99887766', 'laura.gomez@hotmail.com', 'Activo', '0801200012346', 'Cliente nuevo'),
('José Hernández', 'Col. Fesitranh, SPS', '91234567', 'jose.hernandez@yahoo.com', 'Activo', '0801199812347', 'Cliente mayorista'),
('Ana Castillo', 'Col. Satélite, SPS', '93456789', 'ana.castillo@gmail.com', 'Activo', '0801199712348', 'Cliente VIP'),
('Carlos López', 'Col. Jardines, SPS', '94567890', 'carlos.lopez@gmail.com', 'Activo', '0801699123497', 'Cliente frecuente'),
('Juan Castillo', 'Barrio Abajo, SPS', '98765432', 'juan.castillo@correo.com', 'Activo', '0801199912349', 'Cliente frecuente'),
('María Hernández', 'Colonia Miraflores, Tegucigalpa', '99887766', 'maria.hernandez@correo.com', 'Activo', '0801199823450', 'Prefiere compras online'),
('Pedro López', 'La Ceiba', '91234567', 'pedro.lopez@correo.com', 'Activo', '0801199734561', 'Cliente mayorista'),
('Ana Torres', 'San Pedro Sula', '93456789', 'ana.torres@correo.com', 'Activo', '0801199645672', 'Cliente VIP'),
('Luis García', 'Santa Bárbara', '94567890', 'luis.garcia@correo.com', 'Activo', '0801199556793', 'Cliente nuevo');

-- Inventario por Categoría
INSERT INTO Inventario (Nombre, Producto, Cantidad, Ubicacion, Estado, Responsable, Observaciones) VALUES
-- Informática
('Inventario Laptops Dell', 'Laptop Dell Inspiron 15', 10, 'Bodega SPS', 'Disponible', 'Juan Pérez', 'Stock inicial'),
('Inventario Laptops HP', 'Laptop HP Pavilion', 8, 'Bodega SPS', 'Disponible', 'María López', 'Ingreso nuevo'),
('Inventario Laptops Lenovo', 'Laptop Lenovo ThinkPad', 12, 'Bodega SPS', 'Disponible', 'Carlos Mejía', 'Stock inicial'),
('Inventario Laptops Acer', 'Laptop Acer Aspire', 6, 'Bodega SPS', 'Disponible', 'Ana Torres', 'Ingreso nuevo'),
('Inventario Laptops Asus', 'Laptop Asus VivoBook', 7, 'Bodega SPS', 'Disponible', 'Luis García', 'Stock inicial'),

-- Electrónica
('Inventario Monitores LG', 'Monitor LG 24"', 15, 'Bodega SPS', 'Disponible', 'Juan Pérez', 'Stock inicial'),
('Inventario Monitores Samsung', 'Monitor Samsung 27"', 10, 'Bodega SPS', 'Disponible', 'María López', 'Ingreso nuevo'),
('Inventario Televisores Sony', 'Televisor Sony 50"', 5, 'Bodega SPS', 'Disponible', 'Carlos Mejía', 'Stock inicial'),
('Inventario Monitores Dell', 'Monitor Dell 22"', 12, 'Bodega SPS', 'Disponible', 'Ana Torres', 'Ingreso nuevo'),
('Inventario Televisores LG', 'Televisor LG 42"', 7, 'Bodega SPS', 'Disponible', 'Luis García', 'Stock inicial'),

-- Electrodomésticos
('Inventario Refrigeradores', 'Refrigerador Samsung', 5, 'Bodega SPS', 'Disponible', 'Juan Pérez', 'Stock inicial'),
('Inventario Microondas', 'Microondas Panasonic', 10, 'Bodega SPS', 'Disponible', 'María López', 'Ingreso nuevo'),
('Inventario Lavadoras', 'Lavadora Whirlpool', 4, 'Bodega SPS', 'Disponible', 'Carlos Mejía', 'Stock inicial'),
('Inventario Cafeteras', 'Cafetera Oster', 20, 'Bodega SPS', 'Disponible', 'Ana Torres', 'Ingreso nuevo'),
('Inventario Licuadoras', 'Licuadora Black+Decker', 15, 'Bodega SPS', 'Disponible', 'Luis García', 'Stock inicial'),

-- Ropa
('Inventario Camisas', 'Camisa Azul M', 50, 'Bodega SPS', 'Disponible', 'Juan Pérez', 'Stock inicial'),
('Inventario Jeans', 'Pantalón Jeans Levis', 30, 'Bodega SPS', 'Disponible', 'María López', 'Ingreso nuevo'),
('Inventario Chaquetas', 'Chaqueta Negra XL', 15, 'Bodega SPS', 'Disponible', 'Carlos Mejía', 'Stock inicial'),
('Inventario Zapatos', 'Zapatos Nike Air', 20, 'Bodega SPS', 'Disponible', 'Ana Torres', 'Ingreso nuevo'),
('Inventario Gorras', 'Gorra Adidas', 40, 'Bodega SPS', 'Disponible', 'Luis García', 'Stock inicial'),

-- Accesorios
('Inventario Bolsos', 'Bolso de Cuero', 20, 'Bodega SPS', 'Disponible', 'Juan Pérez', 'Stock inicial'),
('Inventario Cinturones', 'Cinturón de Piel', 25, 'Bodega SPS', 'Disponible', 'María López', 'Ingreso nuevo'),
('Inventario Relojes', 'Reloj Casio', 30, 'Bodega SPS', 'Disponible', 'Carlos Mejía', 'Stock inicial'),
('Inventario Lentes', 'Lentes Ray-Ban', 10, 'Bodega SPS', 'Disponible', 'Ana Torres', 'Ingreso nuevo'),
('Inventario Carteras', 'Cartera Fossil', 18, 'Bodega SPS', 'Disponible', 'Luis García', 'Stock inicial');

-- =====================================================
-- CONSULTAS
-- =====================================================
-- 1. Módulo de Seguridad y Acceso
SELECT * FROM Rol;
SELECT * FROM Usuario;
SELECT * FROM Direccion;

-- 2. Módulo de Productos y Clasificación
SELECT * FROM Categoria;
SELECT * FROM Producto;

-- 3. Módulo de Operaciones Externas
SELECT * FROM Proveedor;
SELECT * FROM Cliente;

-- 4. Módulo Interno y Logística
SELECT * FROM Empleado;
SELECT * FROM Sucursal;
SELECT * FROM Inventario;

-- =====================================================
-- Base de datos MiniEcommerceACL
-- =====================================================





