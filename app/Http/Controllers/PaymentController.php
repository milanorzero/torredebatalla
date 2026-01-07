<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    private function canAccessOrder(Order $order): bool
    {
        if (Auth::check()) {
            return $order->user_id === Auth::id();
        }

        return $order->is_guest && session('order_id') === $order->id;
    }

    /**
     * Mostrar datos para pago por transferencia
     */
    public function transfer(Order $order)
    {
        if (!$this->canAccessOrder($order)) {
            abort(403);
        }

        return view('payments.transfer', [
            'order' => $order
        ]);
    }

    /**
     * Subir comprobante de transferencia
     */
    public function uploadTransferProof(Request $request, Order $order)
    {
        $request->validate([
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        if (!$this->canAccessOrder($order)) {
            abort(403);
        }

        try {
            $path = $request->file('payment_proof')->store('payments', 'public');
        } catch (\Throwable $e) {
            report($e);
            return back()->withErrors('No se pudo guardar el comprobante.');
        }

        // Guardamos ruta y dejamos pendiente de revisión
        $order->update([
            'estado_pago' => 'pendiente',
            'payment_proof' => $path, // si no existe la columna, te explico abajo
        ]);

        return redirect()
            ->route('checkout.success', $order)
            ->with('success', 'Comprobante enviado. Revisaremos tu pago.');
    }
}