<?php
namespace App\Controllers;

class UserController {
    public function show($id) {
       if($id){
        echo "Thông tin người dùng với ID: " . htmlspecialchars($id);
       } else {
        echo 'id khong ton tai';
       }
    }
}
