@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold text-center my-6">Lista de Artículos</h1>

    <!-- Formulario de búsqueda -->
    <form method="GET" action="{{ route('articulos.index') }}" class="mb-4" id="search-form">
        <div class="flex items-center">
            <input type="text" name="q" id="search-input" value="{{ old('q', $query ?? '') }}" 
                   placeholder="Buscar artículos..." 
                   class="border border-gray-300 p-2 w-full rounded-l">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-r">Buscar</button>
        </div>
    </form>

    <a href="{{ route('articulos.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-6 inline-block">Nuevo Artículo</a>
    <a href="{{ route('ventas.index') }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mb-6 inline-block">Ver ventas</a>
    <a href="{{ route('salida') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-6 inline-block">Realizar ventas</a>
    <a href="{{ route('entrada') }}" class="bg-lime-600 hover:bg-lime-700 text-white font-bold py-2 px-4 rounded mb-6 inline-block">Ingreso de articulos</a>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif


    <!-- Tabla de artículos -->
    <div id="articles-table">
        @include('articulos.partials.articulos-table', ['articulos' => $articulos])
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('search-input');
        const articlesTable = document.getElementById('articles-table');
        
        searchInput.addEventListener('input', function () {
            const query = searchInput.value;

            // Hacer una petición AJAX al servidor
            fetch(`{{ route('articulos.index') }}?q=${query}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                articlesTable.innerHTML = html;
            })
            .catch(error => {
                console.error('Error al realizar la búsqueda:', error);
            });
        });
    });
</script>
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
