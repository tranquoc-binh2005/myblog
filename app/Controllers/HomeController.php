<?php
namespace App\Controllers; 

use Core\Controller;

class HomeController extends Controller {
    public function __construct()
    {
    }
    public function index() {
        $this->view('client/home/index', ['']);
    }
}
