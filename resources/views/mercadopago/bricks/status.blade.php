@extends('maindesign')

@section('title', 'Estado del pago')

@section('shop')
<div class="container">
    <h2 class="mb-4">Estado del pago</h2>

    <div class="card mb-4 w-100">
        <div class="card-header"><strong>Orden</strong></div>
        <div class="card-body">
            <p class="mb-1"><strong>Orden:</strong> #{{ $order->id }}</p>
            <p class="mb-1"><strong>Total:</strong> ${{ number_format($order->total) }}</p>
            <p class="mb-0"><strong>Estado interno:</strong> {{ $order->estado_pago }}</p>
        </div>
    </div>

    <div class="card w-100">
        <div class="card-header"><strong>Detalle del pago</strong></div>
        <div class="card-body">
            <div id="statusScreenBrick_container"></div>
        </div>
    </div>
</div>

<script src="https://sdk.mercadopago.com/js/v2"></script>
<script>
(function () {
    const publicKey = @json($publicKey);
    const paymentId = @json((string) $paymentId);

    const mp = new MercadoPago(publicKey);
    const bricksBuilder = mp.bricks();

    const renderStatusScreenBrick = async (bricksBuilder) => {
        const settings = {
            initialization: {
                paymentId: paymentId,
            },
            callbacks: {
                onReady: () => {
                    // Brick listo.
                },
                onError: (error) => {
                    console.error(error);
                },
            },
        };

        window.statusScreenBrickController = await bricksBuilder.create(
            'statusScreen',
            'statusScreenBrick_container',
            settings
        );
    };

    renderStatusScreenBrick(bricksBuilder);
})();
</script>
@endsection
