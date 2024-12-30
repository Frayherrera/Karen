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
        'categoria_id',
    ];

    public function getPorcentajeUtilidadAttribute()
    {
        return (($this->valor_venta - $this->valor_costo) / $this->valor_costo) * 100;
    }
    public function entradas()
    {
        return $this->hasMany(Entrada::class, 'codigo', 'codigo');
    }

    public function ventas()
    {
        return $this->belongsToMany(Venta::class, 'articulo_venta')->withPivot('cantidad', 'valor_unitario', 'descuento')->withTimestamps();
    }
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
