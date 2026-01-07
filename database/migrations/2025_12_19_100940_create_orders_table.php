<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Usuario (opcional)
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            // ¿Compra como invitado?
            $table->boolean('is_guest')->default(true);

            // Datos comprador
            $table->string('email');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('telefono');
            $table->string('documento');

            // Envío
            $table->enum('tipo_envio', ['despacho', 'retiro']);
            $table->string('comuna')->nullable();
            $table->string('calle')->nullable();
            $table->string('numero')->nullable();
            $table->string('extra')->nullable(); // dpto / indicaciones
            $table->string('codigo_postal')->nullable();
            $table->string('local_retiro')->nullable();

            // Pago
            $table->enum('metodo_pago', [
                'transferencia',
                'webpay',
                'mercadopago'
            ])->nullable();

            $table->enum('estado_pago', [
                'pendiente',
                'pagado',
                'rechazado'
            ])->default('pendiente');

            // Totales
            $table->integer('subtotal');
            $table->integer('total');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};