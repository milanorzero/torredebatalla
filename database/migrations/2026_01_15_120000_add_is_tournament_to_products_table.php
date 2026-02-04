<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('products', 'is_tournament')) {
            Schema::table('products', function (Blueprint $table) {
                $table->boolean('is_tournament')
                    ->default(false)
                    ->after('product_category');
            });
        }
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('is_tournament');
        });
    }
};
