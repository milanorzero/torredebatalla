<?php
    use App\Models\SliderItem;
    $slides = SliderItem::where('active', true)->orderBy('order')->get();
?>
<div id="mainSliderCarousel" class="carousel slide slider_container" data-ride="carousel" style="position: relative;">
    <div class="carousel-inner">
        <?php $__empty_1 = true; $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="carousel-item<?php echo e($i === 0 ? ' active' : ''); ?>">
                <img src="<?php echo e(asset('front_end/images/' . $slide->image)); ?>" alt="Slider" class="img-fluid w-100" style="max-width:1200px; max-height:400px; object-fit:cover; border-radius:18px;">
                <?php if($slide->text): ?>
                <div style="
                    position: absolute;
                    right: 40px;
                    top: 50%;
                    transform: translateY(-50%);
                    background: #00bfffcc;
                    color: #fff;
                    font-size: 2.2rem;
                    font-weight: bold;
                    padding: 12px 32px;
                    border-radius: 12px;
                    box-shadow: 0 2px 12px rgba(0,0,0,0.12);
                    letter-spacing: 2px;
                    z-index: 2;
                    text-shadow: 0 2px 8px rgba(0,0,0,0.18);
                    max-width: 90vw;
                    opacity: 0.97;
                    text-align: center;
                ">
                    <?php echo e($slide->text); ?>

                </div>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="carousel-item active">
                <img src="<?php echo e(asset('front_end/images/slider-bg.jpg')); ?>" alt="Slider" class="img-fluid w-100" style="max-width:1200px; max-height:400px; object-fit:cover; border-radius:18px;">
            </div>
        <?php endif; ?>
    </div>
    <?php if($slides->count() > 1): ?>
        <a class="carousel-control-prev" href="#mainSliderCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Anterior</span>
        </a>
        <a class="carousel-control-next" href="#mainSliderCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Siguiente</span>
        </a>
    <?php endif; ?>
</div>
<?php /**PATH /var/www/html/resources/views/components/dynamic-slider.blade.php ENDPATH**/ ?>