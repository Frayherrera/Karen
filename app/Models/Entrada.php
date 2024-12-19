<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    use HasFactory;

    protected $table = 'entradas';

    /**
     * Campos asignables en el modelo.
     */
    protected $fillable = [
        'codigo',         // Código del producto
        'cantidad',       // Cantidad ingresada
        'valor_costo',    // Costo unitario del producto
        'fecha_ingreso',  // Fecha de ingreso
    ];

    /**
     * Relación: Una entrada pertenece a un artículo.
     */
    public function articulo()
    {
        return $this->belongsTo(Articulo::class, 'codigo', 'codigo');
    }
}
