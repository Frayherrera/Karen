<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVentasTable extends Migration
{
    public function up()
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropColumn('codigo');
            $table->dropColumn('cantidad');
            $table->dropColumn('valor_unitario');
            $table->dropColumn('descuento');
        });
    }

    public function down()
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->string('codigo');
            $table->integer('cantidad');
            $table->decimal('valor_unitario', 8, 2);
            $table->decimal('descuento', 8, 2)->nullable();
        });
    }
}

