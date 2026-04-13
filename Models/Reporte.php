<?php
namespace Models;
use \Config\Conexion as Conexion;

class Reporte {
    private $db;

    public function __construct(){
        $this->db = new Conexion();
    }

    // Ventas por mes
    public function getVentasPorMes(){
        $stmt = $this->db->getConnection()->query("
            SELECT MONTH(Fecha) AS Mes, SUM(Total) AS TotalVentas
            FROM Venta
            GROUP BY MONTH(Fecha)
            ORDER BY Mes
        ");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Inventario actual agrupado por categoría
    public function getInventarioPorCategoria(){
        $stmt = $this->db->getConnection()->query("
            SELECT c.Nombre AS Categoria, 
                   SUM(CASE WHEN m.Tipo='Entrada' THEN m.Cantidad ELSE -m.Cantidad END) AS Stock
            FROM MovimientoInventario m
            JOIN Producto p ON m.Producto_Id = p.Id
            JOIN Categoria c ON p.Categoria_Id = c.Id
            GROUP BY c.Nombre
        ");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>
