<?php

namespace Route;

use App\Controllers\HomeController;
use App\Controllers\UserController;

$routes = [
    '/' => [HomeController::class, 'index'],
    '/trang-chu' => [HomeController::class, 'index'],
    '/nguoi-dung/{id}' => [UserController::class, 'show'],
];

return $routes;