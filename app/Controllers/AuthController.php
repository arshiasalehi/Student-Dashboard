<?php
declare(strict_types=1);

require_once __DIR__ . '/../Models/Student.php';

class AuthController
{
    public function showLogin(array $errors = [], string $email = ''): void
    {
        render('login', ['errors' => $errors, 'email' => $email]);
    }

    public function login(PDO $pdo): void
    {
        $errors = [];
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
            $errors[] = 'Invalid request. Please try again.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address.';
        }

        if (!$errors) {
            $student = Student::findByEmail($pdo, $email);
            if (!$student || !password_verify($password, $student['password'])) {
            $errors[] = 'Incorrect email or password.';
        } else {
            session_regenerate_id(true);
            $_SESSION['student'] = [
                'id' => (int)$student['id'],
                'full_name' => $student['full_name'],
                'email' => $student['email'],
                'student_id' => $student['student_id'],
                'registration_date' => $student['registration_date'],
            ];
            $_SESSION['last_activity'] = time();
            header('Location: index.php?route=dashboard');
            exit;
        }
        }

        $this->showLogin($errors, $email);
    }

    public function showRegister(array $errors = [], array $old = []): void
    {
        render('register', ['errors' => $errors, 'old' => $old]);
    }

    public function register(PDO $pdo): void
    {
        $errors = [];
        $fullName = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $studentId = trim($_POST['student_id'] ?? '');
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';

        if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
            $errors[] = 'Invalid request. Please try again.';
        }

        if (strlen($fullName) < 5) {
            $errors[] = 'Full name must be at least 5 characters.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address.';
        }
        if (!preg_match('/^\\d{7}$/', $studentId)) {
            $errors[] = 'Student ID must be exactly 7 digits.';
        }
        if (!preg_match('/^(?=.*[A-Z])(?=.*\\d).{8,}$/', $password)) {
            $errors[] = 'Password must be 8+ characters, include 1 uppercase letter and 1 digit.';
        }
        if ($password !== $passwordConfirm) {
            $errors[] = 'Password confirmation does not match.';
        }

        if (!$errors && Student::existsByEmailOrStudentId($pdo, $email, $studentId)) {
            $errors[] = 'Email or Student ID already registered.';
        }

        if ($errors) {
            $this->showRegister($errors, compact('fullName', 'email', 'studentId'));
            return;
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        Student::create($pdo, $fullName, $email, $hashed, $studentId);
        $student = Student::findByEmail($pdo, $email);
        session_regenerate_id(true);
        $_SESSION['student'] = [
            'id' => (int)$student['id'],
            'full_name' => $student['full_name'],
            'email' => $student['email'],
            'student_id' => $student['student_id'],
            'registration_date' => $student['registration_date'],
        ];
        $_SESSION['last_activity'] = time();
        header('Location: index.php?route=dashboard');
        exit;
    }

    public function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
        header('Location: index.php?route=login');
        exit;
    }
}
