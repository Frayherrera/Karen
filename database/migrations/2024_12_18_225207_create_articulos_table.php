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
            $table->text('nombre'); // Nombre del artículo
            $table->text('descripcion')->nullable(); // Descripción opcional
            $table->decimal('valor_costo', 10); // Valor de costo
            $table->integer('valor_venta'); // Valor de venta
            $table->integer('stock')->default(0); // Stock inicial (por defecto 0)
            $table->timestamps(); // Marcas de tiempo (creado y actualizado)
            $table->foreignId('categoria_id')
            ->constrained('categorias') // Relación con la tabla `categorias`
            ->onDelete('cascade') // Elimina artículos si se elimina la categoría
            ->nullable(); // Permitir artículos sin categoría inicial
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
