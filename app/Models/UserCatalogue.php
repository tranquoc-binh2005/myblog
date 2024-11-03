<?php
namespace App\Models;

use Core\Database;
use PDOException;

class UserCatalogue
{
    private $db;
    public $name;
    public $canonical;
    public $description;

    public function __construct(Database $db, $name = null, $canonical = null, $description = null)
    {
        $this->db = $db;
        $this->name = $name;
        $this->canonical = $canonical;
        $this->description = $description;
    }

    public function pagination($tableName, $limit, $page = 1, $keyword, $publish, $deleted)
    {
        return $this->db->paginate($tableName, $limit, $page = 1, $keyword, $publish, $deleted);
    }

    // public function pagination($tableName, $limit, $page = 1, $keyword, $publish)
    // {
    //     return $this->db->paginate($tableName, $limit, $page = 1, $keyword, $publish);
    // }

    public function save()
    {
        try {
            $sql = "INSERT INTO user_catalogue (name, canonical, description) VALUES (:name, :canonical, :description)";
            $params = [
                ':name' => $this->name,
                ':canonical' => $this->canonical,
                ':description' => $this->description,
            ];
            return $this->db->insert($sql, $params);
        } catch (PDOException $e) {
            echo "Lỗi SQL: " . $e->getMessage();
            return false;
        }
    }
    public function update($id)
    {
        try {
            $sql = "UPDATE user_catalogue SET name = :name, canonical = :canonical, description = :description WHERE id = :id";
            
            $params = [
                ':name' => $this->name,
                ':canonical' => $this->canonical,
                ':description' => $this->description,
                ':id' => $id,  
            ];
            
            return $this->db->execute($sql, $params);
        } catch (PDOException $e) {
            echo "Lỗi SQL: " . $e->getMessage();
            return false;
        }
    }

}
