

<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection("content"); ?>
    <h1 class="title">Salut a toi le pro!</h1>

    <ul class="user-list">
        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <p><strong>Nom Complet : </strong><?php echo e($user['prenom']); ?> <?php echo e($user['nom']); ?></p>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

    <a href="<?= BASE_PATH ?>/inscription">Inscrivez vous</a>
    <script src="<?= BASE_PATH ?>/assets/js/script.js"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\mini-php-framework\app\Views/home.blade.php ENDPATH**/ ?>