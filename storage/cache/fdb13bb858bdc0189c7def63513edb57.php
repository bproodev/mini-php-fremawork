

<?php $__env->startSection("title", "Upload des fichiers"); ?>

<?php $__env->startSection("content"); ?>
    <h1>Upload Profile Picture</h1>
    <?php if(!empty($errors)): ?>
        <ul style="color:red;">
            <?php $__currentLoopData = $errors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fieldErrors): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $fieldErrors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li> <br>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php endif; ?>
    <?php if($fileName): ?>
        <p>Fichier telecharge avec succes!</p>
        <img src="<?php echo e(BASE_PATH . '/uploads/' . $fileName); ?>" alt="Profile Picture" width="150">
    <?php else: ?>
        <form method="POST" id="uploadForm" enctype="multipart/form-data">
            <label for="fileInput">Choisissez un fichier</label>
            <input type="file" name="avatar" id="fileInput" required>
            <br>
            <progress id="progressBar" value="0" max="100"></progress>
            <p id="status"></p>
            <br>
            <button type="submit">Upload</button>
        </form>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>
    <script src="<?php echo e(asset('assets/js/upload.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\mini-php-framework\app\Views/upload.blade.php ENDPATH**/ ?>