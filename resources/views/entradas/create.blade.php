@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold text-center my-6">Registrar Entrada de Producto</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">¡Error!</strong>
            <span class="block sm:inline">Por favor corrige los siguientes problemas:</span>
            <ul class="mt-2">
                @foreach ($errors->all() as $error)
                    <li class="ml-4 list-disc">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('entradas.store') }}" method="POST" class="max-w-lg mx-auto bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="codigo">Código del Producto</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                   id="codigo" 
                   name="codigo" 
                   type="text" 
                   placeholder="Código del producto" 
                   value="{{ old('codigo') }}" 
                   required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="cantidad">Cantidad</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                   id="cantidad" 
                   name="cantidad" 
                   type="number" 
                   placeholder="Cantidad" 
                   value="{{ old('cantidad') }}" 
                   required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="valor_costo">Valor de Costo</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                   id="valor_costo" 
                   name="valor_costo" 
                   type="number" 
                   step="0.01" 
                   placeholder="Valor de costo" 
                   value="{{ old('valor_costo') }}" 
                   required>
        </div>

        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                    type="submit">
                Registrar Entrada
            </button>
            <a href="{{ route('entradas.index') }}" 
               class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
