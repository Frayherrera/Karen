<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Articulo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VentaController extends Controller
{
    public function create()
    {
        // Obtener el último ID y sumarle 1
        $lastId = Venta::max('id');
        $nextId = $lastId ? $lastId + 1 : 1;

        return view('ventas.create', compact('nextId'));
    }
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
    public function cambiarEstado($id)
    {
        $venta = Venta::find($id);
        if ($venta->estado === 'pagado') {
            $venta->estado = 'no pagado';
        } else {
            $venta->estado = 'pagado';
        }
        $venta->save();
        return response()->json(['success' => true]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_cliente' => 'required|string|max:255',
            'direccion_cliente' => 'required|string|max:255',
            'cedula_cliente' => 'required|string|max:255',
            'telefono_cliente' => 'required|string|max:255',
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
            'nombre_cliente' => $request->nombre_cliente,
            'direccion_cliente' => $request->direccion_cliente,
            'cedula_cliente' => $request->cedula_cliente,
            'telefono_cliente' => $request->telefono_cliente,
            'tipo' => $request->tipo,
            'dias_credito' => $request->tipo === 'credito' ? $request->dias_credito : null,
            'porcentaje_credito' => $request->tipo === 'credito' ? $request->porcentaje_credito : 0,
            'valor_total' => 0,
            'subtotal' => 0,
            'valor_credito' => 0,
            'utilidad' => 0,
            'fecha_venta' => now(),
        ]);

        $subtotal = 0;
        $utilidad_total = 0;

        foreach ($request->articulos as $articuloData) {
            $articulo = Articulo::where('codigo', $articuloData['codigo'])->first();

            if ($articulo->stock < $articuloData['cantidad']) {
                return redirect()->back()->withErrors(['error' => 'Stock insuficiente para el artículo: ' . $articulo->nombre]);
            }

            $valor_articulo = $articuloData['cantidad'] * $articuloData['valor_unitario'];
            $valor_articulo -= $articuloData['descuento'] ?? 0;
            $utilidad_articulo = (($articuloData['valor_unitario'] - $articulo->valor_costo) * $articuloData['cantidad']) - ($articuloData['descuento'] ?? 0);

            $subtotal += $valor_articulo;
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

        // Calcular valor del crédito si aplica
        $valor_credito = 0;
        if ($request->tipo === 'credito') {
            $valor_credito = ($subtotal * $request->porcentaje_credito) / 100;
            $utilidad_total += $valor_credito;
        }

        // Calcular valor total
        $valor_total = $subtotal + $valor_credito;

        // Actualizar la venta con los valores finales
        $venta->update([
            'subtotal' => $subtotal,
            'valor_credito' => $valor_credito,
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

        $ventas = Venta::when($query, function ($q) use ($query) {
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
