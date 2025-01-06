<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';

    /**
     * Campos asignables en el modelo.
     */
    protected $fillable = [
        'codigo',         // Código del producto
        'nombre_cliente',
        'cantidad',       // Cantidad vendida
        'valor_unitario', // Precio unitario
        'valor_total',    // Precio total
        'descuento',      // Descuento aplicado (opcional)
        'tipo',           // Tipo de venta (contado o crédito)
        'dias_credito',   // Días de crédito (opcional)
        'fecha_venta',    // Fecha de la venta
        'utilidad'
    ];

    /**
     * Relación: Una venta pertenece a un artículo.
     */
    public function articulos()
    {
        return $this->belongsToMany(Articulo::class, 'articulo_venta')->withPivot('cantidad', 'valor_unitario', 'descuento')->withTimestamps();
    }
}
