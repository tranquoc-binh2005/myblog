<?php

namespace Route;

use App\Controllers\Backend\DashboardController;
use App\Controllers\Backend\UserCatalogueController;
use App\Controllers\Backend\UserController as BackendUserController;
use App\Controllers\Ajax\ChangeStatusController;

use App\Controllers\HomeController;
use App\Controllers\UserController as FrontendUserController;
use App\Controllers\AuthController;
$routes = [
    '/quan-tri-vien' => [DashboardController::class, 'index'],
    '/nhom-vai-tro' => [UserCatalogueController::class, 'index'],
    '/vai-tro-da-xoa' => [UserCatalogueController::class, 'deleted'],
    '/tao-vai-tro' => [UserCatalogueController::class, 'store'],
    '/xu-ly-tao-vai-tro' => [UserCatalogueController::class, 'handleStore'],
    '/xoa-vai-tro/{id}' => [UserCatalogueController::class, 'softdelete'],
    '/sua-vai-tro/{id}' => [UserCatalogueController::class, 'update'],
    '/xoa-vai-tro-vinh-vien/{id}' => [UserCatalogueController::class, 'delete'],
    '/hoan-tac-vai-tro/{id}' => [UserCatalogueController::class, 'restore'],

    '/thanh-vien' => [BackendUserController::class, 'index'],
    '/thanh-vien-da-xoa' => [BackendUserController::class, 'deleted'],
    '/tao-thanh-vien' => [BackendUserController::class, 'store'],
    '/xu-ly-tao-thanh-vien' => [BackendUserController::class, 'store'],
    '/xoa-thanh-vien/{id}' => [BackendUserController::class, 'softdelete'],
    '/sua-thanh-vien/{id}' => [BackendUserController::class, 'update'],
    '/xoa-thanh-vien-vinh-vien/{id}' => [BackendUserController::class, 'delete'],
    '/hoan-tac-thanh-vien/{id}' => [BackendUserController::class, 'restore'],


    '/change-status' => [ChangeStatusController::class, 'changeStatus'],
    '/change-statusAll' => [ChangeStatusController::class, 'changeStatusAll'],


    '/' => [HomeController::class, 'index'],
    '/trang-chu' => [HomeController::class, 'index'],
    '/dang-nhap' => [AuthController::class, 'login'],
    '/xu-ly-dang-nhap' => [AuthController::class, 'login'],
    '/dang-ky' => [AuthController::class, 'register'],
];

return $routes;