@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Artículo</h1>
    <form action="{{ route('articulos.update', $articulo->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="codigo">Código:</label>
            <input type="text" name="codigo" class="form-control" value="{{ $articulo->codigo }}" required>
        </div>
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" class="form-control" value="{{ $articulo->nombre }}" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" class="form-control">{{ $articulo->descripcion }}</textarea>
        </div>
        <div class="form-group">
            <label for="valor_costo">Valor Costo:</label>
            <input type="number" name="valor_costo" class="form-control" value="{{ $articulo->valor_costo }}" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="valor_venta">Valor Venta:</label>
            <input type="number" name="valor_venta" class="form-control" value="{{ $articulo->valor_venta }}" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="stock">Stock:</label>
            <input type="number" name="stock" class="form-control" value="{{ $articulo->stock }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('articulos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
