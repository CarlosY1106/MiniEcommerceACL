<?php
namespace Models;
use \Config\Conexion as Conexion;

class Producto {
    private $db;
    private $validator;

    public function __construct(){
        $this->db = new Conexion();
        $this->validator = new Validator();
    }

    // Obtener todos los productos con nombre de categoría
    public function getAll(){
        $stmt = $this->db->getConnection()->query("
            SELECT p.Id, p.Nombre, p.Precio, p.Existencia, c.Nombre AS Categoria
            FROM Producto p
            JOIN Categoria c ON p.Categoria_Id = c.Id
        ");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Obtener productos filtrados por categoría con nombre de categoría
    public function getByCategoria($categoriaId){
        $stmt = $this->db->getConnection()->prepare("
            SELECT p.Id, p.Nombre, p.Precio, p.Existencia, c.Nombre AS Categoria
            FROM Producto p
            JOIN Categoria c ON p.Categoria_Id = c.Id
            WHERE p.Categoria_Id = ?
        ");
        $stmt->execute([$categoriaId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Obtener todas las categorías
    public function getCategorias(){
        $stmt = $this->db->getConnection()->query("SELECT * FROM Categoria");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Obtener producto por Id con nombre de categoría
    public function getForId($id){
        $stmt = $this->db->getConnection()->prepare("
            SELECT p.Id, p.Nombre, p.Precio, p.Existencia, c.Nombre AS Categoria, p.Categoria_Id
            FROM Producto p
            JOIN Categoria c ON p.Categoria_Id = c.Id
            WHERE p.Id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // Validar duplicados antes de insertar
    public function validarDuplicados($datos, $excluirId = null){
        $errores = [];
        
        // Validar combinación Nombre + Precio
        if ($this->validator->existeDuplicadoMultiple('Producto', [
            'Nombre' => $datos['Nombre'],
            'Precio' => $datos['Precio']
        ], $excluirId)) {
            $errores[] = $this->validator->getMensajeError('NombrePrecio', $datos['Nombre']);
        }
        
        return $errores;
    }

    // Insertar nuevo producto
    public function insert($datos){
        // Validar duplicados antes de insertar
        $errores = $this->validarDuplicados($datos);
        if (!empty($errores)) {
            throw new \Exception(implode('|', $errores));
        }
        
        $stmt = $this->db->getConnection()->prepare("
            INSERT INTO Producto (Nombre, Precio, Existencia, Categoria_Id)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([
            $datos['Nombre'],
            $datos['Precio'],
            $datos['Existencia'],
            $datos['Categoria_Id']
        ]);
    }

    // Actualizar producto
    public function update($datos, $id){
        // Validar duplicados antes de actualizar
        $errores = $this->validarDuplicados($datos, $id);
        if (!empty($errores)) {
            throw new \Exception(implode('|', $errores));
        }
        
        $stmt = $this->db->getConnection()->prepare("
            UPDATE Producto 
            SET Nombre = ?, Precio = ?, Existencia = ?, Categoria_Id = ?
            WHERE Id = ?
        ");
        return $stmt->execute([
            $datos['Nombre'],
            $datos['Precio'],
            $datos['Existencia'],
            $datos['Categoria_Id'],
            $id
        ]);
    }

    // Eliminar producto
    public function delete($id){
        $stmt = $this->db->getConnection()->prepare("DELETE FROM Producto WHERE Id = ?");
        return $stmt->execute([$id]);
    }
}
?>
