@extends('layouts.app')


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Ventas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
@section('content')
<body>
<div class="container mt-5">
    <h1 class="text-2xl font-bold text-center my-6">Lista de Ventas</h1>
    <a href="{{ url('/articulos') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-6 inline-block">Atras</a>
    <a href="{{ route('salida') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-6 inline-block">Nueva venta</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Fecha de Venta</th>
            <th>Código</th>
            <th>Cantidad</th>
            <th>Valor Unitario</th>
            <th>Descuento</th>
            <th>Tipo</th>
            <th>Utilidad</th>
            <th>Total</th>
          
            <th>Acciones</th>

        </tr>
        </thead>
        <tbody>
        @foreach ($ventas as $venta)
            <tr>
                <td>{{ $venta->id }}</td>
                <td>{{ $venta->fecha_venta }}</td>
                <td>{{ $venta->codigo }}</td>
                <td>{{ $venta->cantidad }}</td>
                <td>${{ number_format($venta->valor_unitario, 2) }}</td>
                <td>${{ number_format($venta->descuento, 2) }}</td>

                <td>{{ ucfirst($venta->tipo) }}</td>
                <td>${{ number_format($venta->utilidad, 2) }}</td>
                <td>${{ number_format($venta->valor_total, 2) }}</td>

                

                <td>
                    <!-- Botón para generar ticket -->
                    <a href="{{ route('ventas.ticket', $venta->id) }}" class="btn btn-primary btn-sm">Generar Ticket</a>
                    
                    {{-- <!-- Botón para editar (opcional) -->
                    <a href="{{ route('ventas.edit', $venta->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    
                    <!-- Formulario para eliminar -->
                    <form action="{{ route('ventas.destroy', $venta->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Estás seguro de eliminar esta venta?')">Eliminar</button>
                    </form> --}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Paginación -->
    <div class="d-flex justify-content-center">
        {{ $ventas->links() }}
    </div>
</div>
</body>
@endsection

</html>
