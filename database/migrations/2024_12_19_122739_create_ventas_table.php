<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Ejecutar la migración.
     */
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_cliente'); // Nombre del cliente
            $table->string('direccion_cliente'); // Nombre del cliente
            $table->string('telefono_cliente'); // Nombre del cliente
            $table->string('cedula_cliente'); // Nombre del cliente
            $table->string('codigo')->index();       // Código del producto (relacionado con artículos)
            $table->integer('cantidad');            // Cantidad vendida
            $table->decimal('valor_unitario', 10, 2); // Precio unitario
            $table->decimal('valor_total', 10, 2);  // Precio total
            $table->decimal('descuento', 10, 2)->nullable(); // Descuento opcional
            $table->enum('tipo', ['contado', 'credito']);    // Tipo de venta
            $table->integer('dias_credito')->nullable();     // Días de crédito (solo para crédito)
            $table->timestamp('fecha_venta');       // Fecha de la venta
            $table->timestamps();
        });
    }

    /**
     * Revertir la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
}
