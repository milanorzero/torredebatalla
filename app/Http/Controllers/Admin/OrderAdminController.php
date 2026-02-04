<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PointTransaction;
use App\Models\User;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\OrderPaidMail;
use Illuminate\Support\Facades\DB;

class OrderAdminController extends Controller
{
    /**
     * Listado de órdenes
     */
    public function index()
    {
        $orders = Order::latest()->get();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Ver detalle de una orden
     */
    public function show(Order $order)
    {
        $order->load('items.product');

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Descargar/ver comprobante de pago (sin depender de storage:link).
     */
    public function paymentProof(Order $order): StreamedResponse
    {
        if (!$order->payment_proof) {
            abort(404);
        }

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('public');

        if (!$disk->exists($order->payment_proof)) {
            abort(404);
        }

        $fullPath = $order->payment_proof;
        $mimeType = $disk->mimeType($fullPath) ?: 'application/octet-stream';
        $filename = basename($fullPath);

        return response()->streamDownload(
            function () use ($disk, $fullPath): void {
                echo $disk->get($fullPath);
            },
            $filename,
            [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
            ]
        );
    }

    /**
     * Aprobar pago
     */
    public function approve(Order $order)
    {
        $order->update([
            'estado_pago' => 'pagado'
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

        return redirect()
            ->back()
            ->with('success', 'Pago aprobado correctamente.');
    }

    /**
     * Rechazar pago
     */
    public function reject(Order $order)
    {
        if ($order->estado_pago !== 'pendiente') {
            return redirect()
                ->back()
                ->with('error', 'Solo se pueden rechazar órdenes pendientes.');
        }

        DB::transaction(function () use ($order): void {
            $order->refresh();
            if ($order->estado_pago !== 'pendiente') {
                return;
            }

            $order->restockProducts();
            $order->update([
                'estado_pago' => 'rechazado'
            ]);
        });

        return redirect()
            ->back()
            ->with('error', 'Pago rechazado.');
    }

    /**
     * Cancelar orden pendiente
     */
    public function cancel(Order $order)
    {
        if ($order->estado_pago !== 'pendiente') {
            return redirect()
                ->back()
                ->with('error', 'Solo se pueden cancelar órdenes pendientes.');
        }

        DB::transaction(function () use ($order): void {
            $order->refresh();
            if ($order->estado_pago !== 'pendiente') {
                return;
            }

            $order->restockProducts();
            $order->update([
                'estado_pago' => 'cancelado',
            ]);
        });

        return redirect()
            ->back()
            ->with('success', 'Orden cancelada.');
    }
}
