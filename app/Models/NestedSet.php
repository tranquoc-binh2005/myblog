<?php
namespace Models;

use Core\Database;

class NestedSet
{
    protected $db;
    protected $table;

    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->table = $table;
    }

    // Lấy tất cả các node trong cây
    public function getTree()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY `left` ASC";
        return $this->db->getAll($sql);
    }

    // Lấy một node theo ID
    public function getNode($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        return $this->db->getOne($sql, ['id' => $id]);
    }

    // Thêm một node vào trong cây
    public function insertNode($parentId, $data)
    {
        $parentNode = $this->getNode($parentId);
        if (!$parentNode) {
            throw new \Exception("Parent node not found");
        }

        // Cập nhật các giá trị left, right cho các node khác
        $this->db->execute("UPDATE {$this->table} SET `right` = `right` + 2 WHERE `right` >= :right", ['right' => $parentNode['right']]);
        $this->db->execute("UPDATE {$this->table} SET `left` = `left` + 2 WHERE `left` > :right", ['right' => $parentNode['right']]);

        // Thêm node mới vào vị trí đã cập nhật
        $sql = "INSERT INTO {$this->table} (`name`, `left`, `right`, `depth`) VALUES (:name, :left, :right, :depth)";
        $params = [
            'name' => $data['name'],
            'left' => $parentNode['right'],
            'right' => $parentNode['right'] + 1,
            'depth' => $parentNode['depth'] + 1
        ];
        return $this->db->insert($sql, $params);
    }

    // Xóa một node và các node con
    public function deleteNode($id)
    {
        $node = $this->getNode($id);
        if (!$node) {
            throw new \Exception("Node not found");
        }

        $nodeWidth = $node['right'] - $node['left'] + 1;

        // Xóa node và các node con trong khoảng left - right
        $this->db->execute("DELETE FROM {$this->table} WHERE `left` BETWEEN :left AND :right", [
            'left' => $node['left'],
            'right' => $node['right']
        ]);

        // Cập nhật lại left, right cho các node khác
        $this->db->execute("UPDATE {$this->table} SET `left` = `left` - :width WHERE `left` > :right", [
            'width' => $nodeWidth,
            'right' => $node['right']
        ]);
        $this->db->execute("UPDATE {$this->table} SET `right` = `right` - :width WHERE `right` > :right", [
            'width' => $nodeWidth,
            'right' => $node['right']
        ]);
    }
}
