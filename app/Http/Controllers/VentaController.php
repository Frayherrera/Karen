<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Articulo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VentaController extends Controller
{
    public function getArticulo(Request $request)
    {
        $articulo = Articulo::where('codigo', $request->codigo)->first();

        if ($articulo) {
            return response()->json([
                'success' => true,
                'nombre' => $articulo->nombre,
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Artículo no encontrado.']);
    }
   
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'nombre_cliente' => 'required|string|max:255', // Nueva regla de validación
            'direccion_cliente' => 'required|string|max:255', // Nueva regla de validación
            'cedula_cliente' => 'required|string|max:255', // Nueva regla de validación
            'telefono_cliente' => 'required|string|max:255', // Nueva regla de validación
            'articulos' => 'required|array',
            'articulos.*.codigo' => 'required|exists:articulos,codigo',
            'articulos.*.cantidad' => 'required|integer|min:1',
            'articulos.*.valor_unitario' => 'required|numeric|min:0',
            'tipo' => 'required|in:contado,credito',
            'dias_credito' => 'nullable|integer|min:1',
            'porcentaje_credito' => 'nullable|required_if:tipo,credito|integer|min:0|max:100',
            'descuento' => 'nullable|numeric|min:0',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('salida')->withErrors($validator)->withInput();
        }
    
        // Crear la venta en la tabla `ventas`
        $venta = Venta::create([
            'nombre_cliente' => $request->nombre_cliente, // Agregar el nombre del cliente
            'direccion_cliente' => $request->direccion_cliente, // Agregar el nombre del cliente
            'cedula_cliente' => $request->cedula_cliente, // Agregar el nombre del cliente
            'telefono_cliente' => $request->telefono_cliente, // Agregar el nombre del cliente

            'tipo' => $request->tipo,
            'dias_credito' => $request->tipo === 'credito' ? $request->dias_credito : null,
            'valor_total' => 0, // Valor total inicializado en 0, lo actualizaremos más tarde
            'utilidad' => 0, // Utilidad inicializada en 0, la actualizaremos más tarde
            'fecha_venta' => now(),
        ]);
    
        $valor_total = 0;
        $utilidad_total = 0;
    
        foreach ($request->articulos as $articuloData) {
            $articulo = Articulo::where('codigo', $articuloData['codigo'])->first();
    
            if ($articulo->stock < $articuloData['cantidad']) {
                return redirect()->back()->withErrors(['error' => 'Stock insuficiente para el artículo: ' . $articulo->nombre]);
            }
    
            $valor_articulo = $articuloData['cantidad'] * $articuloData['valor_unitario'];
            $utilidad_articulo = (($articuloData['valor_unitario'] - $articulo->valor_costo) * $articuloData['cantidad']) - ($articuloData['descuento'] ?? 0);
    
            $valor_total += $valor_articulo;
            $utilidad_total += $utilidad_articulo;
    
            // Reducir el stock del artículo
            $articulo->stock -= $articuloData['cantidad'];
            $articulo->save();
    
            // Guardar cada artículo vendido en la tabla pivot
            \DB::table('articulo_venta')->insert([
                'venta_id' => $venta->id,
                'articulo_id' => $articulo->id,
                'cantidad' => $articuloData['cantidad'],
                'valor_unitario' => $articuloData['valor_unitario'],
                'descuento' => $articuloData['descuento'] ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
        // Agregar porcentaje adicional si la venta es a crédito
        if ($request->tipo === 'credito') {
            $porcentaje_adicional = ($valor_total * $request->porcentaje_credito) / 100;
            $valor_total += $porcentaje_adicional;
            $utilidad_total += $porcentaje_adicional;
        }
    
        // Restar descuento si se aplica
        $valor_total -= $request->descuento ?? 0;
    
        // Actualizar la venta con los valores finales
        $venta->update([
            'valor_total' => $valor_total,
            'utilidad' => $utilidad_total,
        ]);
    
        return redirect()->route('ventas.index')->with('success', 'Venta exitosa. Código de venta: ' . $venta->id);
    }
    
    
    public function generarTicket($id)
    {
        $venta = Venta::findOrFail($id);
        $articulos = $venta->articulos; // Obtener todos los artículos asociados a la venta
    
        $pdf = Pdf::loadView('tickets.ticket', compact('venta', 'articulos'));
    
        // Descargar el ticket como PDF
        return $pdf->stream('ticket-venta-' . $venta->id . '.pdf');
    }
    

    public function index(Request $request)
{
    $query = $request->input('search');
    
    $ventas = Venta::when($query, function($q) use ($query) {
            $q->where('id', 'like', "%{$query}%");
        })
        ->orderBy('fecha_venta', 'desc')
        ->paginate(9);
        
    if ($request->ajax()) {
        return view('ventas.partials.ventas-table', compact('ventas'))->render();
    }
    
    return view('ventas.index', compact('ventas'));
}
}
