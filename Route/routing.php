<?php

namespace Route;

use App\Controllers\Backend\DashboardController;
use App\Controllers\Backend\UserCatalogueController;
use App\Controllers\Backend\LanguageController;
use App\Controllers\Backend\PostCatalogueController;
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

    '/ngon-ngu' => [LanguageController::class, 'index'],
    '/ngon-ngu-da-xoa' => [LanguageController::class, 'deleted'],
    '/tao-ngon-ngu' => [LanguageController::class, 'store'],
    '/xu-ly-tao-ngon-ngu' => [LanguageController::class, 'store'],
    '/xoa-ngon-ngu/{id}' => [LanguageController::class, 'softdelete'],
    '/sua-ngon-ngu/{id}' => [LanguageController::class, 'update'],
    '/xoa-ngon-ngu-vinh-vien/{id}' => [LanguageController::class, 'delete'],
    '/hoan-tac-ngon-ngu/{id}' => [LanguageController::class, 'restore'],

    '/nhom-bai-viet' => [PostCatalogueController::class, 'index'],
    '/nhom-bai-viet-da-xoa' => [PostCatalogueController::class, 'deleted'],
    '/tao-nhom-bai-viet' => [PostCatalogueController::class, 'store'],
    '/xu-ly-tao-nhom-bai-viet' => [PostCatalogueController::class, 'store'],
    '/xoa-nhom-bai-viet/{id}' => [PostCatalogueController::class, 'softdelete'],
    '/sua-nhom-bai-viet/{id}' => [PostCatalogueController::class, 'update'],
    '/xoa-nhom-bai-viet-vinh-vien/{id}' => [PostCatalogueController::class, 'delete'],
    '/hoan-tac-nhom-bai-viet/{id}' => [PostCatalogueController::class, 'restore'],


    '/change-status' => [ChangeStatusController::class, 'changeStatus'],
    '/change-statusAll' => [ChangeStatusController::class, 'changeStatusAll'],


    '/' => [HomeController::class, 'index'],
    '/trang-chu' => [HomeController::class, 'index'],
    '/dang-nhap' => [AuthController::class, 'login'],
    '/xu-ly-dang-nhap' => [AuthController::class, 'login'],
    '/dang-xuat' => [AuthController::class, 'logout'],
    '/dang-ky' => [AuthController::class, 'register'],
];

return $routes;