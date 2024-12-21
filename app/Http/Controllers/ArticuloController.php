<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Categoria;
use Illuminate\Support\Facades\Validator;


use Illuminate\Http\Request;

class ArticuloController extends Controller
{
    /**
     * Mostrar la lista de artículos.
     */
    public function index(Request $request)
    {
        $query = $request->input('q'); // Obtén el término de búsqueda
        $articulos = Articulo::when($query, function ($q) use ($query) {
            $q->where('nombre', 'like', "%{$query}%")
                ->orWhere('codigo', 'like', "%{$query}%");
        })->paginate(10); // Pagina los resultados

        if ($request->ajax()) {
            return view('articulos.partials.articulos-table', compact('articulos'))->render();
        }
        return view('articulos.index', compact('articulos', 'query'));
    }

    public function filter(Request $request)
    {
        $query = $request->input('q'); // Obtiene el término de búsqueda
        $articulos = Articulo::when($query, function ($q) use ($query) {
            $q->where('nombre', 'like', "%{$query}%")
                ->orWhere('codigo', 'like', "%{$query}%");
        })->get();

        return response()->json($articulos); // Devuelve los resultados en formato JSON
    }

    /**
     * Mostrar el formulario para crear un nuevo artículo.
     */
    public function create()

    {

        $categorias = Categoria::all(); // Obtén todas las categorías
        return view('articulos.create', compact('categorias'));
    }

    /**
     * Guardar un nuevo artículo en la base de datos.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|unique:articulos,codigo|max:10',
            'nombre' => 'required|max:15',
            'valor_costo' => 'required|numeric',
            'valor_venta' => 'required|numeric',
            'stock' => 'required|integer',
            'descripcion' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->route('articulos.create')->withErrors($validator)->withInput();
        }

        Articulo::create($request->all());
        return redirect()->route('articulos.index')->with('success', 'Artículo creado con éxito.');
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
    public function edit($id)
    {
        $articulo = Articulo::findOrFail($id);
        $categorias = Categoria::all(); // Suponiendo que tienes un modelo Categoría
        return view('articulos.edit', compact('articulo', 'categorias'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'codigo' => 'required|unique:articulos,codigo,' . $id, // Permite que el código sea único excepto para el actual.
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'valor_costo' => 'required|numeric|min:0',
            'valor_venta' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'nullable|exists:categorias,id', // Verifica si la categoría existe.
        ]);
    
        // Encuentra el artículo por ID
        $articulo = Articulo::findOrFail($id);
    
        // Actualiza los datos del artículo
        $articulo->update([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'valor_costo' => $request->valor_costo,
            'valor_venta' => $request->valor_venta,
            'stock' => $request->stock,
            'categoria_id' => $request->categoria_id,
        ]);
    
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
