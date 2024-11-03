<?php

return [
    'module' => [
        [
            'title' => 'Cấu hình chung',
            'icon' => 'fa fa-cog',
            'subModule' => [
                [
                    'title' => 'Ngôn ngữ',
                    'route' => 'ngon-ngu',
                ],

            ],
        ],
        [
            'title' => 'Quản lý thành viên',
            'icon' => 'fa fa-user',
            'subModule' => [
                [
                    'title' => 'Nhóm vai trò',
                    'route' => 'nhom-vai-tro',
                ],
                [
                    'title' => 'Thành viên',
                    'route' => 'thanh-vien',
                ],
            ],
        ],
        [
            'title' => 'Quản lý bài viết',
            'icon' => 'fe-folder',
            'subModule' => [
                [
                    'title' => 'Nhóm bài viết',
                    'route' => 'nhom-bai-viet',
                ],
                [
                    'title' => 'Bài viết',
                    'route' => 'bai-viet',
                ],
            ],
        ],
    ],
];
