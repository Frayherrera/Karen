<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Articulo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VentaController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|exists:articulos,codigo',
            'cantidad' => 'required|integer|min:1',
            'valor_unitario' => 'required|numeric|min:0',
            'tipo' => 'required|in:contado,credito',
            'dias_credito' => 'nullable|required_if:tipo,credito|integer|min:1',
            'porcentaje_credito' => 'nullable|required_if:tipo,credito|integer|min:0|max:100',
            'descuento' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->route('salida')->withErrors($validator)->withInput();
        }
        
    
        $articulo = Articulo::where('codigo', $request->codigo)->first();
    
        if ($articulo->stock < $request->cantidad) {
            return redirect()->back()->withErrors(['error' => 'Stock insuficiente.']);
        }
    
        // Calcular el valor total
        $valor_total = $request->cantidad * $request->valor_unitario;
    
        // Agregar porcentaje adicional si la venta es a crédito
        if ($request->tipo === 'credito') {
            $porcentaje_adicional = ($valor_total * $request->porcentaje_credito) / 100;
            $valor_total += $porcentaje_adicional;
        }
    
        // Restar descuento si se aplica
        $valor_total -= $request->descuento ?? 0;
    
        // Calcular utilidad
        $utilidad = (($request->valor_unitario - $articulo->valor_costo) * $request->cantidad) 
                    + ($request->tipo === 'credito' ? $porcentaje_adicional ?? 0 : 0) 
                    - $request->descuento;
    
        // Crear la venta
        $venta = Venta::create([
            'codigo' => $request->codigo,
            'cantidad' => $request->cantidad,
            'valor_unitario' => $request->valor_unitario,
            'valor_total' => $valor_total,
            'descuento' => $request->descuento ?? 0,
            'tipo' => $request->tipo,
            'dias_credito' => $request->tipo === 'credito' ? $request->dias_credito : null,
            'fecha_venta' => now(),
            'utilidad' => $utilidad,
        ]);
    
        // Actualizar stock del artículo
        $articulo->stock -= $request->cantidad;
        $articulo->save();
        return redirect()->route('salida')->with('success', 'Venta exitosa.');

    }
    
    public function generarTicket($id)
    {
        $venta = Venta::findOrFail($id);
        $articulo = Articulo::where('codigo', $venta->codigo)->first();

        $pdf = Pdf::loadView('tickets.ticket', compact('venta', 'articulo'));

        // Descargar el ticket como PDF
        return $pdf->stream('ticket-venta-' . $venta->id . '.pdf');
    }
    public function index()
    {
        $ventas = Venta::orderBy('fecha_venta', 'desc')->paginate(10); // Ordenar y paginar
        return view('ventas.index', compact('ventas'));
    }
}
