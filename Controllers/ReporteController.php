<?php
namespace Controllers;

class ReporteController {
    public function Usuarios() {
        // Incluir la librería FPDF
        require_once "libraries/FPDF-master/fpdf.php";
        
        // Crear instancia de FPDF
        $pdf = new \FPDF();
        $pdf->AddPage();
        
        // Configurar fuentes y colores
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->SetFillColor(13, 110, 253); // Color primario
        $pdf->SetTextColor(255, 255, 255);
        
        // Título del reporte
        $pdf->Cell(0, 10, 'Reporte de Usuarios', 0, 1, 'C', true);
        $pdf->Ln(10);
        
        // Resetear colores para el contenido
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        
        // Encabezados de tabla
        $pdf->Cell(20, 10, 'ID', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Usuario', 1, 0, 'C', true);
        $pdf->Cell(60, 10, 'Correo', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Telefono', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Rol', 1, 1, 'C', true);
        
        // Obtener datos de usuarios
        require_once "Models/Usuario.php";
        $usuarioModel = new \Models\Usuario();
        $usuarios = $usuarioModel->getAll();
        
        // Contenido de la tabla
        $pdf->SetFont('Arial', '', 10);
        $fill = false;
        
        foreach ($usuarios as $u) {
            $pdf->Cell(20, 8, $u['Id'], 1, 0, 'C', $fill);
            $pdf->Cell(50, 8, $u['NombreUsuario'], 1, 0, 'L', $fill);
            $pdf->Cell(60, 8, $u['Correo'], 1, 0, 'L', $fill);
            $pdf->Cell(30, 8, $u['Telefono'], 1, 0, 'C', $fill);
            $pdf->Cell(30, 8, $u['Rol_Id'] == 1 ? "Administrador" : "Cliente", 1, 1, 'C', $fill);
            $fill = !$fill;
        }
        
        // Pie de página
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(0, 10, 'Fecha de generacion: ' . date('d/m/Y H:i:s'), 0, 1, 'C');
        $pdf->Cell(0, 10, 'Sistema Mini-Ecommerce-ACL', 0, 1, 'C');
        
        // Salida del PDF
        $pdf->Output('D', 'reporte_usuarios_' . date('Y-m-d_H-i-s') . '.pdf');
    }
    
    public function Productos() {
        // Incluir la librería FPDF
        require_once "libraries/FPDF-master/fpdf.php";
        
        // Crear instancia de FPDF
        $pdf = new \FPDF();
        $pdf->AddPage();
        
        // Configurar fuentes y colores
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->SetFillColor(25, 135, 84); // Color success
        $pdf->SetTextColor(255, 255, 255);
        
        // Título del reporte
        $pdf->Cell(0, 10, 'Reporte de Productos', 0, 1, 'C', true);
        $pdf->Ln(10);
        
        // Resetear colores para el contenido
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        
        // Encabezados de tabla
        $pdf->Cell(20, 10, 'ID', 1, 0, 'C', true);
        $pdf->Cell(60, 10, 'Nombre', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Precio', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Existencia', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Categoria', 1, 1, 'C', true);
        
        // Obtener datos de productos
        require_once "Models/Producto.php";
        $productoModel = new \Models\Producto();
        $productos = $productoModel->getAll();
        
        // Contenido de la tabla
        $pdf->SetFont('Arial', '', 10);
        $fill = false;
        
        foreach ($productos as $p) {
            $pdf->Cell(20, 8, $p['Id'], 1, 0, 'C', $fill);
            $pdf->Cell(60, 8, substr($p['Nombre'], 0, 30), 1, 0, 'L', $fill);
            $pdf->Cell(30, 8, '$' . number_format($p['Precio'], 2), 1, 0, 'R', $fill);
            $pdf->Cell(30, 8, $p['Existencia'], 1, 0, 'C', $fill);
            $pdf->Cell(50, 8, $p['Categoria_Id'] ?? 'Sin categoria', 1, 1, 'L', $fill);
            $fill = !$fill;
        }
        
        // Pie de página
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(0, 10, 'Fecha de generacion: ' . date('d/m/Y H:i:s'), 0, 1, 'C');
        $pdf->Cell(0, 10, 'Sistema Mini-Ecommerce-ACL', 0, 1, 'C');
        
        // Salida del PDF
        $pdf->Output('D', 'reporte_productos_' . date('Y-m-d_H-i-s') . '.pdf');
    }
    
    public function Clientes() {
        require_once "libraries/FPDF-master/fpdf.php";
        require_once "Models/Cliente.php";
        
        $pdf = new \FPDF();
        $pdf->AddPage();
        
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->SetFillColor(25, 135, 84);
        $pdf->SetTextColor(255, 255, 255);
        
        $pdf->Cell(0, 10, 'Reporte de Clientes', 0, 1, 'C', true);
        $pdf->Ln(10);
        
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        
        $pdf->Cell(15, 10, 'ID', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Nombre', 1, 0, 'C', true);
        $pdf->Cell(40, 10, 'Telefono', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Correo', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'Documento', 1, 1, 'C', true);
        
        $clienteModel = new \Models\Cliente();
        $clientes = $clienteModel->getAll();
        
        $pdf->SetFont('Arial', '', 10);
        $fill = false;
        
        foreach ($clientes as $c) {
            $pdf->Cell(15, 8, $c['Id'], 1, 0, 'C', $fill);
            $pdf->Cell(50, 8, substr($c['Nombre'], 0, 30), 1, 0, 'L', $fill);
            $pdf->Cell(40, 8, $c['Telefono'], 1, 0, 'C', $fill);
            $pdf->Cell(50, 8, substr($c['Correo'], 0, 25), 1, 0, 'L', $fill);
            $pdf->Cell(35, 8, $c['DocumentoIdentidad'], 1, 1, 'C', $fill);
            $fill = !$fill;
        }
        
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(0, 10, 'Fecha de generacion: ' . date('d/m/Y H:i:s'), 0, 1, 'C');
        $pdf->Cell(0, 10, 'Sistema Mini-Ecommerce-ACL', 0, 1, 'C');
        
        $pdf->Output('D', 'reporte_clientes_' . date('Y-m-d_H-i-s') . '.pdf');
    }
    
    public function Empleados() {
        require_once "libraries/FPDF-master/fpdf.php";
        require_once "Models/Empleado.php";
        
        $pdf = new \FPDF();
        $pdf->AddPage();
        
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->SetFillColor(220, 53, 69);
        $pdf->SetTextColor(255, 255, 255);
        
        $pdf->Cell(0, 10, 'Reporte de Empleados', 0, 1, 'C', true);
        $pdf->Ln(10);
        
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        
        $pdf->Cell(15, 10, 'ID', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Nombre', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'Cargo', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Salario', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'Telefono', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'Fecha Ingreso', 1, 1, 'C', true);
        
        $empleadoModel = new \Models\Empleado();
        $empleados = $empleadoModel->getAll();
        
        $pdf->SetFont('Arial', '', 10);
        $fill = false;
        
        foreach ($empleados as $e) {
            $pdf->Cell(15, 8, $e['Id'], 1, 0, 'C', $fill);
            $pdf->Cell(50, 8, substr($e['Nombre'], 0, 30), 1, 0, 'L', $fill);
            $pdf->Cell(35, 8, substr($e['Cargo'], 0, 20), 1, 0, 'L', $fill);
            $pdf->Cell(30, 8, '$' . number_format($e['Salario'], 2), 1, 0, 'R', $fill);
            $pdf->Cell(35, 8, $e['Telefono'], 1, 0, 'C', $fill);
            $pdf->Cell(35, 8, $e['FechaIngreso'], 1, 1, 'C', $fill);
            $fill = !$fill;
        }
        
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(0, 10, 'Fecha de generacion: ' . date('d/m/Y H:i:s'), 0, 1, 'C');
        $pdf->Cell(0, 10, 'Sistema Mini-Ecommerce-ACL', 0, 1, 'C');
        
        $pdf->Output('D', 'reporte_empleados_' . date('Y-m_d_H-i-s') . '.pdf');
    }
    
    public function Proveedores() {
        require_once "libraries/FPDF-master/fpdf.php";
        require_once "Models/Proveedor.php";
        
        $pdf = new \FPDF();
        $pdf->AddPage();
        
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->SetFillColor(255, 193, 7);
        $pdf->SetTextColor(0, 0, 0);
        
        $pdf->Cell(0, 10, 'Reporte de Proveedores', 0, 1, 'C', true);
        $pdf->Ln(10);
        
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        
        $pdf->Cell(15, 10, 'ID', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Nombre', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'Telefono', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Correo', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Direccion', 1, 1, 'C', true);
        
        $proveedorModel = new \Models\Proveedor();
        $proveedores = $proveedorModel->getAll();
        
        $pdf->SetFont('Arial', '', 10);
        $fill = false;
        
        foreach ($proveedores as $p) {
            $pdf->Cell(15, 8, $p['Id'], 1, 0, 'C', $fill);
            $pdf->Cell(50, 8, substr($p['Nombre'], 0, 30), 1, 0, 'L', $fill);
            $pdf->Cell(35, 8, $p['Telefono'], 1, 0, 'C', $fill);
            $pdf->Cell(50, 8, substr($p['Correo'], 0, 25), 1, 0, 'L', $fill);
            $pdf->Cell(50, 8, substr($p['Direccion'], 0, 30), 1, 1, 'L', $fill);
            $fill = !$fill;
        }
        
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(0, 10, 'Fecha de generacion: ' . date('d/m/Y H:i:s'), 0, 1, 'C');
        $pdf->Cell(0, 10, 'Sistema Mini-Ecommerce-ACL', 0, 1, 'C');
        
        $pdf->Output('D', 'reporte_proveedores_' . date('Y-m-d_H-i-s') . '.pdf');
    }
    
    public function Sucursales() {
        require_once "libraries/FPDF-master/fpdf.php";
        require_once "Models/Sucursal.php";
        
        $pdf = new \FPDF();
        $pdf->AddPage();
        
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->SetFillColor(108, 117, 125);
        $pdf->SetTextColor(255, 255, 255);
        
        $pdf->Cell(0, 10, 'Reporte de Sucursales', 0, 1, 'C', true);
        $pdf->Ln(10);
        
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        
        $pdf->Cell(15, 10, 'ID', 1, 0, 'C', true);
        $pdf->Cell(40, 10, 'Nombre', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Direccion', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'Telefono', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'Correo', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Estado', 1, 0, 'C', true);
        $pdf->Cell(40, 10, 'Fecha Apertura', 1, 0, 'C', true);
        $pdf->Cell(40, 10, 'Responsable', 1, 1, 'C', true);
        
        $sucursalModel = new \Models\Sucursal();
        $sucursales = $sucursalModel->getAll();
        
        $pdf->SetFont('Arial', '', 10);
        $fill = false;
        
        foreach ($sucursales as $s) {
            $pdf->Cell(15, 8, $s['Id'], 1, 0, 'C', $fill);
            $pdf->Cell(40, 8, substr($s['Nombre'], 0, 25), 1, 0, 'L', $fill);
            $pdf->Cell(50, 8, substr($s['Direccion'], 0, 30), 1, 0, 'L', $fill);
            $pdf->Cell(35, 8, $s['Telefono'], 1, 0, 'C', $fill);
            $pdf->Cell(35, 8, substr($s['Correo'], 0, 20), 1, 0, 'L', $fill);
            $pdf->Cell(30, 8, $s['Estado'], 1, 0, 'C', $fill);
            $pdf->Cell(40, 8, $s['FechaApertura'], 1, 0, 'C', $fill);
            $pdf->Cell(40, 8, substr($s['Responsable'], 0, 25), 1, 1, 'L', $fill);
            $fill = !$fill;
        }
        
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(0, 10, 'Fecha de generacion: ' . date('d/m/Y H:i:s'), 0, 1, 'C');
        $pdf->Cell(0, 10, 'Sistema Mini-Ecommerce-ACL', 0, 1, 'C');
        
        $pdf->Output('D', 'reporte_sucursales_' . date('Y-m-d_H-i-s') . '.pdf');
    }
    
    public function Inventario() {
        require_once "libraries/FPDF-master/fpdf.php";
        require_once "Models/Inventario.php";
        
        $pdf = new \FPDF();
        $pdf->AddPage();
        
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->SetFillColor(32, 201, 151);
        $pdf->SetTextColor(255, 255, 255);
        
        $pdf->Cell(0, 10, 'Reporte de Inventario', 0, 1, 'C', true);
        $pdf->Ln(10);
        
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        
        $pdf->Cell(15, 10, 'ID', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'Nombre', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'Producto', 1, 0, 'C', true);
        $pdf->Cell(25, 10, 'Cantidad', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'Ubicacion', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Estado', 1, 0, 'C', true);
        $pdf->Cell(45, 10, 'Fecha Registro', 1, 0, 'C', true);
        $pdf->Cell(40, 10, 'Responsable', 1, 1, 'C', true);
        
        $inventarioModel = new \Models\Inventario();
        $inventario = $inventarioModel->getAll();
        
        $pdf->SetFont('Arial', '', 10);
        $fill = false;
        
        foreach ($inventario as $i) {
            $pdf->Cell(15, 8, $i['Id'], 1, 0, 'C', $fill);
            $pdf->Cell(35, 8, substr($i['Nombre'], 0, 20), 1, 0, 'L', $fill);
            $pdf->Cell(35, 8, substr($i['Producto'], 0, 20), 1, 0, 'L', $fill);
            $pdf->Cell(25, 8, $i['Cantidad'], 1, 0, 'C', $fill);
            $pdf->Cell(35, 8, substr($i['Ubicacion'], 0, 20), 1, 0, 'L', $fill);
            $pdf->Cell(30, 8, $i['Estado'], 1, 0, 'C', $fill);
            $pdf->Cell(45, 8, $i['FechaRegistro'], 1, 0, 'C', $fill);
            $pdf->Cell(40, 8, substr($i['Responsable'], 0, 25), 1, 1, 'L', $fill);
            $fill = !$fill;
        }
        
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(0, 10, 'Fecha de generacion: ' . date('d/m/Y H:i:s'), 0, 1, 'C');
        $pdf->Cell(0, 10, 'Sistema Mini-Ecommerce-ACL', 0, 1, 'C');
        
        $pdf->Output('D', 'reporte_inventario_' . date('Y-m-d_H-i-s') . '.pdf');
    }
}
