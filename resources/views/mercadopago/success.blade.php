@extends('maindesign')

@section('title', 'Pago exitoso')

@section('shop')
<div class="container text-center mt-5">
    <h2 class="text-success">✅ Pago realizado con éxito</h2>

    <p class="mt-3">
        Gracias por tu compra.<br>
        Tu orden <strong>#{{ $order->id }}</strong> fue pagada correctamente.
    </p>

    <p>
        <strong>Método de pago:</strong> Mercado Pago<br>
        <strong>Total:</strong> ${{ number_format($order->total) }}
    </p>

    <a href="{{ route('index') }}" class="btn btn-primary mt-4">
        Volver al inicio
    </a>
</div>
@endsection
