<?php $__env->startSection('title', 'Iniciar sesión'); ?>

<?php $__env->startSection('shop'); ?>
<div class="container" style="max-width: 520px;">
    <div class="card shadow-sm w-100">
        <div class="card-body p-4">

            <h2 class="text-center mb-3">
                Iniciar sesión
            </h2>

            
            <?php if(session('status')): ?>
                <div class="alert alert-success text-center">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login', [], false)); ?>">
                <?php echo csrf_field(); ?>

                
                <div class="form-group mb-3">
                    <label>Correo electrónico</label>
                    <input
                        type="email"
                        name="email"
                        value="<?php echo e(old('email')); ?>"
                        class="form-control"
                        placeholder="correo@ejemplo.com"
                        required
                        autofocus
                    >
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <small class="text-danger"><?php echo e($message); ?></small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div class="form-group mb-3">
                    <label>Contraseña</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        required
                    >
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <small class="text-danger"><?php echo e($message); ?></small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div class="form-check mb-3">
                    <input
                        type="checkbox"
                        name="remember"
                        class="form-check-input"
                        id="remember"
                    >
                    <label class="form-check-label" for="remember">
                        Recordarme
                    </label>
                </div>

                
                <button class="btn btn-primary w-100">
                    Iniciar sesión
                </button>

                
                <div class="text-center mt-3">
                    <?php if(Route::has('password.request')): ?>
                        <a href="<?php echo e(route('password.request')); ?>">
                            ¿Olvidaste tu contraseña?
                        </a>
                    <?php endif; ?>
                </div>

                <div class="text-center mt-2">
                    <a href="<?php echo e(route('register')); ?>">
                        Crear cuenta
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('maindesign', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/auth/login.blade.php ENDPATH**/ ?>