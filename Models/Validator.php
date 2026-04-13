<?php
namespace Models;
use \Config\Conexion as Conexion;

class Validator {
    private $db;
    
    public function __construct(){
        $this->db = new Conexion();
    }
    
    /**
     * Verifica si existe un registro duplicado
     * @param string $tabla Nombre de la tabla
     * @param string $campo Campo a verificar
     * @param string $valor Valor a verificar
     * @param int $excluirId ID a excluir (para actualizaciones)
     * @return bool True si existe duplicado
     */
    public function existeDuplicado($tabla, $campo, $valor, $excluirId = null){
        $sql = "SELECT COUNT(*) as total FROM $tabla WHERE $campo = ?";
        $params = [$valor];
        
        if ($excluirId !== null) {
            $sql .= " AND Id != ?";
            $params[] = $excluirId;
        }
        
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        return $result['total'] > 0;
    }
    
    /**
     * Verifica si existe un registro duplicado con múltiples campos
     * @param string $tabla Nombre de la tabla
     * @param array $condiciones Array asociativo campo => valor
     * @param int $excluirId ID a excluir (para actualizaciones)
     * @return bool True si existe duplicado
     */
    public function existeDuplicadoMultiple($tabla, $condiciones, $excluirId = null){
        $whereClause = [];
        $params = [];
        
        foreach ($condiciones as $campo => $valor) {
            $whereClause[] = "$campo = ?";
            $params[] = $valor;
        }
        
        $sql = "SELECT COUNT(*) as total FROM $tabla WHERE " . implode(' AND ', $whereClause);
        
        if ($excluirId !== null) {
            $sql .= " AND Id != ?";
            $params[] = $excluirId;
        }
        
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        return $result['total'] > 0;
    }
    
    /**
     * Obtiene mensaje de error para campo duplicado
     * @param string $campo Nombre del campo
     * @param string $valor Valor del campo
     * @return string Mensaje de error
     */
    public function getMensajeError($campo, $valor){
        $mensajes = [
            'NombreUsuario' => "El nombre de usuario '$valor' ya está registrado",
            'Correo' => "El correo '$valor' ya está registrado",
            'Telefono' => "El teléfono '$valor' ya está registrado",
            'Nombre' => "El nombre '$valor' ya está registrado",
            'DocumentoIdentidad' => "El documento de identidad '$valor' ya está registrado",
            'NombrePrecio' => "Ya existe un producto con el mismo nombre y precio",
            'NombreProducto' => "Ya existe un registro de inventario con el mismo nombre y producto"
        ];
        
        return $mensajes[$campo] ?? "El valor '$valor' ya está registrado";
    }
}
?>
