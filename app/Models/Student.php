<?php
declare(strict_types=1);

class Student
{
    public static function findByEmail(PDO $pdo, string $email): ?array
    {
        $stmt = $pdo->prepare('SELECT id, full_name, email, password, student_id, registration_date FROM students WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function existsByEmailOrStudentId(PDO $pdo, string $email, string $studentId): bool
    {
        $stmt = $pdo->prepare('SELECT id FROM students WHERE email = :email OR student_id = :student_id LIMIT 1');
        $stmt->execute(['email' => $email, 'student_id' => $studentId]);
        return (bool)$stmt->fetch();
    }

    public static function create(PDO $pdo, string $fullName, string $email, string $hashedPassword, string $studentId): int
    {
        $stmt = $pdo->prepare('INSERT INTO students (full_name, email, password, student_id) VALUES (:full_name, :email, :password, :student_id)');
        $stmt->execute([
            'full_name' => $fullName,
            'email' => $email,
            'password' => $hashedPassword,
            'student_id' => $studentId,
        ]);
        return (int)$pdo->lastInsertId();
    }
}
