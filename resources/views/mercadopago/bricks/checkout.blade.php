@extends('maindesign')

@section('title', 'Pagar con Mercado Pago')

@section('shop')
<div class="container">
    <h2 class="mb-4">Pago con Mercado Pago</h2>

    <div class="card mb-4 w-100">
        <div class="card-header"><strong>Resumen</strong></div>
        <div class="card-body">
            <p class="mb-1"><strong>Orden:</strong> #{{ $order->id }}</p>
            <p class="mb-0"><strong>Total a pagar:</strong> ${{ number_format($order->total) }}</p>
        </div>
    </div>

    <div class="card w-100">
        <div class="card-header"><strong>Completa tu pago</strong></div>
        <div class="card-body">
            <div id="paymentBrick_container"></div>
        </div>
    </div>
</div>

<script src="https://sdk.mercadopago.com/js/v2"></script>
<script>
(function () {
    const publicKey = @json($publicKey);
    const amount = @json($amount);
    const preferenceId = @json($preferenceId);

    const mp = new MercadoPago(publicKey);
    const bricksBuilder = mp.bricks();

    const renderPaymentBrick = async (bricksBuilder) => {
        const settings = {
            initialization: {
                // Para CLP debe ser entero.
                amount: amount,
                // Necesario para habilitar "mercadoPago" (pago con cuenta).
                preferenceId: preferenceId,
            },
            customization: {
                paymentMethods: {
                    creditCard: "all",
                    prepaidCard: "all",
                    debitCard: "all",
                    mercadoPago: "all",
                },
            },
            callbacks: {
                onReady: () => {
                    // Brick listo.
                },
                onSubmit: ({ selectedPaymentMethod, formData }) => {
                    return new Promise((resolve, reject) => {
                        fetch(@json(route('mercadopago.bricks.process_payment')), {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            },
                            body: JSON.stringify({
                                order_id: @json((int) $order->id),
                                selectedPaymentMethod: selectedPaymentMethod,
                                formData: formData,
                            }),
                        })
                        .then((response) => response.json())
                        .then((response) => {
                            if (response && response.ok && response.redirect_url) {
                                window.location.href = response.redirect_url;
                                resolve();
                                return;
                            }
                            reject();
                        })
                        .catch(() => {
                            reject();
                        });
                    });
                },
                onError: (error) => {
                    console.error(error);
                },
            },
        };

        window.paymentBrickController = await bricksBuilder.create(
            "payment",
            "paymentBrick_container",
            settings
        );
    };

    renderPaymentBrick(bricksBuilder);
})();
</script>
@endsection
