<?php
namespace App\Models;

use Core\Database;

class NestedSet
{
    protected $db;

    public function __construct(Database $db, $table)
    {
        $this->db = $db;
        $this->table = $table;
    }

    public function getNode($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        return $this->db->getOne($sql, ['id' => $id]);
    }

    public function insertNode($parentId, $data)
    {
        if ($parentId == 0) {
            $maxRgtNode = $this->db->getOne("SELECT MAX(`rgt`) as max_rgt FROM {$this->table} WHERE `depth` = 0");

            $newLft = $maxRgtNode ? $maxRgtNode['max_rgt'] + 1 : 1;
            $newRgt = $newLft + 1;

            // Thêm node root mới
            $sql = "INSERT INTO {$this->table} (`parent_id`,`lft`, `rgt`, `depth`, `user_id`, `image`, `icon`, `album`, `publish`, `follow`)
                VALUES (:parent_id, :lft, :rgt, :depth, :user_id, :image, :icon, :album, :publish, :follow)";
            $params = [
                'parent_id' => !empty($data['parent_id']) ? $data['parent_id'] : 0,
                'lft' => $newLft,
                'rgt' => $newRgt,
                'depth' => 0,
                'user_id' => $_SESSION['user']['id'],
                'image' => !empty($data['image']) ? $data['image'] : null,
                'icon' => !empty($data['icon']) ? $data['icon'] : null,
                'album' => !empty($data['album']) ? $data['album'] : null,
                'publish' => !empty($data['publish']) ? $data['publish'] : null,
                'follow' => !empty($data['follow']) ? $data['follow'] : null,
            ];
            $lastId = $this->db->insert($sql, $params);
            return $lastId;
        }

        $parentNode = $this->getNode($parentId);
        if (!$parentNode) {
            throw new \Exception('Parent node not found');
        }

        $this->db->execute("UPDATE {$this->table} SET `rgt` = `rgt` + 2 WHERE `rgt` >= :rgt", ['rgt' => $parentNode['rgt']]);
        $this->db->execute("UPDATE {$this->table} SET `lft` = `lft` + 2 WHERE `lft` > :rgt", ['rgt' => $parentNode['rgt']]);

        $sql = "INSERT INTO {$this->table} (`parent_id`,`lft`, `rgt`, `depth`, `user_id`, `image`, `icon`, `album`, `publish`, `follow`)
                VALUES (:parent_id,:lft, :rgt, :depth, :user_id, :image, :icon, :album, :publish, :follow)";
        $params = [
            'parent_id' => !empty($data['parent_id']) ? $data['parent_id'] : 0,
            'lft' => $parentNode['rgt'],
            'rgt' => $parentNode['rgt'] + 1,
            'depth' => $parentNode['depth'] + 1,
            'user_id' => $_SESSION['user']['id'],
            'image' => !empty($data['image']) ? $data['image'] : null,
            'icon' => !empty($data['icon']) ? $data['icon'] : null,
            'album' => !empty($data['album']) ? $data['album'] : null,
            'publish' => !empty($data['publish']) ? $data['publish'] : null,
            'follow' => !empty($data['follow']) ? $data['follow'] : null,
        ];
        $lastId = $this->db->insert($sql, $params);
        return $lastId;
    }

    public function insertNodePivot($table, $post_catalogue_id, $language_id, $data)
    {
        $sql = "INSERT INTO $table (post_catalogue_id, language_id, name, description, content,canonical, meta_title, meta_keyword, meta_description)
                VALUES (:post_catalogue_id, :language_id,:name, :description, :content,:canonical, :meta_title, :meta_keyword,:meta_description)";

        $params = [
            'post_catalogue_id' => $post_catalogue_id,
            'language_id' => 1,
            'name' => !empty($data['name']) ? $data['name'] : null,
            'description' => !empty($data['description']) ? $data['description'] : null,
            'content' => !empty($data['content']) ? $data['content'] : null,
            'canonical' => !empty($data['canonical']) ? $data['canonical'] : null,
            'meta_title' => !empty($data['meta_title']) ? $data['meta_title'] : null,
            'meta_keyword' => !empty($data['meta_keyword']) ? $data['meta_keyword'] : null,
            'meta_description' => !empty($data['meta_description']) ? $data['meta_description'] : null,
        ];
        $this->db->insert($sql, $params);
        return true;
    }

    public function updateNode($nodeId, $data)
{
    $node = $this->getNode($nodeId);
    if (!$node) {
        throw new \Exception('Node không tồn tại');
    }

    $oldParentId = $node['parent_id'];
    $newParentId = $data['parent_id'];

    if ($oldParentId != $newParentId) {
        $nodeWidth = $node['rgt'] - $node['lft'] + 1;

        // 1. Tách node khỏi cây cũ
        $this->db->execute(
            "UPDATE {$this->table}
             SET lft = lft - :width
             WHERE lft > :rgt",
            ['width' => $nodeWidth, 'rgt' => $node['rgt']]
        );

        $this->db->execute(
            "UPDATE {$this->table}
             SET rgt = rgt - :width
             WHERE rgt > :rgt",
            ['width' => $nodeWidth, 'rgt' => $node['rgt']]
        );

        // 2. Lấy thông tin node cha mới
        $newParentNode = $this->getNode($newParentId);
        if (!$newParentNode) {
            throw new \Exception('Node cha mới không tồn tại');
        }

        $newParentRgt = $newParentNode['rgt'];

        // 3. Mở không gian cho node mới
        $this->db->execute(
            "UPDATE {$this->table}
             SET lft = lft + :width
             WHERE lft > :newParentRgt",
            ['width' => $nodeWidth, 'newParentRgt' => $newParentRgt]
        );

        $this->db->execute(
            "UPDATE {$this->table}
             SET rgt = rgt + :width
             WHERE rgt >= :newParentRgt",
            ['width' => $nodeWidth, 'newParentRgt' => $newParentRgt]
        );

        // 4. Di chuyển node và các node con
        $distance = $newParentRgt - $node['lft'] - ($newParentRgt < $node['lft'] ? 1 : $nodeWidth);
        $depthDifference = $newParentNode['depth'] + 1 - $node['depth'];

        $this->db->execute(
            "UPDATE {$this->table}
             SET lft = lft + :distance,
                 rgt = rgt + :distance,
                 depth = depth + :depthDifference
             WHERE lft BETWEEN :lft AND :rgt",
            [
                'distance' => $distance,
                'depthDifference' => $depthDifference,
                'lft' => $node['lft'],
                'rgt' => $node['rgt'],
            ]
        );
    }

    // 5. Cập nhật parent_id của node
    $this->db->execute(
        "UPDATE {$this->table}
         SET parent_id = :parent_id
         WHERE id = :id",
        [
            'id' => $nodeId,
            'parent_id' => $newParentId
        ]
    );

    return true;
}
    
    
    public function updateNodePivot($table, $nodeId, $languageId, $data)
    {
        try {
            $sql = "UPDATE $table
                SET name = :name,
                    description = :description,
                    content = :content,
                    canonical = :canonical,
                    meta_title = :meta_title,
                    meta_keyword = :meta_keyword,
                    meta_description = :meta_description
                WHERE post_catalogue_id = :node_id AND language_id = :language_id";

            $params = [
                'node_id' => $nodeId,
                'language_id' => $languageId,
                'name' => !empty($data['name']) ? $data['name'] : null,
                'description' => !empty($data['description']) ? $data['description'] : null,
                'content' => !empty($data['content']) ? $data['content'] : null,
                'canonical' => !empty($data['canonical']) ? $data['canonical'] : null,
                'meta_title' => !empty($data['meta_title']) ? $data['meta_title'] : null,
                'meta_keyword' => !empty($data['meta_keyword']) ? $data['meta_keyword'] : null,
                'meta_description' => !empty($data['meta_description']) ? $data['meta_description'] : null,
            ];
            $this->db->execute($sql, $params);
            return true;
        } catch (PDOException $e) {
            echo 'Lỗi SQL: ' . $e->getMessage();
            return false;
        }
    }

    public function baseDropDown($tb1, $tb2)
    {
        $sql = "SELECT tb1.id, tb1.parent_id, tb1.lft, tb1.rgt, tb1.depth,tb1.image,tb1.publish, tb2.name, tb2.canonical
                FROM $tb1 as tb1
                JOIN $tb2 as tb2
                ON tb1.id = tb2.post_catalogue_id
                AND tb1.deleted_at IS NULL
                ORDER BY tb1.lft ASC";
        return $this->db->getAll($sql);
    }

    public function dropDown($tb1, $tb2, $page, $perPage, $keyword, $status, $deleted)
    {
        $offset = ($page - 1) * $perPage;

        $sql = "SELECT tb1.id, tb1.parent_id, tb1.lft, tb1.rgt, tb1.depth, tb1.image, tb1.publish, tb2.description, tb2.content,
                    tb2.name, tb2.canonical
                FROM $tb1 as tb1
                JOIN $tb2 as tb2 ON tb1.id = tb2.post_catalogue_id
                WHERE 1=1";

        if ($deleted === true) {
            $sql .= ' AND deleted_at IS NOT NULL';
        } elseif ($deleted === false) {
            $sql .= ' AND deleted_at IS NULL';
        }
        if ($status != -1) {
            $sql .= " AND tb1.publish = $status";
        }

        if (!empty($keyword)) {
            $sql .= " AND (tb2.name LIKE '%$keyword%' OR tb2.canonical LIKE '%$keyword%')";
        }

        $sql .= " ORDER BY tb1.lft ASC LIMIT $offset, $perPage";

        $result = $this->db->getAll($sql);

        $totalSql = "SELECT COUNT(*) as count FROM $tb1 AS tb1
                    JOIN $tb2 AS tb2 ON tb1.id = tb2.post_catalogue_id
                    WHERE 1=1";

        if ($deleted === true) {
            $totalSql .= ' AND deleted_at IS NOT NULL';
        } elseif ($deleted === false) {
            $totalSql .= ' AND deleted_at IS NULL';
        }

        if (!empty($keyword)) {
            $totalSql .= " AND (tb2.name LIKE '%$keyword%' OR tb2.canonical LIKE '%$keyword%')";
        }

        if ($status != -1) {
            $totalSql .= " AND tb1.publish = $status";
        }

        $totalRecords = $this->db->getOne($totalSql);
        $totalPages = ceil($totalRecords['count'] / $perPage);

        return [
            'results' => $result,
            'totalPages' => $totalPages,
            'currentPage' => $page,
        ];
    }

    public function delete($id, $table)
    {
        try {
            $parent = $this->db->getOne("SELECT lft, rgt FROM $table WHERE id = :id", [':id' => $id]);

            if (!$parent) {
                throw new Exception('Node không tồn tại.');
            }

            $sql = "DELETE FROM $table WHERE lft BETWEEN :lft AND :rgt;";
            $params = [
                ':lft' => $parent['lft'],
                ':rgt' => $parent['rgt'],
            ];

            $result = $this->db->execute($sql, $params);
            if ($result) {
                $this->updateTreeAfterDelete($parent['lft'], $parent['rgt'], $table);
            }

            return $result;
        } catch (PDOException $e) {
            echo 'Lỗi SQL: ' . $e->getMessage();
            return false;
        } catch (Exception $e) {
            echo 'Lỗi: ' . $e->getMessage();
            return false;
        }
    }

    public function softDelete($id, $table)
    {
        try {
            $parent = $this->db->getOne("SELECT lft, rgt FROM $table WHERE id = :id", [':id' => $id]);
            $sql = "UPDATE $table SET deleted_at = NOW() WHERE lft BETWEEN :lft AND :rgt;";
            $params = [
                ':lft' => $parent['lft'],
                ':rgt' => $parent['rgt'],
            ];
            return $this->db->execute($sql, $params);
        } catch (PDOException $e) {
            echo 'Lỗi SQL: ' . $e->getMessage();
            return false;
        }
    }

    public function restore($id, $table)
    {
        try {
            $parent = $this->db->getOne("SELECT lft, rgt FROM $table WHERE id = :id", [':id' => $id]);
            $sql = "UPDATE $table SET deleted_at = NULL WHERE lft BETWEEN :lft AND :rgt;";
            $params = [
                ':lft' => $parent['lft'],
                ':rgt' => $parent['rgt'],
            ];
            return $this->db->execute($sql, $params);
        } catch (PDOException $e) {
            echo 'Lỗi SQL: ' . $e->getMessage();
            return false;
        }
    }

    private function updateTreeAfterDelete($lft, $rgt, $table)
    {
        try {
            $width = $rgt - $lft + 1;
            $this->db->execute("UPDATE $table SET lft = lft - :width WHERE lft > :rgt", [
                ':width' => $width,
                ':rgt' => $rgt,
            ]);

            $this->db->execute("UPDATE $table SET rgt = rgt - :width WHERE rgt > :rgt", [
                ':width' => $width,
                ':rgt' => $rgt,
            ]);
            return true;
        } catch (PDOException $e) {
            echo 'Lỗi SQL: ' . $e->getMessage();
            return false;
        }
    }
}
