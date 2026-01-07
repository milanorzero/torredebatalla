@extends('maindesign')

@section('title', 'Torre de Batalla')

@section('slider')
<div class="slider_container">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="detail-box">
                                <h1>Bienvenido <br> a nuestra tienda</h1>
                                <p>
                                    ¡Tienda de TCG, Hobbies, Juegos de mesa y mucho más!📍Freire 1053, Concepción.
                                </p>
                                <a href="{{ route('events') }}">Ver calendario de eventos</a>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="img-box">
                                <img style="width:600px" src="{{ asset('front_end/images/logo.png') }}" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('shop')
<div class="container">
    <div class="heading_container heading_center">
        <h2>Últimos Productos</h2>
        <p>Los productos más recientes agregados a nuestra tienda</p>
    </div>

    <div class="row">
        @forelse($products as $product)
        <div class="col-sm-6 col-md-4 col-lg-4 mb-4">
            <div class="box shadow-sm rounded p-2">
                <a href="{{ route('product_details', ['id' => $product->id]) }}">
                    <div class="img-box text-center">
                        <img src="{{ asset('products/' . $product->product_image) }}" 
                             alt="{{ $product->product_title }}" 
                             class="img-fluid" 
                             style="max-height: 200px; object-fit: contain;">
                    </div>
                    <div class="detail-box mt-3 text-center">
                        <h6>{{ $product->product_title }}</h6>
                        <h6>
                            Precio: 
                            <span class="text-success fw-bold">${{ number_format($product->product_price) }}</span>
                        </h6>
                    </div>
                    @if($product->is_new ?? true)
                        <div class="new"><span>Nuevo</span></div>
                    @endif
                </a>
            </div>
        </div>
        @empty
        <p>No hay productos disponibles por el momento.</p>
        @endforelse
    </div>

    <div class="btn-box text-center mt-4">
        <a href="{{ route('view_allproducts') }}" class="btn btn-primary">Ver todos los productos</a>
    </div>
</div>
@endsection