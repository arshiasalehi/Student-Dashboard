<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/app/Controllers/AuthController.php';
require_once __DIR__ . '/app/Controllers/DashboardController.php';

$route = $_GET['route'] ?? 'login';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$auth = new AuthController();
$dashboard = new DashboardController();

switch ($route) {
    case 'login':
        if ($method === 'POST') {
            $auth->login($pdo);
        } else {
            $auth->showLogin();
        }
        break;
    case 'register':
        if ($method === 'POST') {
            $auth->register($pdo);
        } else {
            $auth->showRegister();
        }
        break;
    case 'dashboard':
        $dashboard->show();
        break;
    case 'logout':
        $auth->logout();
        break;
    default:
        http_response_code(404);
        echo 'Not found';
}
