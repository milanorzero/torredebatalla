<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("ALTER TABLE `orders` MODIFY `estado_pago` ENUM('pendiente','pagado','rechazado','cancelado') NOT NULL DEFAULT 'pendiente'");
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("ALTER TABLE `orders` MODIFY `estado_pago` ENUM('pendiente','pagado','rechazado') NOT NULL DEFAULT 'pendiente'");
    }
};
