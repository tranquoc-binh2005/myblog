<?php
namespace App\Models;

use Core\Database;
use PDOException;

class Language
{
    private $db;

    public function __construct(
        Database $db, 
        $name = null, 
        $canonical = null, 
        $image = null, 
    )
    {
        $this->db = $db;
        $this->name = $name;
        $this->canonical = $canonical;
        $this->image = $image;
    }

    public function pagination($tableName, $limit, $page = 1, $keyword, $publish, $deleted)
    {
        return $this->db->paginate($tableName, $limit, $page = 1, $keyword, $publish, $deleted);
    }

    public function save()
    {
        try {
            $sql = "INSERT INTO languages (name, canonical, image, user_id) 
                    VALUES (:name, :canonical, :image, :user_id)";
            $params = [
                ':name' => $this->name,
                ':canonical' => $this->canonical,
                ':image' => $this->image,
                ':user_id' => $_SESSION['user']['id'],
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
            $sql = "UPDATE languages SET name = :name, canonical = :canonical, image = :image WHERE id = :id";
            
            $params = [
                ':name' => $this->name,
                ':canonical' => $this->canonical,
                ':image' => $this->image,
                ':id' => $id,  
            ];
            
            return $this->db->execute($sql, $params);
        } catch (PDOException $e) {
            echo "Lỗi SQL: " . $e->getMessage();
            return false;
        }
    }
}
