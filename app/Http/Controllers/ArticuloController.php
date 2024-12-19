<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class ArticuloController extends Controller
{
    /**
     * Mostrar la lista de artículos.
     */
    public function index()
    {
        $articulos = Articulo::all();
        // return response()->json($articulos);
        return view('articulos.index', compact('articulos'));
    }

    /**
     * Mostrar el formulario para crear un nuevo artículo.
     */
    public function create()
    {
        return view('articulos.create');
    }

    /**
     * Guardar un nuevo artículo en la base de datos.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|unique:articulos,codigo',
            'nombre' => 'required',
            'valor_costo' => 'required|numeric',
            'valor_venta' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        if ($validator->fails()) {

            return redirect()->route('articulos.create')->with('error', 'Artículo no se pudo crear.');
        }


        Articulo::create($request->all());
        return redirect()->route('articulos.index')->with('success', 'Artículo se creó con exito.');
    }


    /**
     * Mostrar un artículo específico.
     */
    public function show(Articulo $articulo)
    {
        return view('articulos.show', compact('articulo'));
    }

    /**
     * Mostrar el formulario para editar un artículo.
     */
    public function edit(Articulo $articulo)
    {
        return view('articulos.edit', compact('articulo'));
    }

    /**
     * Actualizar un artículo en la base de datos.
     */
    public function update(Request $request, Articulo $articulo)
    {
        $request->validate([
            'codigo' => 'required|unique:articulos,codigo,' . $articulo->id,
            'nombre' => 'required',
            'valor_costo' => 'required|numeric',
            'valor_venta' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $articulo->update($request->all());

        return redirect()->route('articulos.index')->with('success', 'Artículo actualizado exitosamente.');
    }

    /**
     * Eliminar un artículo de la base de datos.
     */
    public function destroy(Articulo $articulo)
    {
        $articulo->delete();

        return redirect()->route('articulos.index')->with('success', 'Artículo eliminado exitosamente.');
    }
}
