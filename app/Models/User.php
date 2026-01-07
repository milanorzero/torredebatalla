<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'points_balance',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* ===============================
     |  RELACIONES
     =============================== */

    public function pointTransactions()
    {
        return $this->hasMany(PointTransaction::class);
    }

    /* ===============================
     |  MÉTODOS DE PUNTOS
     =============================== */

    public function hasEnoughPoints(int $points): bool
    {
        return $this->points_balance >= $points;
    }

    public function addPoints(
        int $points,
        string $reason,
        string $channel = 'admin',
        ?int $referenceId = null
    ): void {
        $this->increment('points_balance', $points);

        $this->pointTransactions()->create([
            'type'         => 'earned',
            'points'       => $points,
            'reason'       => $reason,
            'channel'      => $channel,
            'reference_id' => $referenceId,
        ]);
    }

    public function spendPoints(
        int $points,
        string $reason,
        string $channel = 'web',
        ?int $referenceId = null
    ): void {
        if (!$this->hasEnoughPoints($points)) {
            throw new \Exception('Puntos insuficientes');
        }

        $this->decrement('points_balance', $points);

        $this->pointTransactions()->create([
            'type'         => 'spent',
            'points'       => $points,
            'reason'       => $reason,
            'channel'      => $channel,
            'reference_id' => $referenceId,
        ]);
    }
}
