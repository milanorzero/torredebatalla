<h2>Orden #{{ $order->id }} creada</h2>

<p>Hola {{ $order->nombres }},</p>

<p>
    Recibimos tu pedido. Estado actual: <strong>{{ $order->estado_pago }}</strong>.
</p>

<h3>Resumen</h3>
<ul>
    @foreach($order->items as $item)
        <li>
            {{ $item->product->product_title }} — {{ $item->quantity }} x ${{ number_format($item->price) }}
        </li>
    @endforeach
</ul>

<p>
    <strong>Subtotal:</strong> ${{ number_format($order->subtotal) }}<br>
    <strong>Puntos reservados:</strong> {{ (int)($order->points_used ?? 0) }}<br>
    <strong>Total:</strong> ${{ number_format($order->total) }}
</p>

@if($order->metodo_pago === 'transferencia')
    <h3>Pago por transferencia</h3>
    <p>Para completar tu compra, sube el comprobante desde este enlace:</p>
    <p>
        <a href="{{ url('/payment/transfer/' . $order->id) }}">Subir comprobante</a>
    </p>
@endif

@if($order->metodo_pago === 'mercadopago')
    <p>Serás redirigido a Mercado Pago para completar el pago.</p>
@endif

<p>Gracias por comprar en Torre de Batalla.</p>
