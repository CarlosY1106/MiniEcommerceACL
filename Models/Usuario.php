<?php
namespace Models;
use \Config\Conexion as Conexion;

class Usuario {
    private $db;
    private $validator;

    public function __construct(){
        $this->db = new Conexion();
        $this->validator = new Validator();
    }

    // Obtener todos los usuarios
    public function getAll(){
        // Devuelve todos los registros como array asociativo
        $stmt = $this->db->getConnection()->query("SELECT * FROM Usuario");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Obtener usuario por Id
    public function getForId($id){
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM Usuario WHERE Id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC); // 👈 importante: array asociativo
    }

    // Validar duplicados antes de insertar
    public function validarDuplicados($datos, $excluirId = null){
        $errores = [];
        
        // Validar NombreUsuario
        if ($this->validator->existeDuplicado('Usuario', 'NombreUsuario', $datos['NombreUsuario'], $excluirId)) {
            $errores[] = $this->validator->getMensajeError('NombreUsuario', $datos['NombreUsuario']);
        }
        
        // Validar Correo (si no está vacío)
        if (!empty($datos['Correo']) && $this->validator->existeDuplicado('Usuario', 'Correo', $datos['Correo'], $excluirId)) {
            $errores[] = $this->validator->getMensajeError('Correo', $datos['Correo']);
        }
        
        // Validar Telefono (si no está vacío)
        if (!empty($datos['Telefono']) && $this->validator->existeDuplicado('Usuario', 'Telefono', $datos['Telefono'], $excluirId)) {
            $errores[] = $this->validator->getMensajeError('Telefono', $datos['Telefono']);
        }
        
        return $errores;
    }

    // Insertar nuevo usuario
    public function insert($datos){
        // Validar duplicados antes de insertar
        $errores = $this->validarDuplicados($datos);
        if (!empty($errores)) {
            throw new \Exception(implode('|', $errores));
        }
        
        $stmt = $this->db->getConnection()->prepare("
            INSERT INTO Usuario (NombreUsuario, Contraseña, Correo, Telefono, Rol_Id)
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $datos['NombreUsuario'],
            $datos['Contraseña'],
            $datos['Correo'],
            $datos['Telefono'],
            $datos['Rol_Id']
        ]);
    }

    // Actualizar usuario
    public function update($datos, $id){
        // Validar duplicados antes de actualizar
        $errores = $this->validarDuplicados($datos, $id);
        if (!empty($errores)) {
            throw new \Exception(implode('|', $errores));
        }
        
        $stmt = $this->db->getConnection()->prepare("
            UPDATE Usuario 
            SET NombreUsuario = ?, Contraseña = ?, Correo = ?, Telefono = ?, Rol_Id = ?
            WHERE Id = ?
        ");
        return $stmt->execute([
            $datos['NombreUsuario'],
            $datos['Contraseña'],
            $datos['Correo'],
            $datos['Telefono'],
            $datos['Rol_Id'],
            $id
        ]);
    }

    // Eliminar usuario
    public function delete($id){
        $stmt = $this->db->getConnection()->prepare("DELETE FROM Usuario WHERE Id = ?");
        return $stmt->execute([$id]);
    }

    // Verificar login
    public function verificarLogin($usuario, $contraseña){
        $stmt = $this->db->getConnection()->prepare("
            SELECT * FROM Usuario WHERE NombreUsuario = ? AND Contraseña = ?
        ");
        $stmt->execute([$usuario, $contraseña]);
        return $stmt->fetch(\PDO::FETCH_OBJ); // aquí sí conviene objeto
    }
}
?>
