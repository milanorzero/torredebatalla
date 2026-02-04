@extends('maindesign')

@section('title', 'Demasiadas solicitudes')

@section('shop')
<div class="container" style="max-width: 720px;">
    <div class="card shadow-sm w-100">
        <div class="card-body p-4">
            <h2 class="mb-2">Demasiadas solicitudes (429)</h2>
            <p class="text-muted mb-3">
                Hemos recibido demasiados intentos en poco tiempo. Por favor espera un momento y vuelve a intentarlo.
            </p>
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary">Volver</a>
        </div>
    </div>
</div>
@endsection
