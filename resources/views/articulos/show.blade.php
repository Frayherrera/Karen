@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalle del Artículo</h1>
    <table class="table table-bordered">
        <tr>
            <th>Código:</th>
            <td>{{ $articulo->codigo }}</td>
        </tr>
        <tr>
            <th>Nombre:</th>
            <td>{{ $articulo->nombre }}</td>
        </tr>
        <tr>
            <th>Descripción:</th>
            <td>{{ $articulo->descripcion }}</td>
        </tr>
        <tr>
            <th>Valor Costo:</th>
            <td>{{ $articulo->valor_costo }}</td>
        </tr>
        <tr>
            <th>Valor Venta:</th>
            <td>{{ $articulo->valor_venta }}</td>
        </tr>
        <tr>
            <th>Stock:</th>
            <td>{{ $articulo->stock }}</td>
        </tr>
    </table>
    <a href="{{ route('articulos.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection