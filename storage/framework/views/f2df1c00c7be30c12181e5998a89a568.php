
<?php $__env->startSection('page_title', 'Slider'); ?>
<?php $__env->startSection('content'); ?>
<div class="container">
    <h2 class="mb-4">Slides del Slider</h2>
    <a href="<?php echo e(route('admin.slider.create')); ?>" class="btn btn-primary mb-3">Agregar Slide</a>
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="mb-4">
        <h5>Slides Activos</h5>
        <div class="d-flex flex-wrap gap-3">
            <?php $__currentLoopData = $items->where('active', true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="border rounded p-2 text-center" style="min-width:180px;max-width:220px;">
                    <img src="<?php echo e(asset('front_end/images/' . $item->image)); ?>" style="max-width:100%;max-height:80px;object-fit:cover;border-radius:6px;">
                    <div class="mt-2 small text-muted"><?php echo e($item->text); ?></div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if($items->where('active', true)->count() == 0): ?>
                <span class="text-muted">No hay slides activos.</span>
            <?php endif; ?>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Texto</th>
                <th>Orden</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><img src="<?php echo e(asset('front_end/images/' . $item->image)); ?>" style="max-width:120px;"></td>
                    <td><?php echo e($item->text); ?></td>
                    <td><?php echo e($item->order); ?></td>
                    <td><?php echo e($item->active ? 'Sí' : 'No'); ?></td>
                    <td>
                        <a href="<?php echo e(route('admin.slider.edit', $item)); ?>" class="btn btn-sm btn-warning">Editar</a>
                        <form action="<?php echo e(route('admin.slider.destroy', $item)); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar slide?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.maindesign', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/slider/index.blade.php ENDPATH**/ ?>