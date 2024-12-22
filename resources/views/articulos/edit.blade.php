@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold text-center my-6">Editar Artículo</h1>

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: '¡Error!',
                    text: 'Este código ya existe',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            });
        </script>
    @endif

    <form action="{{ route('articulos.update', $articulo->id) }}" method="POST" id="editForm" class="max-w-lg mx-auto bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PUT')

        <!-- Código -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="codigo">Código *</label>
            <div class="relative">
                <input required 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="codigo" 
                    name="codigo" 
                    type="text" 
                    maxlength="10"
                    placeholder="Código del artículo" 
                    value="{{ old('codigo', $articulo->codigo) }}"
                    onblur="verificarCodigoArticulo(this.value)">
                <div id="codigo-feedback" class="mt-1 text-sm hidden"></div>
            </div>
        </div>

        <!-- Nombre -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="nombre">Nombre *</label>
            <input required 
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                id="nombre" 
                name="nombre" 
                type="text" 
                maxlength="15"
                placeholder="Nombre del artículo" 
                value="{{ old('nombre', $articulo->nombre) }}">
        </div>

        <!-- Descripción -->
        <div class="mb-6">
            <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
            <textarea 
                name="descripcion" 
                id="descripcion" 
                rows="3" 
                maxlength="500"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                placeholder="Descripción del artículo">{{ old('descripcion', $articulo->descripcion) }}</textarea>
            <div class="text-sm text-gray-500 mt-1">
                <span id="descripcion-contador">0</span>/500 caracteres
            </div>
        </div>
        
        <!-- Valor Costo -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="valor_costo">Valor Costo *</label>
            <input required 
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                id="valor_costo" 
                name="valor_costo" 
                type="number" 
                step="0.01" 
                min="0"
                placeholder="0.00" 
                value="{{ old('valor_costo', $articulo->valor_costo) }}"
                onchange="validarValores()">
        </div>
        
        <!-- Valor Venta -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="valor_venta">Valor Venta *</label>
            <input required 
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                id="valor_venta" 
                name="valor_venta" 
                type="number" 
                step="0.01" 
                min="0"
                placeholder="0.00" 
                value="{{ old('valor_venta', $articulo->valor_venta) }}"
                onchange="validarValores()">
        </div>
        
        <!-- Stock -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="stock">Stock *</label>
            <input required 
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                id="stock" 
                name="stock" 
                type="number" 
                min="0"
                placeholder="0" 
                value="{{ old('stock', $articulo->stock) }}">
        </div>

        <!-- Categoría -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="categoria_id">Categoría *</label>
            <div class="flex">
                <select required 
                    name="categoria_id" 
                    id="categoria_id" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="" disabled>Selecciona una categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ old('categoria_id', $articulo->categoria_id) == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Botones -->
        <div class="flex items-center justify-between mt-6">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                type="submit">
                Actualizar
            </button>
            <a href="{{ route('articulos.index') }}" 
                class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Cancelar
            </a>
        </div>
    </form>
</div>

<script>
    // Validación de código de artículo
    function verificarCodigoArticulo(codigo) {
        if (!codigo) return;

        fetch(`/articulos/verificar-codigo?codigo=${encodeURIComponent(codigo)}`)
            .then(response => response.json())
            .then(data => {
                if (data.existe) {
                    Swal.fire({
                        title: '¡Atención!',
                        text: 'Este código ya existe.',
                        icon: 'warning',
                        confirmButtonText: 'Entendido',
                        confirmButtonColor: '#3085d6'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    // Validación de valores de costo y venta
    function validarValores() {
        const valorCosto = parseFloat(document.getElementById('valor_costo').value) || 0;
        const valorVenta = parseFloat(document.getElementById('valor_venta').value) || 0;

        if (valorVenta < valorCosto) {
            Swal.fire({
                title: '¡Advertencia!',
                text: 'El valor de venta es menor que el valor de costo',
                icon: 'warning',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#3085d6'
            });
        }
    }

    // Contador de caracteres para descripción
    const descripcionTextarea = document.getElementById('descripcion');
    const contadorSpan = document.getElementById('descripcion-contador');

    descripcionTextarea.addEventListener('input', function() {
        const caracteresActuales = this.value.length;
        contadorSpan.textContent = caracteresActuales;
        
        if (caracteresActuales > 500) {
            this.value = this.value.substring(0, 500);
            contadorSpan.textContent = 500;
        }
    });

    // Validación del formulario antes de enviar
    document.getElementById('editForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const valorCosto = parseFloat(document.getElementById('valor_costo').value) || 0;
        const valorVenta = parseFloat(document.getElementById('valor_venta').value) || 0;

        if (valorVenta < valorCosto) {
            const result = await Swal.fire({
                title: '¡Advertencia!',
                text: 'El valor de venta es menor que el valor de costo. ¿Desea continuar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, continuar',
                cancelButtonText: 'Cancelar'
            });

            if (result.isConfirmed) {
                this.submit();
            }
        } else {
            this.submit();
        }
    });

    // Inicializar contador de caracteres
    document.addEventListener('DOMContentLoaded', function() {
        const caracteresActuales = descripcionTextarea.value.length;
        contadorSpan.textContent = caracteresActuales;
    });
</script>
@endsection