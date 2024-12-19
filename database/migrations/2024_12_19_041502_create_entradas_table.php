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
        Schema::create('entradas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->index(); // Código del producto
            $table->integer('cantidad'); // Cantidad de ingreso
            $table->decimal('valor_costo', 10, 2); // Costo por unidad
            $table->timestamp('fecha_ingreso'); // Fecha de ingreso
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entradas');
    }
};
