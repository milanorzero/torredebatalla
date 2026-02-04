
<?php $__env->startSection('page_title', 'Agregar Slide'); ?>
<?php $__env->startSection('content'); ?>
<div class="container">
    <h2 class="mb-4">Agregar Slide</h2>

    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.slider.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="form-group mb-3">
            <label>Imagen</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label>Texto</label>
            <input type="text" name="text" class="form-control">
        </div>
        <div class="form-group mb-3">
            <label>Orden</label>
            <input type="number" name="order" class="form-control" value="0">
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" name="active" class="form-check-input" checked>
            <label class="form-check-label">Activo</label>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="<?php echo e(route('admin.slider.index')); ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.maindesign', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/slider/create.blade.php ENDPATH**/ ?>