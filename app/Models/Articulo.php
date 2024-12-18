<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'valor_costo',
        'valor_venta',
        'stock',
    ];

    public function getPorcentajeUtilidadAttribute()
    {
        return (($this->valor_venta - $this->valor_costo) / $this->valor_costo) * 100;
    }
}
