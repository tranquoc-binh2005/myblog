<?php
namespace Core;

use PDO;
use PDOException;

class Database {
    private static $instance = null;
    private $connection;

    private $host;
    private $dbname;
    private $username;
    private $password;

    private function __construct($config) {
        $this->host = $config['db_host'];
        $this->dbname = $config['db_name'];
        $this->username = $config['db_user'];
        $this->password = $config['db_password'];

        try {
            $this->connection = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Kết nối không thành công: " . $e->getMessage();
        }
    }

    public static function getInstance($config) {
        if (self::$instance === null) {
            self::$instance = new Database($config);
        }
        return self::$instance->connection;
    }

    private function __clone() {}
    private function __wakeup() {}
}