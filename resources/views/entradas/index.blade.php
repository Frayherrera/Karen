@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold text-center my-6">Lista de Entradas</h1>

    <!-- Mensaje de éxito -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Botón para registrar una nueva entrada -->
    <a href="{{ url('/articulos') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-6 inline-block">Atras</a>

    <a href="{{ route('entradas.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-6 inline-block">Registrar Nueva Entrada</a>

    <!-- Tabla de entradas -->
    @if($entradas->isEmpty())
        <div class="text-center bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative">
            No se encontraron entradas.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Código</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Artículo</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Cantidad</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Valor Costo</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Fecha de Ingreso</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($entradas as $entrada)
                        <tr class="hover:bg-gray-100">
                            <td class="py-4 px-6">{{ $entrada->codigo }}</td>
                            <td class="py-4 px-6">{{ $entrada->articulo->nombre ?? 'Sin Artículo' }}</td>
                            <td class="py-4 px-6">{{ $entrada->cantidad }}</td>
                            <td class="py-4 px-6">${{ number_format($entrada->valor_costo, 2) }}</td>
                            <td class="py-4 px-6">{{ $entrada->fecha_ingreso }}</td>
                            <td class="py-4 px-6">
                                <div class="flex space-x-2">
                                    <a href="{{ route('entradas.show', $entrada->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-xs">Ver</a>
                                    <form id="delete-form-{{ $entrada->id }}" action="{{ route('entradas.destroy', $entrada->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $entrada->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginador -->
        <div class="mt-4">
            {{ $entradas->links() }}
        </div>
    @endif
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        })
    }
</script>
@endsection
