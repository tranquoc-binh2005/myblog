<?php
namespace App\Models;

use Core\Database;
use PDOException;

class Post
{
    private $db;

    public function __construct(
        Database $db,
        $post_catalogue_id = null,
        $image = null,
        $album = null,
        $publish = null,
        $follow = null,
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
        $this->post_catalogue_id = $post_catalogue_id;
        $this->image = $image;
        $this->album = $album;
        $this->publish = $publish;
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
            $sql = "INSERT INTO $table (post_catalogue_id, image, album, publish, follow, user_id)
                    VALUES (:post_catalogue_id, :image, :album, :publish, :follow, :user_id)";
            $params = [
                ':post_catalogue_id' => $this->post_catalogue_id,
                ':image' => $this->image,
                ':album' => $this->album,
                ':publish' => $this->publish,
                ':follow' => $this->follow,
                ':user_id' => $this->user_id,
            ];

            $lastId = $this->db->insert($sql, $params);

            $sqlPivot = "INSERT INTO $tablePivot (post_id, language_id, name, description, content, canonical, meta_title, meta_keyword, meta_description)
                    VALUES (:post_id, :language_id, :name, :description, :content, :canonical, :meta_title, :meta_keyword, :meta_description)";
            $paramsPivot = [
                ':post_id' => $lastId,
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
                $sql = 'INSERT INTO post_catalogue_post (post_catalogue_id, post_id) VALUES (:post_catalogue_id, :post_id)';
                $params = [
                    ':post_catalogue_id' => $catalogue,
                    ':post_id' => $lastId,
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
                        post_catalogue_id = :post_catalogue_id,
                        image = :image,
                        album = :album,
                        publish = :publish,
                        follow = :follow,
                        user_id = :user_id
                    WHERE id = :id";
            $params = [
                ':post_catalogue_id' => $this->post_catalogue_id,
                ':image' => $this->image,
                ':album' => $this->album,
                ':publish' => $this->publish,
                ':follow' => $this->follow,
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
                        WHERE post_id = :post_id";

            $paramsPivot = [
                ':post_id' => $id,
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
            $this->db->execute('DELETE FROM post_catalogue_post WHERE post_id = :post_id', ['post_id' => $id]);

            foreach ($this->catalogue as $catalogue) {
                $sql = 'INSERT INTO post_catalogue_post (post_catalogue_id, post_id) VALUES (:post_catalogue_id, :post_id)';
                $params = [
                    ':post_catalogue_id' => $catalogue,
                    ':post_id' => $id,
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
        $catalogues = $this->db->getAll('SELECT post_catalogue_id FROM post_catalogue_post WHERE post_id = :post_id', ['post_id'=>$id]);
        $catalogue_id = array_column($catalogues, 'post_catalogue_id');

        foreach ($catalogue_id as $val) {
            $cataloguesName[] = $this->loadNameCatalogue($val);
        }
        return $cataloguesName;
    }
    public function loadParentCatalogue($id)
    {
        $catalogues = $this->db->getOne('SELECT post_catalogue_id,name FROM post_catalogue_language WHERE post_catalogue_id = :post_catalogue_id', ['post_catalogue_id'=>$id]);

        return $catalogues;
    }
    public function loadNameCatalogue($id)
    {
        return $this->db->getOne('SELECT canonical, name, post_catalogue_id as id FROM post_catalogue_language WHERE post_catalogue_id = :post_catalogue_id', ['post_catalogue_id'=>$id]);
    }

    public function loadPost($condition = [], $join = [], $id)
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
            $condition[] = 'tb1.post_catalogue_id as parent_id'; 
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
                    posts AS tb1
                JOIN
                    post_languages AS tb2 ON tb1.id = tb2.post_id
                JOIN
                    post_catalogue_post AS tb3 ON tb1.id = tb3.post_id
                WHERE
                    tb1.id = :id;
                ";
        $params = ['id' => $id];

        $result = $this->db->getAll($sql, $params);
        $post_catalogue_id = array_column($result, 'post_catalogue_id');
        return [
            'result' => $result,
            'post_catalogue_id' => $post_catalogue_id,
        ];
    }

    public function findPost($id)
    {
        $data = $this->db->getOne('SELECT tb1.post_catalogue_id, tb2.name 
                                    FROM posts AS tb1
                                    JOIN post_languages AS tb2 
                                    ON tb1.id = tb2.post_id 
                                    WHERE id = :id', ['id'=>$id]);
        $results = $this->loadNameCatalogue($data['post_catalogue_id']);
        return $result = [
            'catalogue' => $results['name'], 
            'name' => $data['name'],
            'id' => $id
        ];
    }

    public function getBlogWithCataloge($condition, $catalogue_id, $keyword)
    {
        $flattenedCondition = array_merge(...$condition);
        $selectColumns = implode(', ', $flattenedCondition);

        $sql = "SELECT $selectColumns
                FROM `posts` AS tb1
                JOIN `post_languages` AS tb2 
                ON tb1.id = tb2.post_id
                WHERE 1=1";

        $params = [];

        if (!empty($catalogue_id) && ($catalogue_id > 1)) {
            $sql .= " AND tb1.post_catalogue_id = ?";
            $params[] = $catalogue_id;
        }

        if (!empty($keyword)) {
            $sql .= " AND tb2.name LIKE ?";
            $params[] = '%' . $keyword . '%';
        }

        return $this->db->getAll($sql, $params);
    }

    public function getBlogWithSlug($condition, $slug)
    {
        $flattenedCondition = array_merge(...$condition);
        $selectColumns = implode(', ', $flattenedCondition);

        $sql = "SELECT $selectColumns
                FROM `posts` AS tb1
                JOIN `post_languages` AS tb2 
                ON tb1.id = tb2.post_id
                WHERE tb2.canonical = '$slug'";

        return $this->db->getOne($sql);
    }

    public function getBlogAttrSlug($condition, $slug){
        $flattenedCondition = array_merge(...$condition);
        $selectColumns = implode(', ', $flattenedCondition);

        $sql = "SELECT $selectColumns
                FROM `posts` AS tb1
                JOIN `post_languages` AS tb2 
                ON tb1.id = tb2.post_id
                WHERE tb2.canonical != '$slug'
                LIMIT 4";

        return $this->db->getAll($sql);
    }

}