<?php
namespace App\Controllers\Backend; 

use Core\Controller;


class DashboardController extends Controller{
    public function index() {
        $data['template'] = 'home/index';
        $this->view('admin/index', ['data' => $data]);
    }
}
