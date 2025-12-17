<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <link rel="shortcut icon" href="{{ asset('front_end/images/favicon.png') }}" type="image/x-icon">

    <title>@yield('title', 'Torre de Batalla')</title>

    <!-- slider stylesheet -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('front_end/css/bootstrap.css') }}" />

    <!-- Custom styles for this template -->
    <link href="{{ asset('front_end/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('front_end/css/responsive.css') }}" rel="stylesheet" />
</head>

<body>
    <div class="hero_area">
        <!-- header section -->
        <header class="header_section">
            <nav class="navbar navbar-expand-lg custom_nav-container">
                <a class="navbar-brand" href="{{ route('index') }}">
                    <span>Torre de Batalla</span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class=""></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('index') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('view_allproducts') }}">Tienda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('events') }}">Ligas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('blog') }}">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact') }}">Contacto</a>
                        </li>
                    </ul>
                    <div class="user_option">
                        @if(Auth::check())
                            <a href="{{ route('dashboard') }}">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span>Dashboard</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span>Iniciar sesión</span>
                            </a>
                            <a href="{{ route('register') }}">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span>Registrarse</span>
                            </a>
                        @endif

                        <a href="{{ route('cartproducts') }}">
                            <i class="fa fa-shopping-bag" aria-hidden="true">{{ $count ?? 0 }}</i>
                        </a>

                        <form class="form-inline" action="{{ route('search_products') }}" method="GET">
                            <input type="text" name="query" class="form-control" placeholder="Buscar productos..." required>
                            <button class="btn nav_search-btn" type="submit">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
        </header>
        <!-- end header section -->

        <!-- slider section solo si existe -->
        @hasSection('slider')
            <section class="slider_section">
                @yield('slider')
            </section>
        @endif
        <!-- end slider section -->
    </div>

    <!-- main content section -->
    <section class="shop_section layout_padding">
        @yield('shop')
    </section>
    <!-- end main content section -->

    <!-- contact section -->
    <section class="contact_section">
        <div class="container px-0">
            <div class="heading_container">
                <h2>Encuéntranos</h2>
            </div>
        </div>
        <div class="container container-bg">
            <div class="row">
                <div class="col-lg-7 col-md-6 px-0">
                    <div class="map_container">
                        <div class="map-responsive">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3193.7993661796104!2d-73.04613960000002!3d-36.8233274!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9669b5002be6ecb5%3A0xf08af81257d04e26!2sTorre%20de%20Batalla!5e0!3m2!1ses!2scl!4v1764757469763!5m2!1ses!2scl"
                                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-5 px-0">
                    <form action="#">
                        <div><input type="text" placeholder="Nombre" /></div>
                        <div><input type="email" placeholder="Correo" /></div>
                        <div><input type="text" placeholder="Telefono" /></div>
                        <div><input type="text" class="message-box" placeholder="Mensaje" /></div>
                        <div class="d-flex">
                            <button>Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- end contact section -->

    <!-- info & footer section -->
    <section class="info_section layout_padding2-top">
        <div class="social_container">
            <div class="social_box">
                <a href="https://www.instagram.com/torredebatalla" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                <a href="https://www.youtube.com/@TorredeBatalla" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a>
            </div>
        </div>
        <div class="info_container">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <h6>INFORMACION</h6>
                        <p>Quienes somos</p>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="info_form">
                            <h5>Boletin de noticias</h5>
                            <form action="#">
                                <input type="email" placeholder="Coloca tu correo">
                                <button>Suscribirse</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <h6>Servicio al cliente</h6>
                        <p>Terminos y condiciones</p>
                        <p>Contacto</p>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <h6>Contactanos</h6>
                        <div class="info_link-box">
                            <a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i>
                                <span>Freire 1053, Concepcion</span></a>
                            <a href="#"><i class="fa fa-phone" aria-hidden="true"></i>
                                <span>+01 12345678901</span></a>
                            <a href="#"><i class="fa fa-envelope" aria-hidden="true"></i>
                                <span>grupofogos@gmail.com</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer_section">
            <div class="container">
                <p>&copy; {{ date('Y') }} Torre de Batalla. Todos los derechos reservados.</p>
            </div>
        </footer>
    </section>
    <!-- end info & footer -->

    <script src="{{ asset('front_end/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('front_end/js/bootstrap.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="{{ asset('front_end/js/custom.js') }}"></script>
</body>
</html>
