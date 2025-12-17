@extends('maindesign')

@section('title', 'Eventos - Torre de Batalla')

@section('shop')
<div class="container text-center my-5">
    <h2 class="mb-4">Eventos de la semana</h2>

    <div class="event-image">
        <img src="{{ asset('front_end/images/1804689b-47ed-4a32-8cc0-8ebf50fe1e6e.jpg') }}" 
             alt="Evento Torre de Batalla" 
             class="img-fluid rounded shadow-lg" 
             style="max-width: 100%; height: auto;">
    </div>
</div>
@endsection
