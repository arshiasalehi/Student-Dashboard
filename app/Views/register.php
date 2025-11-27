<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f6fa; margin: 0; padding: 0; }
        .container { max-width: 420px; margin: 60px auto; background: #fff; padding: 24px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        h1 { margin-top: 0; }
        label { display: block; margin: 12px 0 4px; font-weight: 600; }
        input[type="text"], input[type="email"], input[type="password"] { width: 100%; padding: 10px; border: 1px solid #dcdfe6; border-radius: 8px; }
        .error { color: #b00020; margin: 8px 0; }
        .button { margin-top: 16px; width: 100%; padding: 12px; background: #2563eb; color: #fff; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; }
        .nav { margin-top: 12px; text-align: center; }
        a { color: #2563eb; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Create Account</h1>
        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <div><?php echo e($error); ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form method="post" action="index.php?route=register" novalidate>
            <input type="hidden" name="csrf_token" value="<?php echo e(csrf_token()); ?>">
            <label for="full_name">Full Name</label>
            <input type="text" name="full_name" id="full_name" minlength="5" required value="<?php echo e($old['fullName'] ?? ''); ?>">

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required value="<?php echo e($old['email'] ?? ''); ?>">

            <label for="student_id">Student ID (7 digits)</label>
            <input type="text" name="student_id" id="student_id" pattern="\\d{7}" required value="<?php echo e($old['studentId'] ?? ''); ?>">

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <label for="password_confirm">Confirm Password</label>
            <input type="password" name="password_confirm" id="password_confirm" required>

            <button class="button" type="submit">Register</button>
        </form>
        <div class="nav">
            <span>Already have an account? <a href="index.php?route=login">Login</a></span>
        </div>
    </div>
</body>
</html>
