<?php
namespace App\Requests;

class PostRequest 
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

        if (empty($data['canonical'])) {
            $errors['canonical'] = "Bạn chưa nhập vào ô đường dẫn";
        }

        if ($data['post_catalogue_id'] < 0) {
            $errors['post_catalogue_id'] = "Bạn chưa chọn danh mục cha";
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
