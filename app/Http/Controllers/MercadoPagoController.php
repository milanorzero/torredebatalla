<?php

namespace App\Http\Controllers;

use App\Mail\OrderPaidMail;
use App\Models\Order;
use App\Models\PointTransaction;
use App\Models\ProductCart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\MercadoPagoConfig;

class MercadoPagoController extends Controller
{
    public function init()
    {
        $orderId = session('order_id');

        if (!$orderId) {
            abort(404, 'Orden no encontrada en sesión');
        }

        $order = Order::where('id', $orderId)
            ->where('estado_pago', 'pendiente')
            ->firstOrFail();

        $accessToken = config('mercadopago.access_token');

        if (!$accessToken) {
            abort(500, 'Falta configurar MERCADOPAGO_ACCESS_TOKEN');
        }

        MercadoPagoConfig::setAccessToken($accessToken);

        $request = [
            'external_reference' => (string) $order->id,
            'payer' => [
                'email' => (string) $order->email,
                'name' => (string) $order->nombres,
                'surname' => (string) $order->apellidos,
            ],
            'items' => [
                [
                    'title' => 'Orden #' . $order->id,
                    'quantity' => 1,
                    'unit_price' => (float) $order->total,
                    'currency_id' => (string) config('mercadopago.currency', 'CLP'),
                ],
            ],
            'back_urls' => [
                'success' => route('mercadopago.return', ['result' => 'success']),
                'failure' => route('mercadopago.return', ['result' => 'failure']),
                'pending' => route('mercadopago.return', ['result' => 'pending']),
            ],
            'auto_return' => 'approved',
        ];

        $notificationUrl = config('mercadopago.notification_url');
        if ($notificationUrl) {
            $request['notification_url'] = $notificationUrl;
        }

        $client = new PreferenceClient();
        $preference = $client->create($request);

        $initPoint = config('mercadopago.sandbox')
            ? $preference->sandbox_init_point
            : $preference->init_point;

        return redirect()->away($initPoint);
    }

    public function bricksCheckout()
    {
        $orderId = session('order_id');

        if (!$orderId) {
            abort(404, 'Orden no encontrada en sesión');
        }

        $order = Order::where('id', $orderId)
            ->where('estado_pago', 'pendiente')
            ->firstOrFail();

        $accessToken = config('mercadopago.access_token');
        $publicKey = config('mercadopago.public_key');

        if (!$accessToken) {
            abort(500, 'Falta configurar MERCADOPAGO_ACCESS_TOKEN');
        }

        if (!$publicKey) {
            abort(500, 'Falta configurar MERCADOPAGO_PUBLIC_KEY');
        }

        MercadoPagoConfig::setAccessToken($accessToken);

        // Preferencia requerida para habilitar el medio "mercadoPago" dentro del Payment Brick
        // (pago con cuenta). Para tarjetas, el Brick enviará los datos al endpoint process_payment.
        $preferenceRequest = [
            'external_reference' => (string) $order->id,
            'payer' => [
                'email' => (string) $order->email,
                'name' => (string) $order->nombres,
                'surname' => (string) $order->apellidos,
            ],
            'items' => [
                [
                    'title' => 'Orden #' . $order->id,
                    'quantity' => 1,
                    'unit_price' => (float) $order->total,
                    'currency_id' => (string) config('mercadopago.currency', 'CLP'),
                ],
            ],
            'back_urls' => [
                'success' => route('mercadopago.return', ['result' => 'success']),
                'failure' => route('mercadopago.return', ['result' => 'failure']),
                'pending' => route('mercadopago.return', ['result' => 'pending']),
            ],
            'auto_return' => 'approved',
        ];

        $notificationUrl = config('mercadopago.notification_url');
        if ($notificationUrl) {
            $preferenceRequest['notification_url'] = $notificationUrl;
        }

        $client = new PreferenceClient();
        $preference = $client->create($preferenceRequest);

        $preferenceId = (string) $preference->id;
        $amount = (int) $order->total;

        return view('mercadopago.bricks.checkout', compact('order', 'publicKey', 'preferenceId', 'amount'));
    }

    public function bricksProcessPayment(Request $request)
    {
        $orderId = (int) $request->input('order_id');
        $sessionOrderId = (int) session('order_id');

        if (!$orderId || $orderId !== $sessionOrderId) {
            return response()->json(['ok' => false, 'error' => 'invalid_order'], 403);
        }

        $order = Order::where('id', $orderId)
            ->where('estado_pago', 'pendiente')
            ->first();

        if (!$order) {
            return response()->json(['ok' => false, 'error' => 'order_not_found'], 404);
        }

        $accessToken = config('mercadopago.access_token');
        if (!$accessToken) {
            return response()->json(['ok' => false, 'error' => 'missing_access_token'], 500);
        }

        $formData = $request->input('formData');
        if (!is_array($formData)) {
            return response()->json(['ok' => false, 'error' => 'invalid_form_data'], 422);
        }

        // Armamos el payload permitido (evita que el frontend pueda alterar el monto o la referencia).
        $payload = [
            'transaction_amount' => (float) $order->total,
            'description' => 'Orden #' . $order->id,
            'external_reference' => (string) $order->id,
        ];

        foreach (['token', 'installments', 'payment_method_id', 'issuer_id'] as $key) {
            if (array_key_exists($key, $formData)) {
                $payload[$key] = $formData[$key];
            }
        }

        $payload['payer'] = [
            'email' => (string) $order->email,
        ];

        // Si el Brick envía identificación, la preservamos.
        if (isset($formData['payer']) && is_array($formData['payer'])) {
            $payer = $formData['payer'];
            if (isset($payer['identification']) && is_array($payer['identification'])) {
                $payload['payer']['identification'] = $payer['identification'];
            }
            if (isset($payer['first_name'])) {
                $payload['payer']['first_name'] = $payer['first_name'];
            }
            if (isset($payer['last_name'])) {
                $payload['payer']['last_name'] = $payer['last_name'];
            }
        }

        MercadoPagoConfig::setAccessToken($accessToken);

        $client = new PaymentClient();
        $requestOptions = new RequestOptions();
        $requestOptions->setCustomHeaders([
            'X-Idempotency-Key: ' . (string) Str::uuid(),
        ]);

        try {
            $payment = $client->create($payload, $requestOptions);
        } catch (\Throwable $e) {
            report($e);
            return response()->json(['ok' => false, 'error' => 'payment_create_failed'], 500);
        }

        if (!$payment || !$payment->id) {
            return response()->json(['ok' => false, 'error' => 'payment_create_failed'], 500);
        }

        if ((string) $payment->status === 'approved') {
            $this->markOrderAsPaid($order);
        } elseif (in_array((string) $payment->status, ['rejected', 'cancelled'], true)) {
            $order->update(['estado_pago' => 'rechazado']);
        }

        return response()->json([
            'ok' => true,
            'payment_id' => (int) $payment->id,
            'status' => (string) $payment->status,
            'redirect_url' => route('mercadopago.bricks.status', ['paymentId' => (int) $payment->id]),
        ]);
    }

    public function bricksStatus(int $paymentId)
    {
        $orderId = session('order_id');
        if (!$orderId) {
            abort(404, 'Orden no encontrada en sesión');
        }

        $order = Order::findOrFail($orderId);

        $accessToken = config('mercadopago.access_token');
        $publicKey = config('mercadopago.public_key');

        if (!$accessToken) {
            abort(500, 'Falta configurar MERCADOPAGO_ACCESS_TOKEN');
        }

        if (!$publicKey) {
            abort(500, 'Falta configurar MERCADOPAGO_PUBLIC_KEY');
        }

        MercadoPagoConfig::setAccessToken($accessToken);

        // Sincroniza el estado de la orden si corresponde.
        if ($order->estado_pago !== 'pagado') {
            try {
                $payment = (new PaymentClient())->get($paymentId);
                if ($payment && (string) $payment->external_reference === (string) $order->id) {
                    if ((string) $payment->status === 'approved') {
                        $this->markOrderAsPaid($order);
                    } elseif (in_array((string) $payment->status, ['rejected', 'cancelled'], true)) {
                        $order->update(['estado_pago' => 'rechazado']);
                    }
                }
            } catch (\Throwable $e) {
                report($e);
            }
        }

        return view('mercadopago.bricks.status', [
            'order' => $order,
            'publicKey' => $publicKey,
            'paymentId' => $paymentId,
        ]);
    }

    public function return(Request $request)
    {
        $result = (string) $request->query('result', 'pending');

        $externalReference = $request->query('external_reference');
        $orderId = $externalReference ?: session('order_id');

        if (!$orderId) {
            abort(404, 'Orden no encontrada');
        }

        $order = Order::findOrFail($orderId);

        if ($order->estado_pago === 'pagado') {
            return view('mercadopago.success', compact('order'));
        }

        if ($result === 'failure') {
            $order->update(['estado_pago' => 'rechazado']);
            return view('mercadopago.failed', compact('order'));
        }

        $paymentId = $request->query('payment_id');

        if (!$paymentId) {
            // For pending/unknown responses without payment id.
            return view('mercadopago.pending', compact('order'));
        }

        $accessToken = config('mercadopago.access_token');
        if (!$accessToken) {
            abort(500, 'Falta configurar MERCADOPAGO_ACCESS_TOKEN');
        }

        MercadoPagoConfig::setAccessToken($accessToken);

        try {
            $payment = (new PaymentClient())->get((int) $paymentId);
        } catch (\Throwable $e) {
            report($e);
            return view('mercadopago.pending', compact('order'));
        }

        if (!$payment || (string) $payment->external_reference !== (string) $order->id) {
            return view('mercadopago.pending', compact('order'));
        }

        if ((string) $payment->status === 'approved') {
            $this->markOrderAsPaid($order);
            return view('mercadopago.success', compact('order'));
        }

        if (in_array((string) $payment->status, ['rejected', 'cancelled'], true)) {
            $order->update(['estado_pago' => 'rechazado']);
            return view('mercadopago.failed', compact('order'));
        }

        return view('mercadopago.pending', compact('order'));
    }

    public function webhook(Request $request)
    {
        $paymentId = $request->input('data.id')
            ?: $request->input('id')
            ?: $request->query('data.id')
            ?: $request->query('id');

        if (!$paymentId) {
            return response()->json(['ok' => true]);
        }

        $accessToken = config('mercadopago.access_token');
        if (!$accessToken) {
            return response()->json(['ok' => false, 'error' => 'missing_access_token'], 500);
        }

        MercadoPagoConfig::setAccessToken($accessToken);

        try {
            $payment = (new PaymentClient())->get((int) $paymentId);
        } catch (\Throwable $e) {
            report($e);
            return response()->json(['ok' => true]);
        }

        if (!$payment || !$payment->external_reference) {
            return response()->json(['ok' => true]);
        }

        $order = Order::find($payment->external_reference);
        if (!$order) {
            return response()->json(['ok' => true]);
        }

        if ($order->estado_pago === 'pagado') {
            return response()->json(['ok' => true]);
        }

        if ((string) $payment->status === 'approved') {
            $this->markOrderAsPaid($order);
        } elseif (in_array((string) $payment->status, ['rejected', 'cancelled'], true)) {
            $order->update(['estado_pago' => 'rechazado']);
        }

        return response()->json(['ok' => true]);
    }

    private function markOrderAsPaid(Order $order): void
    {
        $order->update([
            'estado_pago' => 'pagado',
            'metodo_pago' => 'mercadopago',
        ]);

        if ($order->user_id && (int) $order->points_used > 0) {
            $alreadySpent = PointTransaction::where('user_id', $order->user_id)
                ->where('type', 'spent')
                ->where('channel', 'web')
                ->where('reference_id', $order->id)
                ->exists();

            if (!$alreadySpent) {
                /** @var User $user */
                $user = User::findOrFail($order->user_id);
                $user->spendPoints(
                    (int) $order->points_used,
                    'Compra web',
                    'web',
                    (int) $order->id
                );
            }
        }

        try {
            Mail::to($order->email)->send(new OrderPaidMail($order));
        } catch (\Throwable $e) {
            report($e);
        }

        if ($order->user_id) {
            ProductCart::where('user_id', $order->user_id)->delete();
        }
    }
}
