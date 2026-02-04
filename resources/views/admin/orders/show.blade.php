@extends('admin.maindesign')

@section('page_title', 'Detalle de orden #' . $order->id)

@section('content')

{{-- DATOS CLIENTE --}}
<div class="card mb-4">
    <div class="card-header"><strong>Datos del cliente</strong></div>
    <div class="card-body">
        <p><strong>Nombre:</strong> {{ $order->nombres }} {{ $order->apellidos }}</p>
        <p><strong>Email:</strong> {{ $order->email }}</p>
        <p><strong>Teléfono:</strong> {{ $order->telefono }}</p>
        <p><strong>Documento:</strong> {{ $order->documento }}</p>
    </div>
</div>

{{-- ENVÍO --}}
<div class="card mb-4">
    <div class="card-header"><strong>Productos</strong></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product_title }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->price) }}</td>
                            <td>${{ number_format($item->price * $item->quantity) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->product_title }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->price) }}</td>
                        <td>${{ number_format($item->subtotal) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h5 class="text-right mt-3">
            Total: ${{ number_format($order->total) }}
        </h5>
    </div>
</div>

{{-- COMPROBANTE --}}
@if($order->payment_proof)
<div class="card mb-4">
    <div class="card-header"><strong>Comprobante de pago</strong></div>
    <div class="card-body">
        <a href="{{ route('admin.orders.payment-proof', $order) }}"
           target="_blank"
           class="btn btn-primary">
            Ver comprobante
        </a>
    </div>
</div>
@endif

{{-- ACCIONES --}}
@if($order->estado_pago === 'pendiente')
<div class="d-flex gap-2">
    <form method="POST" action="{{ route('admin.orders.approve', $order) }}">
        @csrf
        <button class="btn btn-success">Aprobar pago</button>
    </form>

    <form method="POST" action="{{ route('admin.orders.reject', $order) }}">
        @csrf
        <button class="btn btn-danger">Rechazar</button>
    </form>

    <form method="POST" action="{{ route('admin.orders.cancel', $order) }}">
        @csrf
        <button class="btn btn-secondary">Cancelar</button>
    </form>
</div>
@endif

@endsection
