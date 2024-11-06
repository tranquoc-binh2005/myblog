<?php
namespace App\Models;

use Core\Database;
use PDOException;

class PostCatalogue
{
    private $db;

    public function __construct(
        Database $db, 
        $parent_id = null, 
        $lft = null, 
        $rgt = null, 
        $level = null, 
        $image = null, 
        $icon = null, 
        $album = null, 
        $publish = null, 
        $order = null, 
        $user_id = null, 
    )
    {
        $this->parent_id = $parent_id;
        $this->lft = $lft;
        $this->rgt = $rgt;
        $this->level = $level;
        $this->image = $image;
        $this->icon = $icon;
        $this->album = $album;
        $this->publish = $publish;
        $this->order = $order;
        $this->user_id = $user_id;
    }

    public function pagination($tableName, $limit, $page = 1, $keyword, $publish, $deleted)
    {
        return $this->db->paginate($tableName, $limit, $page = 1, $keyword, $publish, $deleted);
    }

    public function save()
    {
        try {
            $sql = "INSERT INTO post_catalogues (name, canonical, image, user_id) 
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
            $sql = "UPDATE post_catalogues SET name = :name, canonical = :canonical, image = :image WHERE id = :id";
            
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
