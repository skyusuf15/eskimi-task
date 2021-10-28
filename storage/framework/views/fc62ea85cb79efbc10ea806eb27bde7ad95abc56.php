<?php $__env->startPush('html-class'); ?> has-spinner-active has-aside-left has-aside-mobile-transition has-navbar-fixed-top has-aside-expanded <?php $__env->stopPush(); ?>

<?php $__env->startPush('head-scripts'); ?>
    <script src="<?php echo e(mix('js/app.js')); ?>" defer></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('bottom'); ?>
    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
        <?php echo csrf_field(); ?>
    </form>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/home.blade.php ENDPATH**/ ?>