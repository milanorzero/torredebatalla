<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <link rel="shortcut icon" href="<?php echo e(asset('front_end/images/favicon.png')); ?>" type="image/x-icon">

    <title><?php echo $__env->yieldContent('title', 'Torre de Batalla'); ?></title>

    <!-- OwlCarousel -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php echo e(asset('front_end/css/bootstrap.css')); ?>" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo e(asset('front_end/css/font-awesome.min.css')); ?>" />

    <!-- Custom styles -->
    <link href="<?php echo e(asset('front_end/css/style.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('front_end/css/responsive.css')); ?>" rel="stylesheet" />
</head>

<body>

<div class="hero_area">

    <!-- HEADER -->
    <header class="header_section">

        <nav class="navbar navbar-expand-lg custom_nav-container">

            <button class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent">
                <span></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <!-- NAV LINKS -->
                <ul class="navbar-nav">
                    <img src="<?php echo e(asset('front_end/images/logo.png')); ?>" alt="Logo" style="height: 40px; width: auto; display: block;">
                    
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('index', [], false)); ?>">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('view_allproducts', [], false)); ?>">Tienda</a>
                    </li>

                    <?php if(($navCategories ?? collect())->count()): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navCategories" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Categorías
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navCategories">
                                <a class="dropdown-item" href="<?php echo e(route('view_allproducts', [], false)); ?>">Ver todo</a>
                                <div class="dropdown-divider"></div>
                                <?php $__currentLoopData = $navCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a class="dropdown-item" href="<?php echo e(route('view_allproducts', ['category' => $cat->category], false)); ?>"><?php echo e($cat->category); ?></a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('events', [], false)); ?>">Eventos</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('blog', [], false)); ?>">Blog</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('contacto', [], false)); ?>">Contacto</a>
                    </li>

                    
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(auth()->user()->user_type === 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link text-danger" href="<?php echo e(route('admin.dashboard')); ?>">
                                    Panel Admin
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>

                </ul>

                <!-- USER / CART -->
                <div class="user_option">

                    <!-- SEARCH ICON (DROPDOWN) -->
                    <div class="dropdown d-inline-block" style="margin-right: 18px;">
                        <a href="#" class="dropdown-toggle" id="navbarSearchDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: inherit;">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            <span class="sr-only">Buscar</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right p-2" aria-labelledby="navbarSearchDropdown" style="min-width: 280px;">
                            <form action="<?php echo e(route('search_products', [], false)); ?>" method="GET" class="m-0">
                                <div class="input-group">
                                    <input type="text" name="query" class="form-control" placeholder="Buscar productos..." value="<?php echo e(request('query')); ?>" aria-label="Buscar">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    
                    <?php if(auth()->guard()->check()): ?>

                        
                        <a href="<?php echo e(route('profile.edit', [], false)); ?>">
                            <i class="fa fa-user-circle"></i>
                            <span>Mi perfil</span>
                        </a>

                        
                        <span style="margin: 0 10px;">
                            <?php echo e(auth()->user()->name); ?>

                        </span>

                        
                        <span style="margin-right:10px;">
                            <i class="fa fa-star text-warning"></i>
                            <?php echo e(auth()->user()->points_balance); ?> pts
                        </span>

                        <a href="<?php echo e(route('points.history', [], false)); ?>" style="margin-right:10px;">
                            <i class="fa fa-list"></i>
                            <span>Historial</span>
                        </a>

                        
                        <form method="POST" action="<?php echo e(route('logout', [], false)); ?>" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                style="background:none;border:none;cursor:pointer;padding:0;">
                                <i class="fa fa-sign-out"></i>
                                <span>Salir</span>
                            </button>
                        </form>

                    <?php endif; ?>

                    
                    <?php if(auth()->guard()->guest()): ?>
                        <a href="<?php echo e(route('login', [], false)); ?>">
                            <i class="fa fa-user"></i>
                            <span>Iniciar sesión</span>
                        </a>

                        <a href="<?php echo e(route('register', [], false)); ?>">
                            <i class="fa fa-user-plus"></i>
                            <span>Registrarse</span>
                        </a>
                    <?php endif; ?>

                    
                    <a href="<?php echo e(route('cartproducts', [], false)); ?>">
                        <i class="fa fa-shopping-bag"></i>
                        <span><?php echo e($count ?? ($navCartCount ?? 0)); ?></span>
                    </a>

                </div>
            </div>
        </nav>
    </header>
    <!-- END HEADER -->

    
    <?php if (! empty(trim($__env->yieldContent('slider')))): ?>
        <section class="slider_section">
            <?php echo $__env->yieldContent('slider'); ?>
        </section>
    <?php endif; ?>

</div>

<!-- MAIN CONTENT -->
<section class="shop_section layout_padding">
    <div class="container">
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
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
    </div>
    <?php echo $__env->yieldContent('shop'); ?>
</section>

<!-- FOOTER -->
<footer class="footer_section">
    <div class="container">
        <div class="d-flex justify-content-center">
            <a class="mx-2" href="https://www.instagram.com/torredebatalla/" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                <i class="fa fa-instagram fa-2x"></i>
            </a>
            <a class="mx-2" href="https://www.youtube.com/@TorredeBatalla" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
                <i class="fa fa-youtube-play fa-2x"></i>
            </a>
        </div>
        <p>&copy; <?php echo e(date('Y')); ?> Torre de Batalla</p>
    </div>
</footer>

<!-- JS -->
<script src="<?php echo e(asset('front_end/js/jquery-3.4.1.min.js')); ?>"></script>
<script src="<?php echo e(asset('front_end/js/bootstrap.js')); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="<?php echo e(asset('front_end/js/custom.js')); ?>"></script>

</body>
</html>
<?php /**PATH /var/www/html/resources/views/maindesign.blade.php ENDPATH**/ ?>