@extends('maindesign')

@section('title', 'Pago pendiente')

@section('shop')
<div class="container text-center mt-5">
    <h2 class="text-warning">⏳ Pago pendiente</h2>

    <p class="mt-3">
        Tu orden <strong>#{{ $order->id }}</strong> está pendiente de confirmación.
    </p>

    <p>
        Si ya realizaste el pago, puede tardar unos minutos en reflejarse.
    </p>

    <a href="{{ route('index') }}" class="btn btn-primary mt-4">
        Volver al inicio
    </a>
</div>
@endsection
