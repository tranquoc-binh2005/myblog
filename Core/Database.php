<?php
namespace Core;

use PDO;
use PDOException;

class Database
{
    private $connection;

    public function __construct($config)
    {
        $this->host = $config['db_host'];
        $this->dbname = $config['db_name'];
        $this->username = $config['db_user'];
        $this->password = $config['db_password'];

        try {
            $this->connection = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            error_log('Database connection failed: ' . $e->getMessage()); // Consider logging errors
            echo 'Kết nối không thành công.';
        }
    }

    public function getAll($sql, $params = [])
    {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getOne($sql, $params = [])
    {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function insert($sql, $params = [])
    {
        try {
            $stmt = $this->connection->prepare($sql);
            foreach ($params as $param => $value) {
                $stmt->bindValue($param, $value);
            }
            $stmt->execute();
            return $this->connection->lastInsertId();
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function execute($sql, $params = [])
    {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function paginate($tableName, $limit, $page, $keyword, $publish, $deleted)
    {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM $tableName WHERE 1=1";
    
        if ($deleted === true) {
            $sql .= " AND deleted_at IS NOT NULL";
        } elseif ($deleted === false) {
            $sql .= " AND deleted_at IS NULL";
        }
    
        if (!empty($keyword)) {
            $sql .= ' AND name LIKE :keyword'; 
        }
    
        if ($publish != -1) {
            $sql .= ' AND publish = :publish';
        }
    
        $sql .= ' LIMIT :limit OFFSET :offset';
    
        $stmt = $this->connection->prepare($sql);
    
        if (!empty($keyword)) {
            $keywordParam = '%' . $keyword . '%';
            $stmt->bindValue(':keyword', $keywordParam, PDO::PARAM_STR);
        }
    
        if ($publish != -1) {
            $stmt->bindValue(':publish', $publish, PDO::PARAM_INT);
        }
    
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
    
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $totalSql = "SELECT COUNT(*) FROM $tableName WHERE 1=1" .
            ($deleted === true ? ' AND deleted_at IS NOT NULL' : 
             ($deleted === false ? ' AND deleted_at IS NULL' : '')) . 
            (!empty($keyword) ? ' AND name LIKE :keyword' : '') . 
            ($publish != -1 ? ' AND publish = :publish' : '');
    
        $totalStmt = $this->connection->prepare($totalSql);
    
        if (!empty($keyword)) {
            $totalStmt->bindValue(':keyword', $keywordParam, PDO::PARAM_STR);
        }
    
        if ($publish != -1) {
            $totalStmt->bindValue(':publish', $publish, PDO::PARAM_INT);
        }
    
        $totalStmt->execute();
        $totalRecords = $totalStmt->fetchColumn();
        $totalPages = ceil($totalRecords / $limit);
    
        return [
            'data' => $results,
            'total_pages' => $totalPages,
            'current_page' => $page,
        ];
    }
}
