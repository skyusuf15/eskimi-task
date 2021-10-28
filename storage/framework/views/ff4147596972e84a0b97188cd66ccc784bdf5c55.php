<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="<?php echo $__env->yieldPushContent('html-class'); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Eskimi SSP')); ?></title>

    
    <?php echo $__env->yieldPushContent('head-scripts'); ?>

    
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    
    <link href="<?php echo e(mix($stylesheet ?? 'css/app.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(mix('css/vendor.css')); ?>" rel="stylesheet">

    <?php echo $__env->yieldPushContent('head-after'); ?>
</head>
<body>

<div id="app">

    <?php echo $__env->yieldContent('content'); ?>

</div>

<?php echo $__env->yieldPushContent('bottom'); ?>

</body>
</html>
<?php /**PATH /var/www/html/resources/views/layouts/app.blade.php ENDPATH**/ ?>