<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('slider_items', function (Blueprint $table) {
            $table->id();
            $table->string('image'); // nombre del archivo de la imagen
            $table->string('text')->nullable(); // texto que acompaña la imagen
            $table->integer('order')->default(0); // para ordenar el slider
            $table->boolean('active')->default(true); // para activar/desactivar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slider_items');
    }
};
