<?php
require_once __DIR__ . '/homeController.php';
require_once __DIR__ . '/aboutController.php';
require_once __DIR__ . '/authController.php';
require_once __DIR__ . '/dashboardController.php';
require_once __DIR__ . '/majorController.php';
require_once __DIR__ . '/applicationController.php';
require_once __DIR__ . '/adminController.php';
$routes = [
    '/' => [
        'GET' => 'home_page'
    ],
    '/about' => [
        'GET' => 'about_page'
    ],
    '/register' => [
        'GET' => 'show_register_form',
        'POST' => 'handle_register'
    ],
    '/login' => [
        'GET' => 'show_login_form',
        'POST' => 'handle_login'
    ],
    '/dashboard' => [
        'GET' => 'show_dashboard'
    ],
    '/logout' => [
        'GET' => 'handle_logout'
    ],
    '/applications/create' => [
        'GET' => 'applications_create_form',
        'POST' => 'applications_store'
    ],
    '/application/create' => [
        'GET' => 'applications_create_form',
        'POST' => 'applications_store'
    ],
    '/application/show' => [
        'GET' => 'applications_show'
    ],
    '/my-application' => [
        'GET' => 'handle_my_application'
    ],
    '/majors-info' => [
        'GET' => 'majors_info'
    ],
    '/admission-results' => [
        'GET' => 'admission_results'
    ],
    '/profile' => [
        'GET' => 'show_profile',
        'POST' => 'update_profile'
    ],
    '/change-password' => [
        'GET' => 'show_change_password',
        'POST' => 'handle_change_password'
    ],
    '/admin/applications' => [
        'GET' => 'admin_applications_index'
    ],
    '/admin/applications/show' => [
        'GET' => 'admin_applications_show'
    ],
    '/admin/applications/update-status' => [
        'POST' => 'admin_applications_update_status'
    ],
    '/majors' => [
        'GET' => 'majors_index'
    ],
    '/majors/create' => [
        'GET' => 'majors_create_form',
        'POST' => 'majors_store'
    ],
    '/majors/edit' => [
        'GET' => 'majors_edit_form'
    ],
    '/majors/update' => [
        'POST' => 'majors_update'
    ],
    '/majors/delete' => [
        'GET' => 'majors_delete'
    ]
];
return $routes; 