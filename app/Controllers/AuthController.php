<?php
namespace App\Controllers; 

use Core\Controller;
use App\Requests\UserRequest;

class AuthController extends Controller {
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function login() {
        if (isset($_SESSION['user'])) {
            header('location: trang-chu');
            exit;
        }    
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data['body'] = 'login';
            $data['template'] = 'auth/login';
            $this->view('client/index', ['data' => $data]);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $request = new UserRequest($this->db);
            $validationResult = $request->login($data);
            if (isset($validationResult['success'])) {
                if($validationResult['role'] != 2 ? $path = 'trang-chu' : $path = 'quan-tri-vien');
                alertSuccess('Đăng nhập thành công', "", $path);
            } else {
                $data['email'] = $_POST['email'];
                $errors = $validationResult;
                $data['template'] = 'auth/login';
                $this->view('client/index', ['errors' => $errors, 'data' => $data]);
            }
        }
    }

    public function logout()
    {
        if(isset($_SESSION['user'])){
            unset($_SESSION['user']);
            alertSuccess('Thành công', '', 'trang-chu');
        } else {
            alertError('That bai', '', 'trang-chu');
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data['body'] = 'login';
            $data['template'] = 'auth/register';
            $this->view('client/index', ['data' => $data]);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo 124;
        }
    }
}
