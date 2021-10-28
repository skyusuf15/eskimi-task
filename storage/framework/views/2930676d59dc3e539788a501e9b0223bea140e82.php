<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.full-page-section'); ?>



        <?php $__env->startComponent('components.card'); ?>
            <?php $__env->slot('title'); ?>
                <span class="icon"><i class="mdi mdi-lock"></i></span>
                <span><?php echo e(__('Login')); ?></span>
            <?php $__env->endSlot(); ?>

            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>

                <div class="field">
                    <label class="label" for="email"><?php echo e(__('E-Mail Address')); ?></label>
                    <div class="control">
                        <input id="email" type="email" class="input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus>
                    </div>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="help is-danger" role="alert">
                            <?php echo e($message); ?>

                        </p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="field">
                    <label class="label" for="password"><?php echo e(__('Password')); ?></label>
                    <div class="control">
                        <input id="password" type="password" class="input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="current-password" autofocus>
                    </div>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="help is-danger" role="alert">
                            <?php echo e($message); ?>

                        </p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="control">
                    <label tabindex="0" class="b-checkbox checkbox is-thin">
                        <input type="checkbox" value="false" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                        <span class="check is-black"></span>
                        <span class="control-label"><?php echo e(__('Remember Me')); ?></span>
                    </label>
                </div>

                <hr>

                <div class="field is-form-action-buttons">
                    <button type="submit" class="button is-black">
                        <?php echo e(__('Login')); ?>

                    </button>

                    <?php if(Route::has('password.request')): ?>
                        <a class="button is-black is-outlined" href="<?php echo e(route('password.request')); ?>">
                            <?php echo e(__('Forgot Your Password?')); ?>

                        </a>
                    <?php endif; ?>
                </div>
            </form>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/auth/login.blade.php ENDPATH**/ ?>