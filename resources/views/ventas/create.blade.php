@extends('layouts.app')

@section('content')
<div class="bg-pink-50 min-h-screen py-6">
    @if ($errors->any())
        <div class="bg-pink-100 border border-pink-400 text-pink-700 px-4 py-3 rounded relative mb-4 max-w-lg mx-auto" role="alert">
            <strong class="font-bold">¡Error!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-center my-6 text-pink-600" style="font-family: 'Dancing Script', cursive;">Nueva Venta</h1>
        
        <form action="{{ route('ventas.store') }}" method="POST" class="max-w-lg mx-auto bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-4">
            @csrf
            
            <div class="mb-4">
                <label class="block text-pink-600 text-sm font-bold mb-2" for="codigo">
                    <i class="fas fa-barcode mr-2"></i>Código
                </label>
                <input id="codigo" 
                    class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300" 
                    type="text" 
                    name="codigo" 
                    required>
            </div>

            <div class="mb-4">
                <label class="block text-pink-600 text-sm font-bold mb-2" for="nombre_articulo">
                    <i class="fas fa-tag mr-2"></i>Nombre del Artículo
                </label>
                <input id="nombre_articulo" 
                    class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight bg-pink-50" 
                    type="text" 
                    name="nombre_articulo" 
                    readonly>
            </div>

            <div class="mb-4">
                <label class="block text-pink-600 text-sm font-bold mb-2" for="cantidad">
                    <i class="fas fa-boxes mr-2"></i>Cantidad
                </label>
                <input class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300" 
                    type="number" 
                    name="cantidad" 
                    required>
            </div>

            <div class="mb-4">
                <label class="block text-pink-600 text-sm font-bold mb-2" for="valor_unitario">
                    <i class="fas fa-dollar-sign mr-2"></i>Valor Unitario
                </label>
                <input class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300" 
                    type="number" 
                    name="valor_unitario" 
                    step="0.01" 
                    required>
            </div>

            <div class="mb-4">
                <label class="block text-pink-600 text-sm font-bold mb-2" for="descuento">
                    <i class="fas fa-percentage mr-2"></i>Descuento
                </label>
                <input class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300" 
                    type="number" 
                    name="descuento" 
                    step="0.01">
            </div>

            <div class="mb-4">
                <label class="block text-pink-600 text-sm font-bold mb-2" for="tipo">
                    <i class="fas fa-money-bill-wave mr-2"></i>Tipo
                </label>
                <select class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300" 
                    name="tipo" 
                    id="tipo" 
                    required 
                    onchange="toggleCreditoFields()">
                    <option value="contado">Contado</option>
                    <option value="credito">Crédito</option>
                </select>
            </div>

            <div class="mb-4 bg-pink-50 p-4 rounded-lg" id="credito-fields" style="display: none;">
                <div class="mb-3">
                    <label class="block text-pink-600 text-sm font-bold mb-2" for="dias_credito">
                        <i class="fas fa-calendar-alt mr-2"></i>Días de crédito
                    </label>
                    <input class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300" 
                        type="number" 
                        name="dias_credito">
                </div>
                
                <div>
                    <label class="block text-pink-600 text-sm font-bold mb-2" for="porcentaje_credito">
                        <i class="fas fa-percent mr-2"></i>Porcentaje adicional
                    </label>
                    <select class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300" 
                        name="porcentaje_credito" 
                        id="porcentaje_credito">
                        <option value="5">5%</option>
                        <option value="10">10%</option>
                        <option value="15">15%</option>
                        <option value="20">20%</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <button class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-opacity-50 transition duration-300 transform hover:-translate-y-1" 
                    type="submit">
                    <i class="fas fa-save mr-2"></i>Registrar Venta
                </button>
                <a href="{{ route('ventas.index') }}" 
                    class="inline-block align-baseline font-bold text-sm text-pink-500 hover:text-pink-700 transition duration-300">
                    <i class="fas fa-times mr-2"></i>Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
function toggleCreditoFields() {
    const tipo = document.getElementById('tipo').value;
    const creditoFields = document.getElementById('credito-fields');
    
    if (tipo === 'credito') {
        creditoFields.style.display = 'block';
    } else {
        creditoFields.style.display = 'none';
    }
}

document.getElementById('codigo').addEventListener('input', function () {
    const codigo = this.value;

    if (codigo) {
        fetch("{{ route('articulos.get') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ codigo: codigo }),
        })
        .then(response => response.json())
        .then(data => {
            const nombreInput = document.getElementById('nombre_articulo');
            if (data.success) {
                nombreInput.value = data.nombre;
            } else {
                nombreInput.value = 'Artículo no encontrado';
            }
        })
        .catch(error => console.error('Error:', error));
    } else {
        document.getElementById('nombre_articulo').value = '';
    }
});
</script>
@endsection