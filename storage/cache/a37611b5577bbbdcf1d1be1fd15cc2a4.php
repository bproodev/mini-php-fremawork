<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title'); ?></title>
</head>
<body>
    <header>
        <nav>
            <a href="<?php echo e(BASE_PATH); ?>/">Home</a>
            <a href="<?php echo e(BASE_PATH); ?>/about">About</a>
            <a href="<?php echo e(BASE_PATH); ?>/inscription">Inscription</a>
            <a href="<?php echo e(BASE_PATH); ?>/upload">Upload</a>
        </nav>
    </header>
    <br>
    <main>
        <?php echo $__env->yieldContent("content"); ?>
    </main>

    <footer>
        <p>&copy; <?php echo e(date('Y')); ?> My Mini Framework</p>
    </footer>
    <?php echo $__env->yieldContent("scripts"); ?>
</body>
</html><?php /**PATH C:\wamp64\www\mini-php-framework\app\Views/layouts/app.blade.php ENDPATH**/ ?>