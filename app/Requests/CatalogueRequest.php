<?php
namespace App\Requests;

class CatalogueRequest 
{
    private $db;
    private $PostCatalogueModel;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function store($data) {
        $errors = [];

        if (empty($data['name'])) {
            $errors['name'] = "Bạn chưa nhập vào ô tiêu đề";
        }

        if ($data['parent_id'] < 0) {
            $errors['parent_id'] = "Bạn chưa chọn danh mục cha";
        }

        if (!empty($errors)) {
            return $errors; 
        }

        return ['success' => true];
    }
}
