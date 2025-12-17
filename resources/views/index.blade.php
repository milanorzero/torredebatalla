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
                                <img style="width:600px" src="{{ asset('front_end/images/image3.jpg') }}" alt="" />
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
{{-- Aquí puedes poner productos destacados, últimas noticias o cualquier contenido principal --}}
@endsection
