<?php
namespace Core;

use PDOException;
class Controller
{
    public function __construct()
    {
    }
    public function model($model)
    {
        $filePath = 'app/Models/' . $model . '.php';
        if (file_exists($filePath)) {
            require_once $filePath;
            return new $model();
        } else {
            throw new Exception("Model file not found: " . $filePath);
        }
    }


    public function view($view, $data = [])
    {
        $filePath = dirname(__DIR__) . '/app/Views/' . $view . '.php';
        // echo "Looking for view file: " . $filePath;
    
        if (file_exists($filePath)) {
            extract($data);
            require_once $filePath;
        } else {
            die("View không tồn tại: " . $filePath);
        }
    }
}
$controller = new Controller();