<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f6fa; margin: 0; padding: 0; }
        .container { max-width: 420px; margin: 60px auto; background: #fff; padding: 24px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        h1 { margin-top: 0; }
        label { display: block; margin: 12px 0 4px; font-weight: 600; }
        input[type="email"], input[type="password"] { width: 100%; padding: 10px; border: 1px solid #dcdfe6; border-radius: 8px; }
        .error { color: #b00020; margin: 8px 0; }
        .button { margin-top: 16px; width: 100%; padding: 12px; background: #2563eb; color: #fff; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; }
        .nav { margin-top: 12px; text-align: center; }
        a { color: #2563eb; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome Back</h1>
        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <div><?php echo e($error); ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form method="post" action="index.php?route=login" novalidate>
            <input type="hidden" name="csrf_token" value="<?php echo e(csrf_token()); ?>">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required value="<?php echo e($email ?? ''); ?>">

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <button class="button" type="submit">Login</button>
        </form>
        <div class="nav">
            <span>Need an account? <a href="index.php?route=register">Register</a></span>
        </div>
    </div>
</body>
</html>
