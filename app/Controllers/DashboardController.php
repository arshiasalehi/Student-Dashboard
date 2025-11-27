<?php
declare(strict_types=1);

class DashboardController
{
    public function show(): void
    {
        require_login();
        $student = $_SESSION['student'];

        $allowedTextSizes = ['12px', '14px', '16px', '18px'];
        $allowedSchemes = ['blue', 'green', 'purple', 'red'];
        $allowedNotifications = ['Email', 'SMS', 'Both', 'None'];

        // Simple session-based page view counter for dashboard visits.
        $views = (int)($_SESSION['dashboard_views'] ?? 0) + 1;
        $_SESSION['dashboard_views'] = $views;

        $preferences = [
            'text_size' => $this->validOrDefault($_COOKIE['student_text_size'] ?? null, $allowedTextSizes, '16px'),
            'color_scheme' => $this->validOrDefault($_COOKIE['student_color_scheme'] ?? null, $allowedSchemes, 'blue'),
            'notifications' => $this->validOrDefault($_COOKIE['student_notifications'] ?? null, $allowedNotifications, 'Email'),
        ];

        $errors = [];
        $message = '';

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
                $errors[] = 'Invalid request. Please try again.';
            } else {
                $textSize = $_POST['text_size'] ?? '';
                $colorScheme = $_POST['color_scheme'] ?? '';
                $notifications = $_POST['notifications'] ?? '';

                $textSize = $this->validOrDefault($textSize, $allowedTextSizes, $preferences['text_size']);
                $colorScheme = $this->validOrDefault($colorScheme, $allowedSchemes, $preferences['color_scheme']);
                $notifications = $this->validOrDefault($notifications, $allowedNotifications, $preferences['notifications']);

                $preferences = [
                    'text_size' => $textSize,
                    'color_scheme' => $colorScheme,
                    'notifications' => $notifications,
                ];

                $this->writePreferenceCookies($preferences);
                $message = 'Preferences updated.';
            }
        }

        $palette = $this->palette($preferences['color_scheme']);

        render('dashboard', [
            'student' => $student,
            'preferences' => $preferences,
            'palette' => $palette,
            'errors' => $errors,
            'message' => $message,
            'views' => $views,
        ]);
    }

    private function validOrDefault(?string $value, array $allowed, string $default): string
    {
        return in_array($value, $allowed, true) ? $value : $default;
    }

    private function writePreferenceCookies(array $preferences): void
    {
        $expires = time() + (90 * 24 * 60 * 60);
        $cookieParams = [
            'expires' => $expires,
            'path' => '/',
            'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
            'httponly' => true,
            'samesite' => 'Lax',
        ];

        setcookie('student_text_size', $preferences['text_size'], $cookieParams);
        setcookie('student_color_scheme', $preferences['color_scheme'], $cookieParams);
        setcookie('student_notifications', $preferences['notifications'], $cookieParams);
    }

    private function palette(string $scheme): array
    {
        $palettes = [
            'blue' => ['bg' => '#0f172a', 'panel' => '#1f2937', 'accent' => '#3b82f6'],
            'green' => ['bg' => '#0d1f17', 'panel' => '#12281e', 'accent' => '#22c55e'],
            'purple' => ['bg' => '#1b1027', 'panel' => '#241135', 'accent' => '#a855f7'],
            'red' => ['bg' => '#2a0f14', 'panel' => '#351018', 'accent' => '#ef4444'],
        ];
        return $palettes[$scheme] ?? $palettes['blue'];
    }
}
