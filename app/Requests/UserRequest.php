<?php
namespace App\Requests;

use App\Models\User;

class UserRequest 
{
    private $db;
    private $UserModel;

    public function __construct($db)
    {
        $this->db = $db;
        $this->UserModel = new User($this->db);
    }

    public function store($data) {
        $errors = [];

        if (empty($data['name'])) {
            $errors['name'] = "Name là bắt buộc";
        }

        if (empty($data['email'])) {
            $errors['email'] = "Email là bắt buộc";
        }
        if (empty($data['password'])) {
            $errors['password'] = "Password là bắt buộc";
        }
        if (empty($data['re_password'])) {
            $errors['re_password'] = "Re_password là bắt buộc";
        }

        if (!empty($data['password']) && strlen($data['password']) < 6) {
            $errors['password'] = "Password ít nhất 6 kí tự";
        }
        if (!empty($data['re_password']) && strlen($data['re_password']) < 6) {
            $errors['re_password'] = "Password ít nhất 6 kí tự";
        }

        if($data['password'] != $data['re_password']){
            $errors['confirm'] = "Mật khẩu phải giống nhau";
        }
        if(empty($data['userCatalogue_id'])){
            $errors['userCatalogue_id'] = "Vai trò là bắt buộc";
        }
        

        if ($this->isEmailExists($data['email'])['count'] > 0) {
            $errors['email'] = "Email đã tồn tại";
        } 

        if (!empty($errors)) {
            return $errors; 
        }

        return ['success' => true];
    }

    public function login($data)
    {
        $errors = [];

        if (empty($data['email'])) {
            $errors['email'] = "Bạn chưa nhập email";
        }
        if (empty($data['password'])) {
            $errors['password'] = "Bạn chưa nhập mật khẩu";
        }

        $result = $this->validateUser($data['email']);
        if($result){
            $isPasswordCorrect = password_verify($data['password'], $result['password']);
            if($isPasswordCorrect){
                unset($_SESSION['user']);
                $_SESSION['user'] = $result;
                return ['success' => true];
            } else {
                $errors['password'] = "Sai mật khẩu";
            }
        } else {
            $errors['email'] = "Tài khoản hoặc mật khẩu không hợp lệ";
        }

        if (!empty($errors)) {
            return $errors; 
        }

        return ['success' => true];
    }

    private function isEmailExists($email) {
        return $this->UserModel->isEmailExits($email);
    }
    private function validateUser($email)
    {
        return $this->UserModel->checkUser($email);
    }
}
