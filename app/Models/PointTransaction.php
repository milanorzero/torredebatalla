<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'points',
        'reason',
        'channel',
        'reference_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
