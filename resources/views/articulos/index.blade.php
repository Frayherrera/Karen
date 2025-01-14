@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold text-center my-8 text-pink-600 font-cursive" style="font-family: 'Dancing Script', cursive;">LISTA DE ARTÍCULOS</h1>

    <!-- Formulario de búsqueda -->
    <form method="GET" action="{{ route('articulos.index') }}" class="mb-6" id="search-form">
        <div class="flex items-center">
            <input type="text" name="q" id="search-input" value="{{ old('q', $query ?? '') }}" 
                   placeholder="Buscar artículos..." 
                   class="border border-pink-200 p-3 w-full rounded-l focus:ring-pink-300 focus:border-pink-300 transition-all duration-300 placeholder-pink-300">
            {{-- <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-3 px-6 rounded-r transition-all duration-300">
                <i class="fas fa-search mr-2"></i>Buscar
            </button> --}}
        </div>
    </form>

    <div class="flex flex-wrap gap-3 mb-8">
        <a href="{{ route('articulos.create') }}" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded inline-flex items-center transition-all duration-300 shadow-md hover:shadow-lg">
            <i class="fas fa-plus mr-2"></i>Nuevo Artículo
        </a>
        <a href="{{ route('ventas.index') }}" class="bg-pink-400 hover:bg-pink-500 text-white font-bold py-2 px-4 rounded inline-flex items-center transition-all duration-300 shadow-md hover:shadow-lg">
            <i class="fas fa-shopping-cart mr-2"></i>Ver ventas
        </a>
        <a href="{{ route('salida') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded inline-flex items-center transition-all duration-300 shadow-md hover:shadow-lg">
            <i class="fas fa-cash-register mr-2"></i>Realizar ventas
        </a>
        <a href="{{ route('entradas.index') }}" class="bg-pink-300 hover:bg-pink-400 text-white font-bold py-2 px-4 rounded inline-flex items-center transition-all duration-300 shadow-md hover:shadow-lg">
            <i class="fas fa-box mr-2"></i>Ingreso de artículos
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-lg relative mb-6 shadow-sm" role="alert">
            <span class="block sm:inline"><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Tabla de artículos -->
    <div id="articles-table" class="bg-white rounded-lg shadow-lg overflow-hidden">
        @include('articulos.partials.articulos-table', ['articulos' => $articulos])
    </div>
</div>

<!-- Modal de Stock -->
<div id="stockModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-xl p-8 w-96 transform transition-all duration-300">
        <h2 class="text-2xl font-bold mb-6 text-pink-600 font-cursive" style="font-family: 'Dancing Script', cursive;">Agregar Stock</h2>
        <form id="stockForm" method="POST" action="{{ route('entradas.store') }}">
            @csrf
            <input type="hidden" name="codigo" id="codigoInput">
            <div class="mb-6">
                <label for="nombre" class="block text-gray-700 font-bold mb-2">Artículo</label>
                <input type="text" id="nombreInput" class="border border-pink-200 p-3 w-full rounded-lg bg-pink-50" disabled>
            </div>
            <div class="mb-6">
                <label for="cantidad" class="block text-gray-700 font-bold mb-2">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" class="border border-pink-200 p-3 w-full rounded-lg focus:ring-pink-300 focus:border-pink-300" required>
            </div>
         
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-6 rounded-lg transition-all duration-300">
                    Cancelar
                </button>
                <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-6 rounded-lg transition-all duration-300">
                    Agregar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de Venta -->
<div id="ventaModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-xl p-8 w-96 transform transition-all duration-300">
        <h2 class="text-2xl font-bold mb-6 text-pink-600 font-cursive" style="font-family: 'Dancing Script', cursive;">Registrar Venta</h2>
        <form id="ventaForm" method="POST" action="{{ route('ventas.store') }}">
            @csrf
            <input type="hidden" name="codigo" id="codigoVentaInput">

            <div class="mb-6">
                <label for="nombre" class="block text-gray-700 font-bold mb-2">Artículo</label>
                <input type="text" id="nombreVentaInput" class="border border-pink-200 p-3 w-full rounded-lg bg-pink-50" disabled>
            </div>

            <div class="mb-6">
                <label for="cantidad" class="block text-gray-700 font-bold mb-2">Cantidad</label>
                <input type="number" name="cantidad" id="cantidadVenta" class="border border-pink-200 p-3 w-full rounded-lg focus:ring-pink-300 focus:border-pink-300" required>
            </div>

            <div class="mb-6">
                <label for="valor_unitario" class="block text-gray-700 font-bold mb-2">Valor Unitario</label>
                <input type="number" name="valor_unitario" id="valorUnitarioVenta" class="border border-pink-200 p-3 w-full rounded-lg focus:ring-pink-300 focus:border-pink-300" step="0.01" required>
            </div>

            <div class="mb-6">
                <label for="descuento" class="block text-gray-700 font-bold mb-2">Descuento</label>
                <input type="number" name="descuento" id="descuentoVenta" class="border border-pink-200 p-3 w-full rounded-lg focus:ring-pink-300 focus:border-pink-300" step="0.01">
            </div>

            <div class="mb-6">
                <label for="tipo" class="block text-gray-700 font-bold mb-2">Tipo de Venta</label>
                <select name="tipo" id="tipoVenta" class="border border-pink-200 p-3 w-full rounded-lg focus:ring-pink-300 focus:border-pink-300" required onchange="toggleCreditoOptions(this.value)">
                    <option value="contado">Contado</option>
                    <option value="credito">Crédito</option>
                </select>
            </div>

            <div id="credito-fields" class="mb-6 hidden">
                <div class="mb-4">
                    <label for="dias_credito" class="block text-gray-700 font-bold mb-2">Días de Crédito</label>
                    <input type="number" name="dias_credito" class="border border-pink-200 p-3 w-full rounded-lg focus:ring-pink-300 focus:border-pink-300">
                </div>
                
                <div class="mb-4">
                    <label for="porcentaje_credito" class="block text-gray-700 font-bold mb-2">Porcentaje adicional</label>
                    <select name="porcentaje_credito" class="border border-pink-200 p-3 w-full rounded-lg focus:ring-pink-300 focus:border-pink-300">
                        <option value="5">5%</option>
                        <option value="10">10%</option>
                        <option value="15">15%</option>
                        <option value="20">20%</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeVentaModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-6 rounded-lg transition-all duration-300">
                    Cancelar
                </button>
                <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-6 rounded-lg transition-all duration-300">
                    Registrar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('search-input');
        const articlesTable = document.getElementById('articles-table');

        searchInput.addEventListener('input', function () {
            const query = searchInput.value;
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

    function openVentaModal(codigo, nombre) {
        document.getElementById('codigoVentaInput').value = codigo;
        document.getElementById('nombreVentaInput').value = nombre;
        document.getElementById('ventaModal').classList.remove('hidden');
    }

    function closeVentaModal() {
        document.getElementById('ventaModal').classList.add('hidden');
    }

    function toggleCreditoOptions(tipo) {
        const creditoFields = document.getElementById('credito-fields');
        creditoFields.style.display = tipo === 'credito' ? 'block' : 'none';
    }

    function confirmDelete(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ec4899',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            background: '#fff',
            customClass: {
                confirmButton: 'bg-pink-500 hover:bg-pink-600',
                cancelButton: 'bg-gray-400 hover:bg-gray-500'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        })
    }
</script>
@endsection