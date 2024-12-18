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
        Schema::create('articulos', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->string('codigo')->unique(); // Código único para el artículo
            $table->string('nombre'); // Nombre del artículo
            $table->text('descripcion')->nullable(); // Descripción opcional
            $table->decimal('valor_costo', 10, 2); // Valor de costo
            $table->decimal('valor_venta', 10, 2); // Valor de venta
            $table->integer('stock')->default(0); // Stock inicial (por defecto 0)
            $table->timestamps(); // Marcas de tiempo (creado y actualizado)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articulos');
    }
};
