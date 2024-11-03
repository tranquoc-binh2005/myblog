<?php
namespace App\Models;

use Core\Database;
class Base
{
    private $db;
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function changeStatus($id, $filed, $column, $newValue)
    {
        try {
            $sql = "UPDATE $filed SET $column = ? WHERE id = ?";
            $params = [$newValue, $id];
            return $this->db->execute($sql, $params);
        } catch (PDOException $e) {
            echo 'Lỗi SQL: ' . $e->getMessage();
            return false;
        }
    }

    public function changeStatusAlls($ids, $filed, $column, $newValue)
    {
        try {
            $placeholders = rtrim(str_repeat('?,', count($ids)), ',');
            $sql = "UPDATE $filed SET $column = ? WHERE id IN ($placeholders)";

            $params = array_merge([$newValue], $ids);

            return $this->db->execute($sql, $params);
            return $sql;
        } catch (PDOException $e) {
            echo 'Lỗi SQL: ' . $e->getMessage();
            return false;
        }
    }

    public function find($id, $table)
    {
        $sql = "SELECT * FROM $table WHERE id = :id";
        $params = [
            'id' => $id
        ];
        return $this->db->getOne($sql, $params);
    }
    public function delete($id, $table)
    {
        try {
            $sql = "DELETE FROM $table WHERE id = :id";
            $params = [
                ':id' => $id
            ];
            return $this->db->execute($sql, $params); 
        } catch (PDOException $e) {
            echo "Lỗi SQL: " . $e->getMessage();
            return false;
        }
    }

    public function softDelete($id, $table)
    {
        try {
            $sql = "UPDATE $table SET deleted_at = NOW() WHERE id = :id";
            $params = [
                ':id' => $id
            ];
            return $this->db->execute($sql, $params);
        } catch (PDOException $e) {
            echo "Lỗi SQL: " . $e->getMessage();
            return false;
        }
    }

    public function restore($id, $table)
    {
        try {
            $sql = "UPDATE $table SET deleted_at = NULL WHERE id = :id";
            $params = [
                ':id' => $id
            ];
            return $this->db->execute($sql, $params);
        } catch (PDOException $e) {
            echo "Lỗi SQL: " . $e->getMessage();
            return false;
        }
    }

    public function all($table)
    {
        try {
            $sql = "SELECT * FROM $table WHERE deleted_at IS NULL";
            return $this->db->getAll($sql);
        } catch (PDOException $e) {
            echo "Lỗi SQL: " . $e->getMessage();
            return false;
        }
    }
}
