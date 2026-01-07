<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_guest',
        'buy_order',      
        'webpay_token',
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
}