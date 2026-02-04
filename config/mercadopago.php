<?php

return [
    'access_token' => env('MERCADOPAGO_ACCESS_TOKEN'),
    'public_key' => env('MERCADOPAGO_PUBLIC_KEY'),

    // Webhook secret key generated in Mercado Pago Developers (Webhooks > Configurar notificaciones).
    // When set, incoming webhook requests will be verified via the x-signature header.
    'webhook_secret' => env('MERCADOPAGO_WEBHOOK_SECRET'),

    // ISO 4217 currency code. For Chile, CLP is common.
    'currency' => env('MERCADOPAGO_CURRENCY', 'CLP'),

    // When true, uses sandbox init point.
    'sandbox' => filter_var(env('MERCADOPAGO_SANDBOX', true), FILTER_VALIDATE_BOOL),

    // Optional: Mercado Pago webhooks require a public URL.
    // If null, notification_url won't be set on the preference.
    'notification_url' => env('MERCADOPAGO_NOTIFICATION_URL'),
];
