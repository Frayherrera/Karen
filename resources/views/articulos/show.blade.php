@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Detalle del Artículo</h1>
    <div class="bg-white shadow rounded-lg p-6">
        <table class="table-auto w-full border-collapse border border-gray-300">
            <tbody>
                <tr>
                    <th class="text-left px-4 py-2 font-semibold text-gray-600 border-b border-gray-200">Código:</th>
                    <td class="px-4 py-2 border-b border-gray-200 text-gray-700">{{ $articulo->codigo }}</td>
                </tr>
                <tr>
                    <th class="text-left px-4 py-2 font-semibold text-gray-600 border-b border-gray-200">Nombre:</th>
                    <td class="px-4 py-2 border-b border-gray-200 text-gray-700">{{ $articulo->nombre }}</td>
                </tr>
                <tr>
                    <th class="text-left px-4 py-2 font-semibold text-gray-600 border-b border-gray-200">Descripción:</th>
                    <td class="px-4 py-2 border-b border-gray-200 text-gray-700">{{ $articulo->descripcion }}</td>
                </tr>
                <tr>
                    <th class="text-left px-4 py-2 font-semibold text-gray-600 border-b border-gray-200">Valor Costo:</th>
                    <td class="px-4 py-2 border-b border-gray-200 text-gray-700">${{ number_format($articulo->valor_costo, 2) }}</td>
                </tr>
                <tr>
                    <th class="text-left px-4 py-2 font-semibold text-gray-600 border-b border-gray-200">Valor Venta:</th>
                    <td class="px-4 py-2 border-b border-gray-200 text-gray-700">${{ number_format($articulo->valor_venta, 2) }}</td>
                </tr>
                <tr>
                    <th class="text-left px-4 py-2 font-semibold text-gray-600 border-b border-gray-200">Stock:</th>
                    <td class="px-4 py-2 border-b border-gray-200 text-gray-700">{{ $articulo->stock }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        <a href="{{ route('articulos.index') }}" 
           class="inline-block bg-gray-600 hover:bg-gray-800 text-white font-semibold py-2 px-4 rounded-md">
           Volver
        </a>
    </div>
</div>
@endsection
