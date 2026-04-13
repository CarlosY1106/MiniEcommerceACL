<?php
namespace Models;
use \Config\Conexion as Conexion;

class Proveedor {
    private $db;
    private $validator;

    public function __construct(){
        $this->db = new Conexion();
        $this->validator = new Validator();
    }

    // Obtener todos los proveedores
    public function getAll($categoriaId = null){
        $query = "SELECT p.*, c.Nombre as Categoria FROM Proveedor p 
                 LEFT JOIN Categoria c ON p.Categoria_Id = c.Id";
        
        if ($categoriaId) {
            $query .= " WHERE p.Categoria_Id = ?";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->execute([$categoriaId]);
        } else {
            $stmt = $this->db->getConnection()->query($query);
        }
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Obtener todas las categorías
    public function getAllCategories(){
        $stmt = $this->db->getConnection()->query("SELECT * FROM Categoria");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Obtener proveedor por Id
    public function getById($id){
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM Proveedor WHERE Id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // Validar duplicados antes de insertar
    public function validarDuplicados($datos, $excluirId = null){
        $errores = [];
        
        // Validar Correo (si no está vacío)
        if (!empty($datos['Correo']) && $this->validator->existeDuplicado('Proveedor', 'Correo', $datos['Correo'], $excluirId)) {
            $errores[] = $this->validator->getMensajeError('Correo', $datos['Correo']);
        }
        
        // Validar Telefono (si no está vacío)
        if (!empty($datos['Telefono']) && $this->validator->existeDuplicado('Proveedor', 'Telefono', $datos['Telefono'], $excluirId)) {
            $errores[] = $this->validator->getMensajeError('Telefono', $datos['Telefono']);
        }
        
        return $errores;
    }

    // Insertar nuevo proveedor
    public function insert($datos){
        // Validar duplicados antes de insertar
        $errores = $this->validarDuplicados($datos);
        if (!empty($errores)) {
            throw new \Exception(implode('|', $errores));
        }
        
        $stmt = $this->db->getConnection()->prepare("
            INSERT INTO Proveedor (Nombre, Telefono, Correo, Direccion, Estado, ContactoPrincipal, Observaciones)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $datos['Nombre'],
            $datos['Telefono'],
            $datos['Correo'],
            $datos['Direccion'],
            $datos['Estado'],
            $datos['ContactoPrincipal'],
            $datos['Observaciones']
        ]);
    }

    // Actualizar proveedor
    public function update($id, $datos){
        // Validar duplicados antes de actualizar
        $errores = $this->validarDuplicados($datos, $id);
        if (!empty($errores)) {
            throw new \Exception(implode('|', $errores));
        }
        
        $stmt = $this->db->getConnection()->prepare("
            UPDATE Proveedor 
            SET Nombre = ?, Telefono = ?, Correo = ?, Direccion = ?, Estado = ?, ContactoPrincipal = ?, Observaciones = ?
            WHERE Id = ?
        ");
        return $stmt->execute([
            $datos['Nombre'],
            $datos['Telefono'],
            $datos['Correo'],
            $datos['Direccion'],
            $datos['Estado'],
            $datos['ContactoPrincipal'],
            $datos['Observaciones'],
            $id
        ]);
    }

    // Eliminar proveedor
    public function delete($id){
        $stmt = $this->db->getConnection()->prepare("DELETE FROM Proveedor WHERE Id = ?");
        return $stmt->execute([$id]);
    }
}
