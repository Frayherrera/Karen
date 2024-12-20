<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use App\Models\Articulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EntradaController extends Controller
{
    /**
     * Mostrar la lista de entradas.
     */
    public function index()
    {
        $entradas = Entrada::with('articulo')->orderBy('fecha_ingreso', 'desc')->paginate(10);
        return view('entradas.index', compact('entradas'));
    }

    /**
     * Mostrar el formulario para registrar una nueva entrada.
     */
    public function create()
    {
        $articulos = Articulo::all(); // Obtener todos los artículos
        return view('entradas.create', compact('articulos'));
    }

    /**
     * Registrar una nueva entrada.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|exists:articulos,codigo',
            'cantidad' => 'required|integer|min:1',
            'valor_costo' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->route('entradas.create')->withErrors($validator)->withInput();
        }

        // Registrar la entrada
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

        return redirect()->route('entradas.index')->with('success', 'Entrada registrada exitosamente.');
    }

    /**
     * Mostrar los detalles de una entrada específica.
     */
    public function show($id)
    {
        $entrada = Entrada::with('articulo')->findOrFail($id);
        return view('entradas.show', compact('entrada'));
    }

    /**
     * Eliminar una entrada.
     */
    public function destroy($id)
    {
        $entrada = Entrada::findOrFail($id);

        // Restar la cantidad al stock del artículo antes de eliminar
        $articulo = Articulo::where('codigo', $entrada->codigo)->first();
        if ($articulo) {
            $articulo->stock -= $entrada->cantidad;
            $articulo->save();
        }

        $entrada->delete();
        return redirect()->route('entradas.index')->with('success', 'Entrada eliminada exitosamente.');
    }
}
