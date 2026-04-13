<?php
namespace Config;

use PDO;
use PDOException;

class Conexion {
    private $host;
    private $username;
    private $password;
    private $database;
    private $port;
    public $connection;
    private static $pdo;

    public function __construct() {
        global $config;
        $this->host = $config['db_data']['host'];
        $this->username = $config['db_data']['username'];
        $this->password = $config['db_data']['password'];
        $this->database = $config['db_data']['database'];
        $this->port = $config['db_data']['port'];

        try {
            $this->connection = new PDO(
                "mysql:host={$this->host};dbname={$this->database};charset=utf8;port={$this->port}",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );

            self::$pdo = $this->connection;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public static function getConexion() {
        if (!isset(self::$pdo)) {
            new self();
        }
        return self::$pdo;
    }

    // Métodos seguros
    public function fetchAll($table, $field="*", $where=null, $params=[]) {
        $sql = "SELECT $field FROM $table";
        if ($where) $sql .= " WHERE $where";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function fetch($table, $field="*", $where=null, $params=[]) {
        $sql = "SELECT $field FROM $table";
        if ($where) $sql .= " WHERE $where";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    public function Delete($table, $id) {
        $stmt = $this->connection->prepare("DELETE FROM $table WHERE Id = ?");
        return $stmt->execute([$id]);
    }

    public function Update($table, $data, $where, $params=[]) {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $params[] = $value;
        }
        $sql = "UPDATE $table SET " . implode(", ", $fields) . " WHERE $where";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute($params);
    }
}
