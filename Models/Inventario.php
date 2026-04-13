<?php
namespace Models;
use \Config\Conexion as Conexion;

class Inventario {
    private $db;
    private $validator;

    public function __construct(){
        $this->db = new Conexion();
        $this->validator = new Validator();
    }

    // Obtener todos los registros de inventario
    public function getAll(){
        $stmt = $this->db->getConnection()->query("SELECT * FROM Inventario");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Obtener inventario por Id
    public function getById($id){
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM Inventario WHERE Id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // Validar duplicados antes de insertar
    public function validarDuplicados($datos, $excluirId = null){
        $errores = [];
        
        // Validar combinación Nombre + Producto
        if ($this->validator->existeDuplicadoMultiple('Inventario', [
            'Nombre' => $datos['Nombre'],
            'Producto' => $datos['Producto']
        ], $excluirId)) {
            $errores[] = $this->validator->getMensajeError('NombreProducto', $datos['Nombre']);
        }
        
        return $errores;
    }

    // Insertar nuevo registro
    public function insert($datos){
        // Validar duplicados antes de insertar
        $errores = $this->validarDuplicados($datos);
        if (!empty($errores)) {
            throw new \Exception(implode('|', $errores));
        }
        
        $stmt = $this->db->getConnection()->prepare("
            INSERT INTO Inventario (Nombre, Producto, Cantidad, Ubicacion, Estado, Responsable, Observaciones)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $datos['Nombre'],
            $datos['Producto'],
            $datos['Cantidad'],
            $datos['Ubicacion'],
            $datos['Estado'],
            $datos['Responsable'],
            $datos['Observaciones']
        ]);
    }

    // Actualizar registro
    public function update($id, $datos){
        // Validar duplicados antes de actualizar
        $errores = $this->validarDuplicados($datos, $id);
        if (!empty($errores)) {
            throw new \Exception(implode('|', $errores));
        }
        
        $stmt = $this->db->getConnection()->prepare("
            UPDATE Inventario 
            SET Nombre = ?, Producto = ?, Cantidad = ?, Ubicacion = ?, Estado = ?, Responsable = ?, Observaciones = ?
            WHERE Id = ?
        ");
        return $stmt->execute([
            $datos['Nombre'],
            $datos['Producto'],
            $datos['Cantidad'],
            $datos['Ubicacion'],
            $datos['Estado'],
            $datos['Responsable'],
            $datos['Observaciones'],
            $id
        ]);
    }

    // Eliminar registro
    public function delete($id){
        $stmt = $this->db->getConnection()->prepare("DELETE FROM Inventario WHERE Id = ?");
        return $stmt->execute([$id]);
    }

    // Buscar inventario por nombre
    public function searchByNombre($nombre){
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM Inventario WHERE Nombre LIKE ?");
        $stmt->execute(["%$nombre%"]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
