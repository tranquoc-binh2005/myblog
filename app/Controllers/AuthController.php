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
                alertSuccess('Đăng nhập thành công', "", 'trang-chu');
            } else {
                $data['email'] = $_POST['email'];
                $errors = $validationResult;
                $data['template'] = 'auth/login';
                // $data['title'] = $GLOBALS['sub']['user']['title']['create'];
                $this->view('client/index', ['errors' => $errors, 'data' => $data]);
            }
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
