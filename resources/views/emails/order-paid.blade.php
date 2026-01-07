<h2>Pago confirmado - Orden #{{ $order->id }}</h2>

<p>Hola {{ $order->nombres }},</p>

<p>
    Confirmamos tu pago. Estado actual: <strong>{{ $order->estado_pago }}</strong>.
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
    <strong>Total pagado:</strong> ${{ number_format($order->total) }}<br>
    <strong>Puntos usados:</strong> {{ (int)($order->points_used ?? 0) }}
</p>

<p>Gracias por tu compra.</p>
