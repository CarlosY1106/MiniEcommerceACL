<?php
namespace Models;
use \Config\Conexion as Conexion;

class Cliente {
    private $db;
    private $validator;

    public function __construct(){
        $this->db = new Conexion();
        $this->validator = new Validator();
    }

    // Obtener todos los clientes
    public function getAll(){
        $stmt = $this->db->getConnection()->query("SELECT * FROM Cliente");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Obtener cliente por Id
    public function getById($id){
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM Cliente WHERE Id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // Validar duplicados antes de insertar
    public function validarDuplicados($datos, $excluirId = null){
        $errores = [];
        
        // Validar DocumentoIdentidad (si no está vacío)
        if (!empty($datos['DocumentoIdentidad']) && $this->validator->existeDuplicado('Cliente', 'DocumentoIdentidad', $datos['DocumentoIdentidad'], $excluirId)) {
            $errores[] = $this->validator->getMensajeError('DocumentoIdentidad', $datos['DocumentoIdentidad']);
        }
        
        // Validar Correo (si no está vacío)
        if (!empty($datos['Correo']) && $this->validator->existeDuplicado('Cliente', 'Correo', $datos['Correo'], $excluirId)) {
            $errores[] = $this->validator->getMensajeError('Correo', $datos['Correo']);
        }
        
        // Validar Telefono (si no está vacío)
        if (!empty($datos['Telefono']) && $this->validator->existeDuplicado('Cliente', 'Telefono', $datos['Telefono'], $excluirId)) {
            $errores[] = $this->validator->getMensajeError('Telefono', $datos['Telefono']);
        }
        
        return $errores;
    }

    // Insertar nuevo cliente
    public function insert($datos){
        // Validar duplicados antes de insertar
        $errores = $this->validarDuplicados($datos);
        if (!empty($errores)) {
            throw new \Exception(implode('|', $errores));
        }
        
        $stmt = $this->db->getConnection()->prepare("
            INSERT INTO Cliente (Nombre, Direccion, Telefono, Correo, Estado, DocumentoIdentidad, Observaciones)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $datos['Nombre'],
            $datos['Direccion'],
            $datos['Telefono'],
            $datos['Correo'],
            $datos['Estado'],
            $datos['DocumentoIdentidad'],
            $datos['Observaciones']
        ]);
    }

    // Actualizar cliente
    public function update($id, $datos){
        // Validar duplicados antes de actualizar
        $errores = $this->validarDuplicados($datos, $id);
        if (!empty($errores)) {
            throw new \Exception(implode('|', $errores));
        }
        
        $stmt = $this->db->getConnection()->prepare("
            UPDATE Cliente 
            SET Nombre = ?, Direccion = ?, Telefono = ?, Correo = ?, Estado = ?, DocumentoIdentidad = ?, Observaciones = ?
            WHERE Id = ?
        ");
        return $stmt->execute([
            $datos['Nombre'],
            $datos['Direccion'],
            $datos['Telefono'],
            $datos['Correo'],
            $datos['Estado'],
            $datos['DocumentoIdentidad'],
            $datos['Observaciones'],
            $id
        ]);
    }

    // Eliminar cliente
    public function delete($id){
        $stmt = $this->db->getConnection()->prepare("DELETE FROM Cliente WHERE Id = ?");
        return $stmt->execute([$id]);
    }
}
