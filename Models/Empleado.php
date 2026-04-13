<?php
namespace Models;
use \Config\Conexion as Conexion;

class Empleado {
    private $db;
    private $validator;

    public function __construct(){
        $this->db = new Conexion();
        $this->validator = new Validator();
    }

    // Obtener todos los empleados
    public function getAll(){
        $stmt = $this->db->getConnection()->query("SELECT * FROM Empleado");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Obtener empleado por Id
    public function getById($id){
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM Empleado WHERE Id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // Validar duplicados antes de insertar
    public function validarDuplicados($datos, $excluirId = null){
        $errores = [];
        
        // Validar Correo (si no está vacío)
        if (!empty($datos['Correo']) && $this->validator->existeDuplicado('Empleado', 'Correo', $datos['Correo'], $excluirId)) {
            $errores[] = $this->validator->getMensajeError('Correo', $datos['Correo']);
        }
        
        // Validar Telefono (si no está vacío)
        if (!empty($datos['Telefono']) && $this->validator->existeDuplicado('Empleado', 'Telefono', $datos['Telefono'], $excluirId)) {
            $errores[] = $this->validator->getMensajeError('Telefono', $datos['Telefono']);
        }
        
        return $errores;
    }

    // Insertar nuevo empleado
    public function insert($datos){
        // Validar duplicados antes de insertar
        $errores = $this->validarDuplicados($datos);
        if (!empty($errores)) {
            throw new \Exception(implode('|', $errores));
        }
        
        $stmt = $this->db->getConnection()->prepare("
            INSERT INTO Empleado (Nombre, Cargo, Salario, Telefono, Correo, Estado, FechaIngreso, Observaciones)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $datos['Nombre'],
            $datos['Cargo'],
            $datos['Salario'],
            $datos['Telefono'],
            $datos['Correo'],
            $datos['Estado'],
            $datos['FechaIngreso'],
            $datos['Observaciones']
        ]);
    }

    // Actualizar empleado
    public function update($id, $datos){
        // Validar duplicados antes de actualizar
        $errores = $this->validarDuplicados($datos, $id);
        if (!empty($errores)) {
            throw new \Exception(implode('|', $errores));
        }
        
        $stmt = $this->db->getConnection()->prepare("
            UPDATE Empleado 
            SET Nombre = ?, Cargo = ?, Salario = ?, Telefono = ?, Correo = ?, Estado = ?, FechaIngreso = ?, Observaciones = ?
            WHERE Id = ?
        ");
        return $stmt->execute([
            $datos['Nombre'],
            $datos['Cargo'],
            $datos['Salario'],
            $datos['Telefono'],
            $datos['Correo'],
            $datos['Estado'],
            $datos['FechaIngreso'],
            $datos['Observaciones'],
            $id
        ]);
    }

    // Eliminar empleado
    public function delete($id){
        $stmt = $this->db->getConnection()->prepare("DELETE FROM Empleado WHERE Id = ?");
        return $stmt->execute([$id]);
    }
}
