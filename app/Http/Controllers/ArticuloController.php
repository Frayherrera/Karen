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
        $query = $request->input('q');
        $articulos = Articulo::when($query, function ($q) use ($query) {
            $q->where('nombre', 'like', "%{$query}%")
                ->orWhere('codigo', 'like', "%{$query}%");
        })->paginate(10);

        if ($request->ajax()) {
            return view('articulos.partials.articulos-table', compact('articulos'))->render();
        }
        return view('articulos.index', compact('articulos', 'query'));
    }

    /**
     * Validar si existe el código del artículo
     */
    public function verificarCodigo(Request $request)
    {
        $codigo = $request->input('codigo');
        $articuloId = $request->input('articulo_id');

        $query = Articulo::where('codigo', $codigo);

        if ($articuloId) {
            $query->where('id', '!=', $articuloId);
        }

        $existe = $query->exists();

        return response()->json([
            'existe' => $existe,
            'mensaje' => $existe ? '¡Este código ya está siendo usado!' : 'Código disponible para usar.'
        ]);
    }

    /**
     * Filtrar artículos
     */
    public function filter(Request $request)
    {
        $query = $request->input('q');
        $articulos = Articulo::when($query, function ($q) use ($query) {
            $q->where('nombre', 'like', "%{$query}%")
                ->orWhere('codigo', 'like', "%{$query}%");
        })->get();

        return response()->json($articulos);
    }

    /**
     * Mostrar el formulario para crear un nuevo artículo.
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('articulos.create', compact('categorias'));
    }

    /**
     * Guardar un nuevo artículo en la base de datos.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|unique:articulos,codigo|max:10',
            'nombre' => 'required|max:50',
            'valor_costo' => 'required|numeric|min:0',
            'valor_venta' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'descripcion' => 'nullable|string|max:500',
            'categoria_id' => 'required|exists:categorias,id',
        ], [
            'codigo.unique' => 'Este código ya está siendo usado.',
            'codigo.required' => 'El campo código es obligatorio.',
            'codigo.max' => 'El código no puede tener más de 10 caracteres.',
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 15 caracteres.',
            'valor_costo.required' => 'El campo valor costo es obligatorio.',
            'valor_costo.numeric' => 'El valor costo debe ser un número.',
            'valor_costo.min' => 'El valor costo no puede ser negativo.',
            'valor_venta.required' => 'El campo valor venta es obligatorio.',
            'valor_venta.numeric' => 'El valor venta debe ser un número.',
            'valor_venta.min' => 'El valor venta no puede ser negativo.',
            'stock.required' => 'El campo stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock no puede ser negativo.',
            'descripcion.max' => 'La descripción no puede tener más de 500 caracteres.',
            'categoria_id.required' => 'Debe seleccionar una categoría.',
            'categoria_id.exists' => 'La categoría seleccionada no es válida.',
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
    public function obtenerValor($id)
    {
        $articulo = Articulo::find($id);
        if ($articulo) {
            return response()->json(['valor_unitario' => $articulo->valor_unitario]);
        } else {
            return response()->json(['error' => 'Artículo no encontrado'], 404);
        }
    }
    /**
     * Mostrar el formulario para editar un artículo.
     */
    public function edit($id)
    {
        $articulo = Articulo::findOrFail($id);
        $categorias = Categoria::all();
        return view('articulos.edit', compact('articulo', 'categorias'));
    }

    /**
     * Actualizar un artículo en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|unique:articulos,codigo,' . $id,
            'nombre' => 'required|max:50',
            'descripcion' => 'nullable|string|max:500',
            'valor_costo' => 'required|numeric|min:0',
            'valor_venta' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
        ], [
            'codigo.required' => 'El código del artículo es obligatorio.',
            'codigo.unique' => 'Este código ya está en uso por otro artículo.',
            'nombre.required' => 'El nombre del artículo es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 15 caracteres.',
            'descripcion.max' => 'La descripción no puede tener más de 500 caracteres.',
            'valor_costo.required' => 'El valor de costo es obligatorio.',
            'valor_costo.numeric' => 'El valor de costo debe ser un número.',
            'valor_costo.min' => 'El valor de costo no puede ser negativo.',
            'valor_venta.required' => 'El valor de venta es obligatorio.',
            'valor_venta.numeric' => 'El valor de venta debe ser un número.',
            'valor_venta.min' => 'El valor de venta no puede ser negativo.',
            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock no puede ser negativo.',
            'categoria_id.required' => 'La categoría es obligatoria.',
            'categoria_id.exists' => 'La categoría seleccionada no es válida.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('articulos.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $articulo = Articulo::findOrFail($id);
            $articulo->update($request->all());

            return redirect()
                ->route('articulos.index')
                ->with('success', 'Artículo actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('articulos.edit', $id)
                ->with('error', 'Error al actualizar el artículo. Por favor, intente nuevamente.')
                ->withInput();
        }
    }

    /**
     * Eliminar un artículo de la base de datos.
     */
    public function destroy(Articulo $articulo)
    {
        try {
            $articulo->delete();
            return redirect()
                ->route('articulos.index')
                ->with('success', 'Artículo eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('articulos.index')
                ->with('error', 'Error al eliminar el artículo. Por favor, intente nuevamente.');
        }
    }

    public function obtenerArticulo($id)
    {
        $articulo = Articulo::find($id);
        if ($articulo) {
            return response()->json(['nombre' => $articulo->nombre, 'valor_venta' => $articulo->valor_venta,]);
        } else {
            return response()->json(['error' => 'Artículo no encontrado'], 404);
        }
    }
    
    public function obtenerArticuloPorCodigo($codigo)
    {
        $articulo = Articulo::where('codigo', $codigo)->first();
        if ($articulo) {
            return response()->json([
                'success' => true,
                'nombre' => $articulo->nombre, 
                'valor_venta' => $articulo->valor_venta,
                'stock' => $articulo->stock
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Artículo no encontrado'
            ], 404);
        }
    }
}
