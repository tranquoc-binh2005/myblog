<?php
namespace App\Requests;

use App\Models\PostCatalogue;

class PostCatalogueRequest 
{
    private $db;
    private $PostCatalogueModel;

    public function __construct($db)
    {
        $this->db = $db;
        $this->PostCatalogueModel = new PostCatalogue($this->db);
    }

    public function store($data) {
        $errors = [];

        if (empty($data['name'])) {
            $errors['name'] = "Bạn chưa nhập vào ô tiêu đề";
        }

        if (empty($data['canonical'])) {
            $errors['canonical'] = "Bạn chưa nhập vào ô đường dẫn";
        }

        if (empty($data['parent_id'])) {
            $errors['parent_id'] = "Bạn chưa chọn danh mục cha";
        }

        if (!empty($errors)) {
            return $errors; 
        }

        return ['success' => true];
    }
}
