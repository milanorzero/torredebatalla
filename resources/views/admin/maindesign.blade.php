<!DOCTYPE html>
<html>
  <head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Modo administrador</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{ asset('admin/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="{{ asset('admin/vendor/font-awesome/css/font-awesome.min.css') }}">
    <!-- Custom Font Icons CSS-->
    <link rel="stylesheet" href="{{ asset('admin/css/font.css') }}">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{ asset('admin/css/style.default.css') }}" id="theme-stylesheet">
    <!-- Custom stylesheet-->
    <link rel="stylesheet" href="{{ asset('admin/css/custom.css') }}">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{ asset('admin/img/favicon.ico') }}">

  </head>

  <body>
    <header class="header">   
      <nav class="navbar navbar-expand-lg">
        <div class="container-fluid d-flex align-items-center justify-content-between">
          <div class="navbar-header">
          </div>
          <div class="list-inline-item logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-dropdown-link :href="route('logout')"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('Desconectarse') }}
                </x-dropdown-link>
            </form>
          </div>
        </div>
      </nav>
    </header>

    <div class="d-flex align-items-stretch">
      <!-- Sidebar Navigation-->
      <nav id="sidebar">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">
          <div class="avatar">
            <img src="{{ asset('admin/img/avatar-6.jpg') }}" alt="avatar" class="img-fluid rounded-circle">
          </div>
          <div class="title">
            <h1 class="h5">Admin</h1>
            <p>Torre de batalla</p>
          </div>
        </div>

        <!-- Menú -->
        <span class="heading">Menu</span>
        <ul class="list-unstyled">
          <li><a href="{{ route('dashboard') }}"><i class="icon-home"></i>Home</a></li>

          <li>
            <a href="#dropdownCategories" data-toggle="collapse">
              <i class="icon-windows"></i>Categorias
            </a>
            <ul id="dropdownCategories" class="collapse list-unstyled">
              <li><a href="{{ route('admin.addcategory') }}">Agregar Categoria</a></li>
              <li><a href="{{ route('admin.viewcategory') }}">Ver Categoria</a></li>
            </ul>
          </li>

          <li>
            <a href="#dropdownProducts" data-toggle="collapse">
              <i class="icon-windows"></i>Productos
            </a>
            <ul id="dropdownProducts" class="collapse list-unstyled">
              <li><a href="{{ route('admin.addproduct') }}">Agregar productos</a></li>
              <li><a href="{{ route('admin.viewproduct') }}">Ver productos</a></li>
              <li><a href="#">Ver orden</a></li>
            </ul>
          </li>
           <li>
            <a href="#dropdownCategories" data-toggle="collapse">
              <i class="icon-windows"></i>Jugadores
            </a>
            <ul id="dropdownCategories" class="collapse list-unstyled">
              <li><a href="{{ route('admin.addcategory') }}">Agregar jugador</a></li>
              <li><a href="{{ route('admin.viewcategory') }}">Ver jugadores</a></li>
            </ul>
          </li>
        </ul>
      </nav>

      <!-- Page content -->
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Panel de administrador</h2>
          </div>
        </div>

        <section class="no-padding-top no-padding-bottom">
          @yield('dashboard')
          @yield('add_category')
          @yield('view_category')
          @yield('update_category')
          @yield('add_product')
        </section>

        <footer class="footer">
          <div class="footer__block block no-margin-bottom">
            <div class="container-fluid text-center">
              <p class="no-margin-bottom">
                2018 © Your company. Download From TemplatesHub.
              </p>
            </div>
          </div>
        </footer>
      </div>
    </div>

    <!-- JavaScript files-->
    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/popper.js/umd/popper.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/jquery.cookie/jquery.cookie.js') }}"></script>
    <script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/js/charts-home.js') }}"></script>
    <script src="{{ asset('admin/js/front.js') }}"></script>

  </body>
</html>
