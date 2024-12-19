<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Articulo;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|exists:articulos,codigo',
            'cantidad' => 'required|integer|min:1',
            'valor_unitario' => 'required|numeric|min:0',
            'tipo' => 'required|in:contado,credito',
            'dias_credito' => 'nullable|required_if:tipo,credito|integer|min:1',
        ]);

        $articulo = Articulo::where('codigo', $request->codigo)->first();

        if ($articulo->stock < $request->cantidad) {
            return redirect()->back()->withErrors(['error' => 'Stock insuficiente.']);
        }

        $valor_total = $request->cantidad * $request->valor_unitario;
        $venta = Venta::create([
            'codigo' => $request->codigo,
            'cantidad' => $request->cantidad,
            'valor_unitario' => $request->valor_unitario,
            'valor_total' => $valor_total,
            'descuento' => $request->descuento ?? 0,
            'tipo' => $request->tipo,
            'dias_credito' => $request->tipo === 'credito' ? $request->dias_credito : null,
            'fecha_venta' => now(),
        ]);

        // Actualizar stock del artículo
        $articulo->stock -= $request->cantidad;
        $articulo->save();

        return redirect()->back()->with('success', 'Venta registrada exitosamente.');
    }
}
