@extends('maindesign')

@section('title', 'Pago rechazado')

@section('shop')
<div class="container text-center mt-5">
    <h2 class="text-danger">❌ Pago rechazado</h2>

    <p class="mt-3">
        El pago de la orden <strong>#{{ $order->id }}</strong> no pudo ser procesado.
    </p>

    <p>
        Puedes intentar nuevamente o elegir otro método de pago.
    </p>

    <a href="{{ route('checkout') }}" class="btn btn-warning mt-4">
        Volver al checkout
    </a>
</div>
@endsection
