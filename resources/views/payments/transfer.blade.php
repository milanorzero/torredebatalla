@extends('maindesign')

@section('title', 'Pago por transferencia')

@section('shop')
<div class="container">

    <h2 class="mb-4">Pago por transferencia bancaria</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- DATOS DE LA ORDEN --}}
    <div class="alert alert-info mb-4">
        <strong>Orden #{{ $order->id }}</strong><br>
        Total a pagar: <strong>${{ number_format($order->total) }}</strong>
    </div>

    {{-- DATOS DE TRANSFERENCIA --}}
    <div class="card mb-4">
        <div class="card-header"><strong>Datos de transferencia</strong></div>
        <div class="card-body">
            <p><strong>Razón social:</strong> Grupo Fogos</p>
            <p><strong>RUT:</strong> 78064065-0</p>
            <p><strong>Banco:</strong> MercadoPago</p>
            <p><strong>Tipo de cuenta:</strong> Cuenta Vista</p>
            <p><strong>N° de cuenta:</strong> 1091256512</p>
            <p><strong>Email:</strong> {{ config('app.contact_to_email') }}</p>
        </div>
    </div>

    {{-- SUBIR COMPROBANTE --}}
    <div class="card">
        <div class="card-header"><strong>Subir comprobante</strong></div>
        <div class="card-body">

            <form method="POST"
                action="{{ route('payment.transfer.upload', $order) }}"
                  enctype="multipart/form-data">
                @csrf

                <input type="file"
                      name="payment_proof"
                       class="form-control mb-3"
                       accept="image/*,application/pdf"
                       required>

                <button class="btn btn-success w-100">
                    Enviar comprobante
                </button>
            </form>

        </div>
    </div>

</div>
@endsection
