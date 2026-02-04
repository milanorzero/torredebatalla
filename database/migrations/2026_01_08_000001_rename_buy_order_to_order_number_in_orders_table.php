<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('orders', 'buy_order') || Schema::hasColumn('orders', 'order_number')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            // Keeps existing indexes/constraints in place on MySQL/MariaDB.
            DB::statement('ALTER TABLE `orders` CHANGE `buy_order` `order_number` VARCHAR(255) NOT NULL');
            return;
        }

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE orders RENAME COLUMN buy_order TO order_number');
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('buy_order', 'order_number');
        });
    }

    public function down(): void
    {
        if (!Schema::hasColumn('orders', 'order_number') || Schema::hasColumn('orders', 'buy_order')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement('ALTER TABLE `orders` CHANGE `order_number` `buy_order` VARCHAR(255) NOT NULL');
            return;
        }

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE orders RENAME COLUMN order_number TO buy_order');
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('order_number', 'buy_order');
        });
    }
};
