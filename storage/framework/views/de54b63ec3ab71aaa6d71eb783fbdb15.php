

<?php $__env->startSection('page_title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    <div class="row">
        <div class="col-12 col-sm-6 col-md-3 mb-4">
            <div class="statistic-block block h-100">
                <strong>Nuevos jugadores (7 días)</strong>
                <h3><?php echo e($playersNew7d); ?></h3>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-4">
            <div class="statistic-block block h-100">
                <strong>Jugadores totales</strong>
                <h3><?php echo e($playersTotal); ?></h3>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-4">
            <div class="statistic-block block h-100">
                <strong>Órdenes pendientes</strong>
                <h3><?php echo e($ordersPending); ?></h3>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-4">
            <div class="statistic-block block h-100">
                <strong>Ventas hoy (pagadas)</strong>
                <h3>$<?php echo e(number_format($revenueToday, 0, ',', '.')); ?></h3>
                <small class="text-muted"><?php echo e($ordersPaidToday); ?> órdenes</small>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-3">
            <div class="statistic-block block">
                <strong>Ventas 30 días</strong>
                <h3>$<?php echo e(number_format($revenue30d, 0, ',', '.')); ?></h3>
                <small class="text-muted"><?php echo e($ordersPaid30d); ?> órdenes pagadas</small>
            </div>
        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.maindesign', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>