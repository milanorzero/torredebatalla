<?php

namespace App\Http\Controllers;

use App\Mail\OrderPaidMail;
use App\Models\Order;
use App\Models\PointTransaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laragear\Transbank\Facades\Webpay;
use Laragear\Transbank\Http\Requests\WebpayRequest;

class WebpayController extends Controller
{
    private function canAccessOrder(Order $order): bool
    {
        if (Auth::check()) {
            return $order->user_id === Auth::id();
        }

        return $order->is_guest && session('order_id') === $order->id;
    }

    /**
     * Crea la transacción y redirige a Webpay Plus (ambiente de integración/test).
     */
    public function start(Order $order)
    {
        if (!$this->canAccessOrder($order)) {
            abort(403);
        }

        if ($order->estado_pago !== 'pendiente') {
            return redirect()->route('index')->with('error', 'La orden no está pendiente.');
        }

        if (blank($order->buy_order)) {
            $order->update([
                'buy_order' => 'TB-' . now()->timestamp . '-' . $order->id,
            ]);
            $order->refresh();
        }

        if ((int) $order->total <= 0) {
            return redirect()->route('checkout')->withErrors('El total de la orden no es válido para Webpay.');
        }

        try {
            $response = Webpay::create(
                (string) $order->buy_order,
                (int) $order->total,
                route('webpay.return')
            );

            $order->update([
                'metodo_pago' => 'webpay',
                'webpay_token' => (string) $response->getToken(),
                'estado_pago' => 'pendiente',
            ]);

            return $response;
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('checkout')->withErrors('No se pudo iniciar el pago con Webpay.');
        }
    }

    /**
     * Retorno desde Webpay. Confirma (commit) la transacción.
     */
    public function return(WebpayRequest $request)
    {
        try {
            $buyOrder = (string) $request->input('TBK_ORDEN_COMPRA', '');
            if ($buyOrder === '' && $request->isNotError()) {
                $buyOrder = (string) $request->buyOrder();
            }

            if ($buyOrder === '') {
                return redirect()->route('index')->with('error', 'Pago cancelado o inválido.');
            }

            $order = Order::where('buy_order', $buyOrder)->first();
            if (!$order) {
                return redirect()->route('index')->with('error', 'Orden no encontrada para el pago.');
            }

            if ($order->estado_pago === 'pagado') {
                return redirect()->route('index')->with('success', "Pago aprobado. Orden #{$order->id}.");
            }

            $token = (string) ($request->input('token_ws') ?? $request->input('TBK_TOKEN') ?? '');
            if ($token !== '') {
                $order->update(['webpay_token' => $token]);
            }

            $approved = $request->isSuccessful();

            $order->update([
                'metodo_pago' => 'webpay',
                'estado_pago' => $approved ? 'pagado' : 'rechazado',
            ]);

            if ($approved) {
                $this->finalizePaidOrder($order);
                return redirect()->route('index')->with('success', "Pago aprobado. Orden #{$order->id}.");
            }

            return redirect()->route('index')->with('error', 'Pago rechazado.');
        } catch (\Throwable $e) {
            report($e);
            if (isset($order) && $order instanceof Order) {
                $order->update(['estado_pago' => 'rechazado']);
            }
            return redirect()->route('index')->with('error', 'Error confirmando el pago.');
        }
    }

    private function finalizePaidOrder(Order $order): void
    {
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
    }
}
