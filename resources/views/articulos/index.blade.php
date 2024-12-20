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
    <a href="{{ route('entradas.index') }}" class="bg-lime-600 hover:bg-lime-700 text-white font-bold py-2 px-4 rounded mb-6 inline-block">Ingreso de artículos</a>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Incluir la tabla de artículos -->
    <div id="articles-table">
        @include('articulos.partials.articulos-table', ['articulos' => $articulos])
    </div>

</div>

<!-- Modal -->
<div id="stockModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96">
        <h2 class="text-lg font-bold mb-4">Agregar Stock</h2>
        <form id="stockForm" method="POST" action="{{ route('entradas.store') }}">
            @csrf
            <input type="hidden" name="codigo" id="codigoInput">
            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 font-bold">Artículo</label>
                <input type="text" id="nombreInput" class="border border-gray-300 p-2 w-full rounded bg-gray-100" disabled>
            </div>
            <div class="mb-4">
                <label for="cantidad" class="block text-gray-700 font-bold">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" class="border border-gray-300 p-2 w-full rounded" required>
            </div>
            <div class="mb-4">
                <label for="valor_costo" class="block text-gray-700 font-bold">Costo Unitario</label>
                <input type="number" name="valor_costo" id="valor_costo" class="border border-gray-300 p-2 w-full rounded" step="0.01" required>
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancelar</button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Agregar</button>
            </div>
        </form>
    </div>
</div>

{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
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

    function openModal(codigo, nombre) {
        document.getElementById('codigoInput').value = codigo;
        document.getElementById('nombreInput').value = nombre;
        document.getElementById('stockModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('stockModal').classList.add('hidden');
    }

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