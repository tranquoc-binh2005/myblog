<?php
namespace App\Requests;

class ProductRequest 
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function store($data) {
        $errors = [];

        if (empty($data['name'])) {
            $errors['name'] = "Bạn chưa nhập vào ô tiêu đề";
        }

        if ($data['catalogue_id'] < 0) {
            $errors['catalogue_id'] = "Bạn chưa chọn danh mục cha";
        }

        if ($data['catalogue'] < 0) {
            $errors['catalogue'] = "Bạn chưa chọn danh mục phụ";
        }

        if (!empty($errors)) {
            return $errors; 
        }

        return ['success' => true];
    }
}
