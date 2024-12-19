<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use App\Models\Articulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EntradaController extends Controller
{
    public function store(Request $request)
    {
        
        

        $validator = Validator::make($request->all(), [
            'codigo' => 'required|exists:articulos,codigo',
            'cantidad' => 'required|integer|min:1',
            'valor_costo' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->route('entrada')->withErrors($validator)->withInput();
        }

        $entrada = Entrada::create([
            'codigo' => $request->codigo,
            'cantidad' => $request->cantidad,
            'valor_costo' => $request->valor_costo,
            'fecha_ingreso' => now(),
        ]);

        // Actualizar stock del artículo
        $articulo = Articulo::where('codigo', $request->codigo)->first();
        $articulo->stock += $request->cantidad;
        $articulo->save();

        return redirect()->route('articulos.index')->with('success', 'Entrada registrada exitosamente.');

    }
}
