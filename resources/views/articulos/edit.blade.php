<!-- Vista: Editar (articulos.edit) -->
@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold text-center my-6">Editar Artículo</h1>
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                <strong>¡Error!</strong> Por favor corrige los siguientes errores:
                <ul class="mt-2">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('articulos.update', $articulo->id) }}" method="POST" class="bg-white p-6 rounded shadow-md">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="codigo" class="block text-sm font-medium text-gray-700">Código</label>
                <input type="text" name="codigo" id="codigo" value="{{ old('codigo', $articulo->codigo) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $articulo->nombre) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Categoria</label>
                <select required name="categoria_id" id="categoria_id" 
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <option value="" disabled selected>Selecciona una categoría</option>
            @foreach($categorias as $categoria)
                <option required value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
            @endforeach
        </select>
            </div>
            <div class="mb-6">
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    placeholder="Opcional: ingrese una breve descripción del artículo">{{ old('descripcion', $articulo->descripcion ?? '') }}</textarea>
            </div>


            <div class="mb-4">
                <label for="valor_costo" class="block text-sm font-medium text-gray-700">Valor Costo</label>
                <input type="number" name="valor_costo" id="valor_costo"
                    value="{{ old('valor_costo', $articulo->valor_costo) }}" step="0.01"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="valor_venta" class="block text-sm font-medium text-gray-700">Valor Venta</label>
                <input type="number" name="valor_venta" id="valor_venta"
                    value="{{ old('valor_venta', $articulo->valor_venta) }}" step="0.01"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                <input type="number" name="stock" id="stock" value="{{ old('stock', $articulo->stock) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex justify-end">
                <a href="{{ route('articulos.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 rounded mr-2">Cancelar</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">Guardar</button>
            </div>
        </form>
    </div>
@endsection
