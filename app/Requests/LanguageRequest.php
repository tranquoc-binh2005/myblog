<?php
namespace App\Requests;

class LanguageRequest 
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function store($data) {
        $errors = [];

        if (empty($data['name'])) {
            $errors['name'] = "Name là bắt buộc";
        }

        if (empty($data['canonical'])) {
            $errors['canonical'] = "canonical là bắt buộc";
        }

        if (!empty($errors)) {
            return $errors; 
        }

        return ['success' => true];
    }
}
