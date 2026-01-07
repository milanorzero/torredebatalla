@extends('admin.maindesign')

@section('page_title', 'Listado de órdenes')

@section('content')
<div class="card">
    <div class="card-header">
        <strong>Órdenes registradas</strong>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Método pago</th>
                    <th>Comprobante</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->nombres }} {{ $order->apellidos }}</td>
                        <td>${{ number_format($order->total) }}</td>
                        <td>{{ ucfirst($order->metodo_pago) }}</td>
                        <td>
                            @if($order->payment_proof)
                                <a href="{{ route('admin.orders.payment-proof', $order) }}"
                                   target="_blank"
                                   class="badge badge-success">
                                    Ver
                                </a>
                            @else
                                <span class="badge badge-secondary">—</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $badge = match ($order->estado_pago) {
                                    'pagado' => 'success',
                                    'pendiente' => 'warning',
                                    'rechazado' => 'danger',
                                    'cancelado' => 'secondary',
                                    default => 'secondary',
                                };
                            @endphp
                            <span class="badge badge-{{ $badge }}">{{ $order->estado_pago }}</span>
                        </td>
                        <td>{{ $order->created_at->format('d-m-Y') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}"
                               class="btn btn-sm btn-primary">
                                Ver
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            No hay órdenes registradas
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
