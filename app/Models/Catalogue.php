<?php
namespace App\Models;

use Core\Database;
use PDOException;

class Catalogue
{
    private $db;

    public function __construct(
        Database $db
    )
    {
        $this->db = $db;
    }

    public function loadCatalogue($id)
    {
        $sql = "SELECT tb1.*, tb2.* 
                FROM catalogue as tb1 
                JOIN catalogue_language as tb2 
                ON tb1.id = tb2.catalogue_id 
                WHERE tb1.id = :id";
        $params = ['id' => $id];

        return $this->db->getOne($sql, $params);
    }
}
