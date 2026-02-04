<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_guest',
        'order_number',
        'email',
        'nombres',
        'apellidos',
        'telefono',
        'documento',
        'tipo_envio',
        'comuna',
        'calle',
        'numero',
        'extra',
        'codigo_postal',
        'local_retiro',
        'metodo_pago',
        'estado_pago',
        'payment_proof',
        'subtotal',
        'points_used',
        'total',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function restockProducts(): void
    {
        DB::transaction(function (): void {
            $this->loadMissing('items.product');

            foreach ($this->items as $item) {
                if (!$item->product) {
                    continue;
                }

                // Si el producto no maneja stock (null), no ajustar.
                if (is_null($item->product->product_quantity)) {
                    continue;
                }

                $item->product->increment('product_quantity', (int) $item->quantity);
            }
        });
    }
}