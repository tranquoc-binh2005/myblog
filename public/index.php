<?php
use App;
use Core\Database;
use Core\Controller;
require_once '../vendor/autoload.php';
$config = require_once '../Config/app.php';
$routes = require_once '../Route/routing.php';

$db = Database::getInstance($config);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath = $config['basePath'];
$uri = str_replace($basePath, '', $uri);

$found = false;

foreach ($routes as $route => $action) {
    if (strpos($route, '{id}') !== false) {
        $regex = preg_replace('/{id}/', '(\d+)', $route);
        if (preg_match('#^' . $regex . '$#', $uri, $matches)) {
            $found = true;
            array_shift($matches); 
            [$controller, $method] = $action;
            $controllerInstance = new $controller();
            call_user_func([$controllerInstance, $method], $matches[0]);
            break;
        }
    } elseif ($uri === $route) {
        $found = true;
        [$controller, $method] = $action;
        $controllerInstance = new $controller();
        call_user_func([$controllerInstance, $method]);
        break;
    }
}

if (!$found) {
    http_response_code(404);
    echo "404 - Not Found";
}