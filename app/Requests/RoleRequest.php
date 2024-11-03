<?php
namespace App\Requests;

class RoleRequest 
{
    public static function store($data) {
        $errors = [];

        if (empty($data['name'])) {
            $errors['name'] = "Name là bắt buộc";
        }

        if (empty($data['canonical'])) {
            $errors['canonical'] = "Canonical là bắt buộc";
        }

        if (!empty($errors)) {
            return $errors; 
        }

        return ['success' => true];
    }
}
