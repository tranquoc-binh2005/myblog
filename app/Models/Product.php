<?php
namespace App\Models;

use Core\Database;
use PDOException;

class Product
{
    private $db;

    public function __construct(
        Database $db,
        $parent_id = null,
        $image = null,
        $album = null,
        $publish = null,
        $follow = null,
        $price = null,
        $sale = null,
        $user_id = null,

        $language_id = null,
        $name = null,
        $description = null,
        $content = null,
        $canonical = null,
        $meta_title = null,
        $meta_keyword = null,
        $meta_description = null,
        $catalogue = null
    ) {
        $this->db = $db;
        $this->parent_id = $parent_id;
        $this->image = $image;
        $this->album = $album;
        $this->publish = $publish;
        $this->price = $price;
        $this->sale = $sale;
        $this->follow = $follow;
        $this->user_id = $_SESSION['user']['id'];

        $this->language_id = $language_id;
        $this->name = $name;
        $this->description = $description;
        $this->content = $content;
        $this->canonical = $canonical;
        $this->meta_title = $meta_title;
        $this->meta_keyword = $meta_keyword;
        $this->meta_description = $meta_description;
        $this->catalogue = $catalogue;
    }

    public function save($table, $tablePivot)
    {
        try {
            $sql = "INSERT INTO $table (parent_id, image, album, publish, follow, price, sale, user_id)
                    VALUES (:parent_id, :image, :album, :publish, :follow,:price, :sale, :user_id)";
            $params = [
                ':parent_id' => $this->parent_id,
                ':image' => $this->image,
                ':album' => $this->album,
                ':publish' => $this->publish,
                ':follow' => $this->follow,
                ':price' => $this->price,
                ':sale' => $this->sale,
                ':user_id' => $this->user_id,
            ];

            $lastId = $this->db->insert($sql, $params);

            $sqlPivot = "INSERT INTO $tablePivot (product_id, language_id, name, description, content, canonical, meta_title, meta_keyword, meta_description)
                    VALUES (:product_id, :language_id, :name, :description, :content, :canonical, :meta_title, :meta_keyword, :meta_description)";
            $paramsPivot = [
                ':product_id' => $lastId,
                ':language_id' => $this->language_id,
                ':name' => $this->name,
                ':description' => $this->description,
                ':content' => $this->content,
                ':canonical' => $this->canonical,
                ':meta_title' => $this->meta_title,
                ':meta_keyword' => $this->meta_keyword,
                ':meta_description' => $this->meta_description,
            ];
            $this->db->insert($sqlPivot, $paramsPivot);

            foreach ($this->catalogue as $catalogue) {
                $sql = 'INSERT INTO product_catalogue_product (catalogue_id, product_id) VALUES (:catalogue_id, :product_id)';
                $params = [
                    ':catalogue_id' => $catalogue,
                    ':product_id' => $lastId,
                ];
                $this->db->insert($sql, $params);
            }

            return true;
        } catch (PDOException $e) {
            echo 'Lỗi SQL: ' . $e->getMessage();
            return false;
        }
    }

    public function update($table, $tablePivot, $id)
    {
        try {
            $sql = "UPDATE $table
                    SET
                        parent_id = :parent_id,
                        image = :image,
                        album = :album,
                        publish = :publish,
                        follow = :follow,
                        price = :price,
                        sale = :sale,
                        user_id = :user_id
                    WHERE id = :id";
            $params = [
                ':parent_id' => $this->parent_id,
                ':image' => $this->image,
                ':album' => $this->album,
                ':publish' => $this->publish,
                ':follow' => $this->follow,
                ':price' => $this->price,
                ':sale' => $this->sale,
                ':user_id' => $this->user_id,
                ':id' => $id,
            ];

            $this->db->execute($sql, $params);

            $sqlPivot = "UPDATE $tablePivot
                        SET
                            language_id = :language_id,
                            name = :name,
                            description = :description,
                            content = :content,
                            canonical = :canonical,
                            meta_title = :meta_title,
                            meta_keyword = :meta_keyword,
                            meta_description = :meta_description
                        WHERE product_id = :product_id";

            $paramsPivot = [
                ':product_id' => $id,
                ':language_id' => $this->language_id,
                ':name' => $this->name,
                ':description' => $this->description,
                ':content' => $this->content,
                ':canonical' => $this->canonical,
                ':meta_title' => $this->meta_title,
                ':meta_keyword' => $this->meta_keyword,
                ':meta_description' => $this->meta_description,
            ];
            $this->db->execute($sqlPivot, $paramsPivot);
            $this->db->execute('DELETE FROM product_catalogue_product WHERE product_id = :product_id', ['product_id' => $id]);

            foreach ($this->catalogue as $catalogue) {
                $sql = 'INSERT INTO product_catalogue_product (catalogue_id, product_id) VALUES (:catalogue_id, :product_id)';
                $params = [
                    ':catalogue_id' => $catalogue,
                    ':product_id' => $id,
                ];
                $this->db->insert($sql, $params);
            }

            return true;
        } catch (PDOException $e) {
            echo 'Lỗi SQL: ' . $e->getMessage();
            return false;
        }
    }

    public function loadCatalogue($id)
    {
        $catalogues = $this->db->getAll('SELECT catalogue_id FROM product_catalogue_product WHERE product_id = :product_id', ['product_id'=>$id]);
        $catalogue_id = array_column($catalogues, 'catalogue_id');

        foreach ($catalogue_id as $val) {
            $cataloguesName[] = $this->loadNameCatalogue($val);
        }
        return $cataloguesName;
    }
    public function loadNameCatalogue($id)
    {
        return $this->db->getOne('SELECT name, catalogue_id as id FROM catalogue_language WHERE catalogue_id = :catalogue_id', ['catalogue_id'=>$id]);
    }

    public function countProduct($catalogue_id)
    {
        return $this->db->getOne('SELECT count(product_id) as count FROM product_catalogue_product WHERE catalogue_id = :catalogue_id', ['catalogue_id'=>$catalogue_id])['count'];
    }

    public function loadProduct($condition = [], $join = [], $id)
    {
        $selectColumns = '';
        if (!empty($condition)) {
            $condition = array_filter($condition, function ($field) {
                return preg_match('/^[a-zA-Z0-9_.*]+$/', $field);
            });
            $selectColumns = implode(', ', $condition);
        }

        if (!empty($condition)) {
            $condition = array_filter($condition, function ($field) {
                return preg_match('/^[a-zA-Z0-9_.*]+$/', $field);
            });
            $selectColumns = implode(', ', $condition);
        }


        if (!empty($join)) {
            $joinColumns = array_filter($join, function ($field) {
                return preg_match('/^[a-zA-Z0-9_.*]+$/', $field);
            });
            $selectColumns .= ', ' . implode(', ', $joinColumns);
        }

        $sql = "SELECT
                    $selectColumns
                FROM
                    product AS tb1
                JOIN
                    product_language AS tb2 ON tb1.id = tb2.product_id
                JOIN
                    product_catalogue_product AS tb3 ON tb1.id = tb3.product_id
                WHERE
                    tb1.id = :id;
                ";
        $params = ['id' => $id];

        $result = $this->db->getAll($sql, $params);
        $catalogue_id = array_column($result, 'catalogue_id');
        return [
            'result' => $result,
            'catalogue_id' => $catalogue_id,
        ];
    }

    public function findProduct($id)
    {
        $data = $this->db->getOne('SELECT tb1.catalogue_id, tb2.name 
                                    FROM product AS tb1
                                    JOIN product_language AS tb2 
                                    ON tb1.id = tb2.product_id 
                                    WHERE id = :id', ['id'=>$id]);
        $results = $this->loadNameCatalogue($data['catalogue_id']);
        return $result = [
            'catalogue' => $results['name'], 
            'name' => $data['name'],
            'id' => $id
        ];
    }

    public function getProductWithCatalogue($condition, $catalogue_id, $keyword)
    {
        $flattenedCondition = array_merge(...$condition);
    
        $selectColumns = implode(', ', $flattenedCondition);

        $sql = "SELECT $selectColumns
                FROM `product_catalogue_product` AS tb1
                JOIN `product_language` AS tb2 
                ON tb1.product_id = tb2.product_id
                JOIN `product` AS tb3
                ON tb1.product_id = tb3.id
                WHERE tb1.catalogue_id = $catalogue_id";

        if (!empty($keyword)) {
            $sql .= " AND tb2.name LIKE '%$keyword%'";
        }

        return $this->db->getAll($sql, $params);
    }

    public function getProductWithSlug($condition, $slug)
    {
        $flattenedCondition = array_merge(...$condition);
        $selectColumns = implode(', ', $flattenedCondition);

        $sql = "SELECT $selectColumns
                FROM `product` AS tb1
                JOIN `product_language` AS tb2 
                ON tb1.id = tb2.product_id
                WHERE tb2.canonical = '$slug'";

        return $this->db->getOne($sql);
    }

    public function getProductAttrSlug($condition, $slug){
        $flattenedCondition = array_merge(...$condition);
        $selectColumns = implode(', ', $flattenedCondition);

        $sql = "SELECT $selectColumns
                FROM `product` AS tb1
                JOIN `product_language` AS tb2 
                ON tb1.id = tb2.product_id
                WHERE tb2.canonical != '$slug'
                LIMIT 4";

        return $this->db->getAll($sql);
    }
}