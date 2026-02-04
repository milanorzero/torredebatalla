

<?php $__env->startSection('title', 'Torre de Batalla'); ?>


<?php $__env->startSection('slider'); ?>
    <?php if (isset($component)) { $__componentOriginalf71f4884217590de52aad6e1a371d13e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf71f4884217590de52aad6e1a371d13e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dynamic-slider','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-slider'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf71f4884217590de52aad6e1a371d13e)): ?>
<?php $attributes = $__attributesOriginalf71f4884217590de52aad6e1a371d13e; ?>
<?php unset($__attributesOriginalf71f4884217590de52aad6e1a371d13e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf71f4884217590de52aad6e1a371d13e)): ?>
<?php $component = $__componentOriginalf71f4884217590de52aad6e1a371d13e; ?>
<?php unset($__componentOriginalf71f4884217590de52aad6e1a371d13e); ?>
<?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('shop'); ?>
<div class="container">
    <?php if(($categories ?? collect())->count()): ?>
        <div class="heading_container heading_center mb-3">
            <h2>Categorías</h2>
            <p>Encuentra rápido lo que buscas</p>
        </div>

        <div class="row mb-5">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-6 col-md-3 mb-3">
                    <a href="<?php echo e(route('view_allproducts', ['category' => $cat->category])); ?>" class="text-decoration-none">
                        <div class="p-3 border rounded h-100 d-flex align-items-center justify-content-between">
                            <span class="font-weight-bold text-dark"><?php echo e($cat->category); ?></span>
                            <i class="fa fa-angle-right text-muted"></i>
                        </div>
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

    <div class="heading_container heading_center">
        <h2>Últimos productos</h2>
        <p>Novedades y reposiciones recientes</p>
    </div>

    <div class="row">
        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $isNew = $product->created_at && $product->created_at->greaterThanOrEqualTo(now()->subDays(14));
            ?>
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="box shadow-sm rounded p-2 h-100">
                    <a href="<?php echo e(route('product_details', ['id' => $product->id])); ?>">
                        <div class="img-box text-center">
                            <img src="<?php echo e($product->product_image ? asset('products/' . $product->product_image) : asset('front_end/images/logo.png')); ?>"
                                 alt="<?php echo e($product->product_title); ?>"
                                 class="img-fluid"
                                 style="max-height: 200px; object-fit: contain;">
                        </div>

                        <div class="detail-box mt-3 text-center">
                            <h6 class="mb-1"><?php echo e($product->product_title); ?></h6>

                            <?php if($product->is_on_offer && $product->offer_price): ?>
                                <div>
                                    <span class="text-muted" style="text-decoration: line-through;">
                                        $<?php echo e(number_format((int) $product->product_price, 0, ',', '.')); ?>

                                    </span>
                                    <span class="text-success font-weight-bold" style="margin-left: 6px;">
                                        $<?php echo e(number_format((int) $product->final_price, 0, ',', '.')); ?>

                                    </span>
                                </div>
                                <div class="mt-2">
                                    <span class="badge badge-warning">Oferta</span>
                                </div>
                            <?php else: ?>
                                <div class="text-success font-weight-bold">
                                    $<?php echo e(number_format((int) $product->final_price, 0, ',', '.')); ?>

                                </div>
                            <?php endif; ?>

                            <?php if(!is_null($product->product_quantity)): ?>
                                <div class="mt-2">
                                    <?php if((int) $product->product_quantity > 0): ?>
                                        <small class="text-muted">Stock: <?php echo e($product->product_quantity); ?></small>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Sin stock</span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if($isNew): ?>
                            <div class="new"><span>Nuevo</span></div>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p>No hay productos disponibles por el momento.</p>
        <?php endif; ?>
    </div>

    <div class="btn-box text-center mt-4">
        <a href="<?php echo e(route('view_allproducts')); ?>" class="btn btn-primary">Ver todos los productos</a>
    </div>

    <?php if(($offers ?? collect())->count()): ?>
        <div class="heading_container heading_center mt-5">
            <h2>Ofertas</h2>
            <p>Aprovecha descuentos por tiempo limitado</p>
        </div>

        <div class="row">
            <?php $__currentLoopData = $offers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="box shadow-sm rounded p-2 h-100">
                        <a href="<?php echo e(route('product_details', ['id' => $product->id])); ?>">
                            <div class="img-box text-center">
                                <img src="<?php echo e($product->product_image ? asset('products/' . $product->product_image) : asset('front_end/images/logo.png')); ?>"
                                     alt="<?php echo e($product->product_title); ?>"
                                     class="img-fluid"
                                     style="max-height: 200px; object-fit: contain;">
                            </div>
                            <div class="detail-box mt-3 text-center">
                                <h6 class="mb-1"><?php echo e($product->product_title); ?></h6>
                                <div>
                                    <span class="text-muted" style="text-decoration: line-through;">
                                        $<?php echo e(number_format((int) $product->product_price, 0, ',', '.')); ?>

                                    </span>
                                    <span class="text-success font-weight-bold" style="margin-left: 6px;">
                                        $<?php echo e(number_format((int) $product->final_price, 0, ',', '.')); ?>

                                    </span>
                                </div>
                                <div class="mt-2">
                                    <span class="badge badge-warning">Oferta</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

    <div class="row text-center mt-5">
        <div class="col-6 col-md-3 mb-3">
            <div class="p-3 border rounded h-100">
                <i class="fa fa-truck fa-2x mb-2"></i>
                <div class="font-weight-bold">Envíos</div>
                <small class="text-muted">A todo Chile</small>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="p-3 border rounded h-100">
                <i class="fa fa-map-marker fa-2x mb-2"></i>
                <div class="font-weight-bold">Retiro</div>
                <small class="text-muted">Concepción</small>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="p-3 border rounded h-100">
                <i class="fa fa-lock fa-2x mb-2"></i>
                <div class="font-weight-bold">Pago seguro</div>
                <small class="text-muted">Múltiples medios</small>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="p-3 border rounded h-100">
                <i class="fa fa-comments fa-2x mb-2"></i>
                <div class="font-weight-bold">Soporte</div>
                <small class="text-muted">Te ayudamos</small>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('maindesign', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/index.blade.php ENDPATH**/ ?>