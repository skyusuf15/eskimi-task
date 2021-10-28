<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.full-page-section'); ?>
        <?php $__env->startComponent('components.card'); ?>
            <?php $__env->slot('title'); ?>
                <span class="icon"><i class="mdi mdi-laravel"></i></span>
                <span>ESKIMI SSP</span>
            <?php $__env->endSlot(); ?>

            <div class="content">
                <p>
                    Hi, this is Yusuf Sanusi's task.
                    Please, <a href="<?php echo e(route('login')); ?>">login</a> or <a href="<?php echo e(route('register')); ?>">register</a>&hellip;
                </p>
                <p>
                    &mdash; <b>Login:</b> user@example.com<br>
                    &mdash; <b>Password:</b> secret
                </p>
            </div>
            <hr>
            <div class="buttons">
                <a href="<?php echo e(route('login')); ?>" class="button is-black">Login</a>
                <a href="<?php echo e(route('register')); ?>" class="button is-black is-outlined">Register</a>
            </div>
        <?php if (isset($__componentOriginal5f59c4a1ca74a252b2d681d997164c3d2337c453)): ?>
<?php $component = $__componentOriginal5f59c4a1ca74a252b2d681d997164c3d2337c453; ?>
<?php unset($__componentOriginal5f59c4a1ca74a252b2d681d997164c3d2337c453); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
    <?php if (isset($__componentOriginal82b0edd9b6e9c8dd61bb7e56ccaa0e0241679e60)): ?>
<?php $component = $__componentOriginal82b0edd9b6e9c8dd61bb7e56ccaa0e0241679e60; ?>
<?php unset($__componentOriginal82b0edd9b6e9c8dd61bb7e56ccaa0e0241679e60); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/welcome.blade.php ENDPATH**/ ?>