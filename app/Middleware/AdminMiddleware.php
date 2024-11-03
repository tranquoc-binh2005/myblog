<?php

namespace App\Middleware;

class AdminMiddleware
{
    public static function handle()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }

        $user = $_SESSION['user'];
        if ($user['role'] !== 'admin') {
            // Chuyển hướng nếu người dùng không có quyền admin
            header("Location: /unauthorized");
            exit;
        }
    }
}
