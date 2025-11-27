<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
        :root {
            --bg: <?php echo e($palette['bg']); ?>;
            --panel: <?php echo e($palette['panel']); ?>;
            --accent: <?php echo e($palette['accent']); ?>;
            --text: #f1f5f9;
        }
        body {
            font-family: Arial, sans-serif;
            background: var(--bg);
            margin: 0;
            padding: 0;
            color: var(--text);
            font-size: <?php echo e($preferences['text_size']); ?>;
        }
        .container { max-width: 900px; margin: 40px auto; background: var(--panel); padding: 24px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.3); }
        h1 { margin-top: 0; }
        .row { margin: 12px 0; }
        .label { font-weight: 600; display: inline-block; width: 180px; }
        .logout { display: inline-block; margin-top: 16px; color: #fecdd3; text-decoration: none; font-weight: 600; }
        .form-card { margin-top: 24px; padding: 16px; border-radius: 10px; background: rgba(255,255,255,0.04); }
        label { display: block; margin: 12px 0 4px; font-weight: 600; }
        select, input[type="radio"] { margin-right: 8px; }
        select { width: 220px; padding: 8px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.12); background: rgba(0,0,0,0.25); color: #fff; }
        .radio-group { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
        .button { margin-top: 16px; padding: 10px 14px; background: var(--accent); color: #0b1220; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; }
        .message { color: #bbf7d0; margin-top: 8px; }
        .errors { color: #fecdd3; margin-top: 8px; }
        .summary { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 12px; margin-top: 18px; }
        .summary-card { background: rgba(255,255,255,0.05); padding: 12px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.08); }
        .summary-title { font-weight: 700; }
        .icon-dot { display: inline-block; width: 12px; height: 12px; border-radius: 50%; margin-right: 8px; vertical-align: middle; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome back, <?php echo e($student['full_name']); ?>! Student ID: <?php echo e($student['student_id']); ?></h1>
        <div class="row"><span class="label">Email:</span> <?php echo e($student['email']); ?></div>
        <div class="row"><span class="label">Registration:</span> <?php echo e($student['registration_date'] ?? 'Stored in database'); ?></div>
        <div class="row"><span class="label">Dashboard views this session:</span> <?php echo e($views); ?></div>

        <div class="form-card">
            <h3>Customize Dashboard</h3>
            <?php if (!empty($message)): ?>
                <div class="message"><?php echo e($message); ?></div>
            <?php endif; ?>
            <?php if (!empty($errors)): ?>
                <div class="errors">
                    <?php foreach ($errors as $error): ?>
                        <div><?php echo e($error); ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <form method="post" action="index.php?route=dashboard">
                <input type="hidden" name="csrf_token" value="<?php echo e(csrf_token()); ?>">

                <label for="text_size">Text Size</label>
                <select name="text_size" id="text_size">
                    <?php foreach (['12px','14px','16px','18px'] as $size): ?>
                        <option value="<?php echo e($size); ?>" <?php echo $preferences['text_size'] === $size ? 'selected' : ''; ?>>
                            <?php echo e($size); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label>Color Scheme</label>
                <div class="radio-group">
                    <?php foreach (['blue'=>'Blue','green'=>'Green','purple'=>'Purple','red'=>'Red'] as $value => $label): ?>
                        <label>
                            <input type="radio" name="color_scheme" value="<?php echo e($value); ?>" <?php echo $preferences['color_scheme'] === $value ? 'checked' : ''; ?>>
                            <?php echo e($label); ?>
                        </label>
                    <?php endforeach; ?>
                </div>

                <label for="notifications">Notifications</label>
                <select name="notifications" id="notifications">
                    <?php foreach (['Email','SMS','Both','None'] as $notif): ?>
                        <option value="<?php echo e($notif); ?>" <?php echo $preferences['notifications'] === $notif ? 'selected' : ''; ?>>
                            <?php echo e($notif); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button class="button" type="submit">Save Preferences</button>
            </form>
        </div>

        <div class="summary">
            <div class="summary-card">
                <div class="summary-title"><span class="icon-dot" style="background: var(--accent);"></span>Text Size</div>
                <div><?php echo e($preferences['text_size']); ?></div>
            </div>
            <div class="summary-card">
                <div class="summary-title"><span class="icon-dot" style="background: var(--accent);"></span>Color Scheme</div>
                <div><?php echo e(ucfirst($preferences['color_scheme'])); ?></div>
            </div>
            <div class="summary-card">
                <div class="summary-title"><span class="icon-dot" style="background: var(--accent);"></span>Notifications</div>
                <div><?php echo e($preferences['notifications']); ?></div>
            </div>
        </div>
        <a class="logout" href="index.php?route=logout">Log out</a>
    </div>
</body>
</html>
