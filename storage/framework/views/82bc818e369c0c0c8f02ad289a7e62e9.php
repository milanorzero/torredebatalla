<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $__env->yieldContent('page_title', 'Panel Administrador'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?php echo e(asset('admin/vendor/bootstrap/css/bootstrap.min.css')); ?>">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="<?php echo e(asset('admin/vendor/font-awesome/css/font-awesome.min.css')); ?>">
    <!-- Custom Font Icons CSS-->
    <link rel="stylesheet" href="<?php echo e(asset('admin/css/font.css')); ?>">
    <!-- Theme stylesheet-->
    <link rel="stylesheet" href="<?php echo e(asset('admin/css/style.default.css')); ?>">
    <!-- Custom stylesheet-->
    <link rel="stylesheet" href="<?php echo e(asset('admin/css/custom.css')); ?>">
    <!-- Favicon-->
    <link rel="shortcut icon" href="<?php echo e(asset('admin/img/favicon.ico')); ?>">
</head>

<body>

<!-- ================= HEADER ================= -->
<header class="header">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <!-- Botón hamburguesa solo visible en móvil -->
                <button class="btn btn-outline-light d-lg-none mr-3" id="sidebarToggleMobile" type="button" aria-label="Abrir menú">
                    <i class="fa fa-bars"></i>
                </button>
                <div class="navbar-header">
                    <strong class="text-white">
                        Panel Administrador
                    </strong>
                </div>
            </div>
            <div class="list-inline-item logout">
                <span class="text-white mr-3">
                    <?php echo e(auth()->user()->name); ?>

                </span>
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button class="btn btn-danger btn-sm">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    </nav>
</header>

<div class="d-flex align-items-stretch">

    <!-- ================= SIDEBAR ================= -->
    <nav id="sidebar">
        <div class="sidebar-header d-flex align-items-center">
            <div class="avatar">
                <img src="<?php echo e(asset('admin/img/avatar-6.jpg')); ?>"
                     class="img-fluid rounded-circle">
            </div>
            <div class="title">
                <h1 class="h5 mb-0">
                    <?php echo e(auth()->user()->name); ?>

                </h1>
                <p>Torre de Batalla</p>
            </div>
        </div>

        <span class="heading">Menú</span>

        <ul class="list-unstyled">

            <!-- DASHBOARD -->
            <li>
                <a href="<?php echo e(route('admin.dashboard')); ?>">
                    <i class="fa fa-home"></i> Dashboard
                </a>
            </li>

            <!-- POS / VENTA EN TIENDA -->
            <li>
                <a href="<?php echo e(route('admin.pos.create')); ?>">
                    <i class="fa fa-credit-card"></i> Venta en tienda
                </a>
            </li>

            <!-- PUNTOS -->
            <li>
                <a href="<?php echo e(route('admin.points.create')); ?>">
                    <i class="fa fa-star"></i> Asignar puntos
                </a>
            </li>

            <!-- EVENTOS -->
            <li>
                <a href="#eventsMenu" data-toggle="collapse">
                    <i class="fa fa-calendar"></i> Eventos
                </a>
                <ul id="eventsMenu" class="collapse list-unstyled">
                    <li>
                        <a href="<?php echo e(route('admin.events.calendar.edit')); ?>"><i class="fa fa-calendar-o"></i> Calendario semanal</a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.events.tournaments.create')); ?>"><i class="fa fa-trophy"></i> Publicar torneo</a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.events.tournaments.index')); ?>"><i class="fa fa-list"></i> Ver torneos</a>
                    </li>
                </ul>
            </li>

            <!-- CATEGORÍAS -->
            <li>
                <a href="#categoriesMenu" data-toggle="collapse">
                    <i class="fa fa-tags"></i> Categorías
                </a>
                <ul id="categoriesMenu" class="collapse list-unstyled">
                    <li>
                        <a href="<?php echo e(route('admin.addcategory')); ?>"><i class="fa fa-plus"></i> Agregar categoría</a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.viewcategory')); ?>"><i class="fa fa-list"></i> Ver categorías</a>
                    </li>
                </ul>
            </li>

            <!-- PRODUCTOS -->
            <li>
                <a href="#productsMenu" data-toggle="collapse">
                    <i class="fa fa-cubes"></i> Productos
                </a>
                <ul id="productsMenu" class="collapse list-unstyled">
                    <li>
                        <a href="<?php echo e(route('admin.addproduct')); ?>"><i class="fa fa-plus"></i> Agregar producto</a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.viewproduct')); ?>"><i class="fa fa-list"></i> Ver productos</a>
                    </li>
                </ul>
            </li>

            <!-- ÓRDENES -->
            <li>
                <a href="<?php echo e(route('admin.orders.index')); ?>">
                    <i class="fa fa-file-text-o"></i> Órdenes
                </a>
            </li>

            <!-- BLOG -->
            <li>
                <a href="<?php echo e(route('admin.blog.index')); ?>">
                    <i class="fa fa-newspaper-o"></i> Blog
                </a>
            </li>

            <!-- DISEÑO -->
            <li>
                <a href="<?php echo e(route('admin.slider.index')); ?>">
                    <i class="fa fa-picture-o"></i> Slider
                </a>
            </li>

        </ul>
    </nav>

    <!-- ================= CONTENIDO ================= -->
    <div class="page-content">

        <div class="page-header">
            <div class="container-fluid">
                <h2 class="h5 no-margin-bottom">
                    <?php echo $__env->yieldContent('page_title', 'Panel Administrador'); ?>
                </h2>
            </div>
        </div>

        <section class="no-padding-top no-padding-bottom">
            <?php echo $__env->yieldContent('content'); ?>
        </section>

        <footer class="footer mt-4">
            <div class="footer__block block text-center">
                <p class="mb-0">
                    © <?php echo e(date('Y')); ?> Torre de Batalla
                </p>
            </div>
        </footer>

    </div>
</div>

<!-- ================= JS ================= -->
<script src="<?php echo e(asset('admin/vendor/jquery/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('admin/vendor/popper.js/umd/popper.min.js')); ?>"></script>
<script src="<?php echo e(asset('admin/vendor/bootstrap/js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('admin/vendor/jquery.cookie/jquery.cookie.js')); ?>"></script>
<script src="<?php echo e(asset('admin/js/front.js')); ?>"></script>

</body>
</html>
<?php /**PATH /var/www/html/resources/views/admin/maindesign.blade.php ENDPATH**/ ?>