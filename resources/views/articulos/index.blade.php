<!-- Vista: Index (articulos.index) -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold text-center my-6">Lista de Artículos</h1>
    <a href="{{ route('articulos.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-6 inline-block">Nuevo Artículo</a>
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414l2.934 2.934-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414l-2.934-2.934 2.934-2.934a1 1 0 000-1.414z"/></svg>
            </span>
        </div>
    @endif
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Código</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nombre</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Valor Costo</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Valor Venta</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Stock</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Estado del Stock</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($articulos as $articulo)
                <tr class="hover:bg-gray-100">
                    <td class="py-4 px-6">{{ $articulo->codigo }}</td>
                    <td class="py-4 px-6">{{ $articulo->nombre }}</td>
                    <td class="py-4 px-6">${{ number_format($articulo->valor_costo, 2) }}</td>
                    <td class="py-4 px-6">${{ number_format($articulo->valor_venta, 2) }}</td>
                    <td class="py-4 px-6">{{ $articulo->stock }}</td>
                    <td class="py-4 px-6">
                        @if($articulo->stock > 15)
                            <span class="inline-block px-2 py-1 text-xs font-semibold text-green-700 bg-green-200 rounded-full">Sobrante</span>
                        @elseif($articulo->stock <= 15 && $articulo->stock >= 4)
                            <span class="inline-block px-2 py-1 text-xs font-semibold text-yellow-700 bg-yellow-200 rounded-full">Poco Stock</span>
                        @else
                            <span class="inline-block px-2 py-1 text-xs font-semibold text-red-700 bg-red-200 rounded-full">Comprar Ya</span>
                        @endif
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex space-x-2">
                            <a href="{{ route('articulos.show', $articulo->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-xs">Ver</a>
                            <a href="{{ route('articulos.edit', $articulo->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded text-xs">Editar</a>
                            <form action="{{ route('articulos.destroy', $articulo->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
