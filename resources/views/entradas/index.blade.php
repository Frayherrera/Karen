@extends('layouts.app')

@section('content')
<!-- Font import -->
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<div class="container mx-auto px-4 bg-pink-50 min-h-screen py-8">
    <h1 class="text-3xl font-bold text-center my-6 text-pink-600" style="font-family: 'Dancing Script', cursive;">Lista de Entradas</h1>

    <!-- Mensaje de éxito -->
    @if(session('success'))
        <div class="bg-pink-100 border border-pink-400 text-pink-700 px-4 py-3 rounded-lg shadow-sm mb-4 transition-all duration-300" role="alert">
            <span class="block sm:inline"><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Botones de acción -->
    <div class="flex gap-4 mb-6">
        <a href="{{ url('/articulos') }}" class="bg-pink-500 hover:bg-pink-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Atrás
        </a>
    </div>

    <!-- Tabla de entradas -->
    @if($entradas->isEmpty())
        <div class="text-center bg-pink-100 border border-pink-300 text-pink-700 px-6 py-4 rounded-lg shadow-sm">
            <i class="fas fa-info-circle text-2xl mb-2"></i>
            <p class="text-lg">No hay ninguna entrada registrada</p>
        </div>
    @else
        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="min-w-full">
                <thead class="bg-pink-500 text-white">
                    <tr>
                        <th class="py-3 px-6 text-left text-sm font-semibold uppercase tracking-wider rounded-tl-lg">Código</th>
                        <th class="py-3 px-6 text-left text-sm font-semibold uppercase tracking-wider">Artículo</th>
                        <th class="py-3 px-6 text-left text-sm font-semibold uppercase tracking-wider">Cantidad</th>
                        <th class="py-3 px-6 text-left text-sm font-semibold uppercase tracking-wider">Valor Costo</th>
                        <th class="py-3 px-6 text-left text-sm font-semibold uppercase tracking-wider">Fecha de Ingreso</th>
                        <th class="py-3 px-6 text-left text-sm font-semibold uppercase tracking-wider rounded-tr-lg">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-pink-100">
                    @foreach($entradas as $entrada)
                        <tr class="hover:bg-pink-50 transition duration-150">
                            <td class="py-4 px-6">{{ $entrada->codigo }}</td>
                            <td class="py-4 px-6">{{ $entrada->articulo->nombre ?? 'Sin Artículo' }}</td>
                            <td class="py-4 px-6">{{ $entrada->cantidad }}</td>
                            <td class="py-4 px-6">${{ number_format($entrada->valor_costo, 2) }}</td>
                            <td class="py-4 px-6">{{ $entrada->fecha_ingreso }}</td>
                            <td class="py-4 px-6">
                                <div class="flex space-x-2">
                                    <form id="delete-form-{{ $entrada->id }}" action="{{ route('entradas.destroy', $entrada->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $entrada->id }})" 
                                            class="bg-pink-500 hover:bg-pink-600 text-white font-semibold py-1 px-3 rounded-lg shadow-sm transition duration-300 ease-in-out text-sm flex items-center">
                                            <i class="fas fa-trash-alt mr-1"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginador -->
        <div class="mt-6">
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
            confirmButtonColor: '#ec4899',  // pink-500
            cancelButtonColor: '#f43f5e',   // rose-500
            confirmButtonText: '<i class="fas fa-check mr-2"></i>Sí, eliminar',
            cancelButtonText: '<i class="fas fa-times mr-2"></i>Cancelar',
            customClass: {
                popup: 'rounded-lg',
                title: 'text-pink-600',
                confirmButton: 'rounded-lg',
                cancelButton: 'rounded-lg'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        })
    }
</script>
@endsection