<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

// Enforce idle timeout (30 minutes).
if (isset($_SESSION['last_activity']) && (time() - (int)$_SESSION['last_activity'] > 1800)) {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
}
$_SESSION['last_activity'] = time();

require_once __DIR__ . '/db.php';

function render(string $view, array $data = []): void
{
    $viewFile = __DIR__ . '/app/Views/' . $view . '.php';
    if (!file_exists($viewFile)) {
        http_response_code(404);
        echo 'View not found';
        exit;
    }
    extract($data, EXTR_SKIP);
    require $viewFile;
}

function is_logged_in(): bool
{
    return isset($_SESSION['student']);
}

function require_login(): void
{
    if (!is_logged_in()) {
        header('Location: index.php?route=login');
        exit;
    }
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token(?string $token): bool
{
    return is_string($token) && hash_equals($_SESSION['csrf_token'] ?? '', $token);
}
