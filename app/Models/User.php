<?php
namespace App\Models;

use Core\Database;
use PDOException;

class User
{
    private $db;

    public function __construct(
        Database $db, 
        $userCatalogue_id = null, 
        $name = null, 
        $description = null, 
        $image = null, 
        $address = null,
        $phone = null,
        $email = null,
        $password = null,
    )
    {
        $this->db = $db;
        $this->userCatalogue_id = $userCatalogue_id;
        $this->name = $name;
        $this->description = $description;
        $this->image = $image;
        $this->address = $address;
        $this->phone = $phone;
        $this->email = $email;
        $this->password = $password;
    }

    public function pagination($tableName, $limit, $page = 1, $keyword, $publish, $deleted)
    {
        return $this->db->paginate($tableName, $limit, $page = 1, $keyword, $publish, $deleted);
    }

    public function loadUserCatalogue_name($id)
    {
        $sql = "SELECT name FROM user_catalogue WHERE id = :id";
        $params = ['id' => $id];

        $result = $this->db->getOne($sql, $params);
        return $result ? $result['name'] : null;
    }

    public function save()
    {
        try {
            $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO user (userCatalogue_id, name, description, image, address, phone, email, password) 
                    VALUES (:userCatalogue_id, :name, :description, :image, :address, :phone, :email, :password)";
            $params = [
                ':userCatalogue_id' => $this->userCatalogue_id,
                ':name' => $this->name,
                ':description' => $this->description,
                ':image' => $this->image,
                ':address' => $this->address,
                ':phone' => $this->phone,
                ':email' => $this->email,
                ':password' => $hashedPassword,
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

    public function isEmailExits($email)
    {
        $sql = "SELECT COUNT(*) as count FROM user WHERE email = :email";
        $params = ['email' => $email];

        return $this->db->getOne($sql, $params);
    }
    public function checkUser($email)
    {
        $sql = "SELECT id, name, email, userCatalogue_id, created_at, updated_at, deleted_at FROM user WHERE email = :email";
        $params = ['email' => $email];

        return $this->db->getOne($sql, $params);
    }
}
