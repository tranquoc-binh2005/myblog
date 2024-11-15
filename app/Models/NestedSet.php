<?php
namespace App\Models;

use Core\Database;

class NestedSet
{
    protected $db;

    public function __construct(Database $db, $table, $tablePivot)
    {
        $this->db = $db;
        $this->table = $table;
        $this->tablePivot = $tablePivot;
    }

    private function getUserId()
    {
        return $_SESSION['user']['id'];
    }

    public function insert($payload, $parentId = 1, $primary)
    {
        $nodeParent = $this->getNode($parentId);
        $oldRgt = $nodeParent['rgt'];

        $this->db->execute("UPDATE $this->table SET rgt = rgt + 2 WHERE rgt >= $oldRgt");
        $this->db->execute("UPDATE $this->table SET lft = lft + 2 WHERE lft > $oldRgt");

        $defaultFields = [
            'parent_id' => $parentId,
            'lft' => $oldRgt,
            'rgt' => $oldRgt + 1,
            'depth' => $nodeParent['depth'] + 1,
            'user_id' => $this->getUserId(),
        ];

        $columns = [];
        $values = [];
        foreach ($payload['field'] as $field) {
            if (isset($defaultFields[$field])) {
                $columns[] = $field;
                $values[] = $defaultFields[$field];
            } elseif (isset($payload[$field]) && !is_array($payload[$field])) {
                $columns[] = $field;
                $values[] = $payload[$field];
            }
        }

        $fieldString = implode(', ', $columns);
        $valueString = implode(
            ', ',
            array_map(function ($value) {
                return is_string($value) ? "'" . addslashes($value) . "'" : $value;
            }, $values),
        );

        $sql = "INSERT INTO $this->table ($fieldString) VALUES ($valueString)";
        $lastId = $this->db->insert($sql);

        $dynamicColumns = [];
        $dynamicValues = [];
        foreach ($payload as $key => $value) {
            if (!is_array($value) && !in_array($key, $columns)) {
                $dynamicColumns[] = $key;
                $dynamicValues[] = $value;
            }
        }

        if (!empty($dynamicColumns)) {
            $dynamicField = implode(', ', $dynamicColumns);
            $dynamicParams = implode(
                ', ',
                array_map(function ($param) {
                    return "'" . addslashes($param) . "'";
                }, $dynamicValues),
            );

            $sqlPivot = "INSERT INTO $this->tablePivot ($primary[0], $primary[1], $dynamicField) VALUES ($lastId, '1', $dynamicParams)";
            $this->db->insert($sqlPivot);
        }

        return true;
    }

    public function delete($id)
    {
        $node = $this->getNode($id);
        $nodeLft = $node['lft'];
        $nodeRgt = $node['rgt'];
        $widthNode = $nodeRgt - $nodeLft + 1;

        $sql = "DELETE FROM $this->table WHERE lft BETWEEN :lft AND :rgt";

        $this->db->execute($sql, ['lft' => $nodeLft, 'rgt' => $nodeRgt]);
        $this->db->execute('UPDATE ' . $this->table . ' SET lft = lft - :width WHERE lft > :lft', ['width' => $widthNode, 'lft' => $nodeLft]);
        $this->db->execute('UPDATE ' . $this->table . ' SET rgt = rgt - :width WHERE rgt > :rgt', ['width' => $widthNode, 'rgt' => $nodeRgt]);
        return true;
    }

    public function softDelete($id)
    {
        try {
            $parent = $this->getNode($id);
            $sql = 'UPDATE ' . $this->table . ' SET deleted_at = NOW() WHERE lft BETWEEN :lft AND :rgt';
            return $this->db->execute($sql, [
                'lft' => $parent['lft'],
                'rgt' => $parent['rgt'],
            ]);
        } catch (PDOException $e) {
            echo 'Lỗi SQL: ' . $e->getMessage();
            return false;
        }
    }

    public function restore($id)
    {
        try {
            $parent = $this->getNode($id);
            $params = [
                ':lft' => $parent['lft'],
                ':rgt' => $parent['rgt'],
            ];
            return $this->db->execute('UPDATE ' . $this->table . ' SET deleted_at = NULL WHERE lft BETWEEN :lft AND :rgt', $params);
        } catch (PDOException $e) {
            echo 'Lỗi SQL: ' . $e->getMessage();
            return false;
        }
    }

    public function dropDown($condition = [], $join = [], $payload = [], $primary)
    {
        $page = isset($payload['page']) ? $payload['page'] : 1;
        $perPage = isset($payload['perPage']) ? $payload['perPage'] : 10;
        $offset = ($page - 1) * $perPage;

        if (!empty($condition)) {
            $selectColumns = implode(', ', $condition);
        }

        if (!empty($join)) {
            $extraColumns = [];
            foreach ($join as $column) {
                $extraColumns[] = implode(', ', (array) $column);
            }
            $selectColumns .= ', ' . implode(', ', $extraColumns);
        }

        $sql = "SELECT $selectColumns
                FROM $this->table as tb1
                JOIN $this->tablePivot as tb2 ON tb1.id = tb2.$primary
                WHERE 1=1";

        $countSql = "SELECT COUNT(*) AS total
            FROM $this->table as tb1
            JOIN $this->tablePivot as tb2 ON tb1.id = tb2.$primary
            WHERE 1=1";
        if (isset($payload['flag'])) {
            if ($payload['flag'] != 1) {
                $sql .= ' AND tb1.deleted_at IS NOT NULL';
            } else {
                $sql .= ' AND tb1.deleted_at IS NULL';
            }
            $countSql .= $payload['flag'] != 1 ? ' AND tb1.deleted_at IS NOT NULL' : ' AND tb1.deleted_at IS NULL';
        }

        if (isset($payload['keyword']) && !empty($payload['keyword'])) {
            $keyword = '%' . $payload['keyword'] . '%';
            $sql .= " AND (name LIKE '{$keyword}' OR description LIKE '{$keyword}')";
            $countSql .= " AND (name LIKE '{$keyword}' OR description LIKE '{$keyword}')";
        }

        if (isset($payload['publish']) && $payload['publish'] != -1) {
            $publishCondition = (int)$payload['publish']; 
            $sql .= " AND tb1.publish = {$publishCondition}";
            $countSql .= " AND tb1.publish = {$publishCondition}";
        }

        $sql .= " ORDER BY id ASC LIMIT $perPage OFFSET $offset";

        $result = $this->db->getAll($sql);

        $totalRecords = $this->db->getOne($countSql)['total'];

        $totalPage = ceil($totalRecords / $perPage);

        return [
            'result' => $result,
            'currentPage' => $page,
            'totalPage' => $totalPage,
            'totalRecords' => $totalRecords,
            'perPage' => $perPage,
        ];
    }

    public function update($payload, $id)
    {
        $node = $this->getNode($id);
        $oldNodeRgt = $node['rgt'];
        $parent = $this->getNode($payload['parent_id']);
        if ($node['parent_id'] != $payload['parent_id']){

            $newPosition = $parent['rgt'];
            $width = $node['rgt'] - $node['lft'] + 1;

            $sqlUpdateLft = "UPDATE $this->table SET lft = lft + $width WHERE lft >= $newPosition";
            $sqlUpdateRgt = "UPDATE $this->table SET rgt = rgt + $width WHERE rgt >= $newPosition";

            $this->db->execute($sqlUpdateLft);
            $this->db->execute($sqlUpdateRgt);

            $distance = $parent['rgt'] - $node['lft'];
            $newLft = $node['lft'] + $distance;
            $newRgt = $node['rgt'] + $distance;
            $tmp = $node['lft'];
            $widthDepth = $parent['depth'] + 1 - $node['depth'];
            $newDepth = $node['depth'] + $widthDepth;

            if($distance < 0){
                $distance -= $width;
                $tmp += $width;
            }

            $sqlMoveNode = "UPDATE $this->table 
                SET 
                    lft = $newLft, 
                    rgt = $newRgt, 
                    parent_id = :parent_id ,
                    depth = $newDepth
                WHERE lft >= $tmp AND rgt < $tmp + $width";
            $params = [
                'parent_id' => $payload['parent_id']
            ];
            $this->db->execute($sqlMoveNode, $params);

            $sqlRemoveLft = "UPDATE $this->table SET lft = lft - $width WHERE lft > " . $oldNodeRgt;
            $sqlRemoveRgt = "UPDATE $this->table SET rgt = rgt - $width WHERE rgt > " . $oldNodeRgt;

            $this->db->execute($sqlRemoveLft);
            $this->db->execute($sqlRemoveRgt);
        }

        $table1Data = array_intersect_key($payload, array_flip($payload['table']));
        $table2Data = array_intersect_key($payload, array_flip($payload['pivot']));

        $updatedTable1 = $this->buildUpdateQuery($this->table, $table1Data, 'id', $id);
        $updatedTable2 = $this->buildUpdateQuery($this->tablePivot, $table2Data, 'post_catalogue_id', $id);

        return true;
    }

    private function buildUpdateQuery($table, $data, $idColumn, $idValue) {
        $updateFields = [];
        $params = [];
    
        foreach ($data as $field => $value) {
            if (!is_null($value)) {
                $updateFields[] = "`$field` = :$field";
                $params[":$field"] = $value;
            }
        }
    
        if (empty($updateFields)) {
            return false;
        }
    
        $sql = "UPDATE $table SET " . implode(', ', $updateFields) . " WHERE `$idColumn` = :id";
        $params[':id'] = $idValue;
    
        $this->db->execute($sql, $params); 
    }
    
    
    private function updateAfterDelete($node)
    {
        $width = $node['rgt'] - $node['lft'] + 1;
        $sql = "UPDATE $this->table SET deleted_at = NOW() WHERE lft BETWEEN :lft AND :rgt";
        $this->db->execute($sql, ['lft' => $node['lft'], 'rgt' => $node['rgt']]);
        $this->db->execute("UPDATE $this->table SET lft = lft - :width WHERE lft > :lft AND depth > 0", ['width' => $width, 'lft' => $node['lft']]);
        $this->db->execute("UPDATE $this->table SET rgt = rgt - :width WHERE rgt > :rgt AND depth > 0", ['width' => $width, 'rgt' => $node['rgt']]);
    }
    private function getNode($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        return $this->db->getOne($sql, ['id' => $id]);
    }
}