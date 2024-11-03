<?php
namespace App\Controllers; 

use Core\Controller;

class HomeController extends Controller {
    public function __construct()
    {
    }
    public function index() {
        $data['body'] = 'home';
        $data['template'] = 'home/index';
        $this->view('client/index', ['data' => $data]);
    }
}
