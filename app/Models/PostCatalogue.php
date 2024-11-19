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
        $user_id = null
    )
    {
        $this->db = $db;
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

    public function loadPostCatalogue($id)
    {
        $sql = "SELECT tb1.*, tb2.* 
                FROM post_catalogues as tb1 
                JOIN post_catalogue_language as tb2 
                ON tb1.id = tb2.post_catalogue_id 
                WHERE tb1.id = :id";
        $params = ['id' => $id];

        return $this->db->getOne($sql, $params);
    }
}
