<?php
namespace Models;
use \Config\Conexion as Conexion;

class Sucursal {
    private $db;
    private $validator;

    public function __construct(){
        $this->db = new Conexion();
        $this->validator = new Validator();
    }

    // Obtener todas las sucursales
    public function getAll(){
        $stmt = $this->db->getConnection()->query("SELECT * FROM Sucursal");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Obtener sucursal por Id
    public function getById($id){
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM Sucursal WHERE Id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // Validar duplicados antes de insertar
    public function validarDuplicados($datos, $excluirId = null){
        $errores = [];
        
        // Validar Nombre
        if ($this->validator->existeDuplicado('Sucursal', 'Nombre', $datos['Nombre'], $excluirId)) {
            $errores[] = $this->validator->getMensajeError('Nombre', $datos['Nombre']);
        }
        
        // Validar Correo (si no está vacío)
        if (!empty($datos['Correo']) && $this->validator->existeDuplicado('Sucursal', 'Correo', $datos['Correo'], $excluirId)) {
            $errores[] = $this->validator->getMensajeError('Correo', $datos['Correo']);
        }
        
        // Validar Telefono (si no está vacío)
        if (!empty($datos['Telefono']) && $this->validator->existeDuplicado('Sucursal', 'Telefono', $datos['Telefono'], $excluirId)) {
            $errores[] = $this->validator->getMensajeError('Telefono', $datos['Telefono']);
        }
        
        return $errores;
    }

    // Insertar nueva sucursal
    public function insert($datos){
        // Validar duplicados antes de insertar
        $errores = $this->validarDuplicados($datos);
        if (!empty($errores)) {
            throw new \Exception(implode('|', $errores));
        }
        
        $stmt = $this->db->getConnection()->prepare("
            INSERT INTO Sucursal (Nombre, Direccion, Telefono, Correo, Estado, FechaApertura, Responsable, Observaciones)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $datos['Nombre'],
            $datos['Direccion'],
            $datos['Telefono'],
            $datos['Correo'],
            $datos['Estado'],
            $datos['FechaApertura'],
            $datos['Responsable'],
            $datos['Observaciones']
        ]);
    }

    // Actualizar sucursal
    public function update($id, $datos){
        // Validar duplicados antes de actualizar
        $errores = $this->validarDuplicados($datos, $id);
        if (!empty($errores)) {
            throw new \Exception(implode('|', $errores));
        }
        
        $stmt = $this->db->getConnection()->prepare("
            UPDATE Sucursal 
            SET Nombre = ?, Direccion = ?, Telefono = ?, Correo = ?, Estado = ?, FechaApertura = ?, Responsable = ?, Observaciones = ?
            WHERE Id = ?
        ");
        return $stmt->execute([
            $datos['Nombre'],
            $datos['Direccion'],
            $datos['Telefono'],
            $datos['Correo'],
            $datos['Estado'],
            $datos['FechaApertura'],
            $datos['Responsable'],
            $datos['Observaciones'],
            $id
        ]);
    }

    // Eliminar sucursal
    public function delete($id){
        $stmt = $this->db->getConnection()->prepare("DELETE FROM Sucursal WHERE Id = ?");
        return $stmt->execute([$id]);
    }
}
