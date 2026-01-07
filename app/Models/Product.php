<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_title',
        'product_description',
        'product_quantity',
        'product_price',
        'offer_price',
        'is_on_offer',
        'product_image',
        'product_category',

        
        'sale_channel', // web | store | both
    ];

    protected $appends = ['final_price'];

    /* ============================
     | PRECIOS
     |============================ */

    public function getFinalPriceAttribute()
    {
        return $this->is_on_offer && $this->offer_price
            ? $this->offer_price
            : $this->product_price;
    }

    /* ============================
     | CANALES DE VENTA
     |============================ */

    public function isWeb(): bool
    {
        return in_array($this->sale_channel, ['web', 'both']);
    }

    public function isStore(): bool
    {
        return in_array($this->sale_channel, ['store', 'both']);
    }
}
