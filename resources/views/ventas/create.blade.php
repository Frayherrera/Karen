@extends('layouts.app')

@section('content')
@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">¡Error!</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container mx-auto px-4">
   
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold text-center my-6">Nueva venta</h1>
    <form action="{{ route('ventas.store') }}" method="POST" class="max-w-lg mx-auto bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="codigo">Código</label>
            <input id="codigo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="codigo" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="nombre_articulo">Nombre del Artículo</label>
            <input id="nombre_articulo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="nombre_articulo" readonly>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="nombre">Cantidad</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" name="cantidad" required>

        </div>
        
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="valor_costo">Valor Unitario</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" name="valor_unitario" step="0.01" required>

        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="valor_venta">Descuento</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"  type="number" name="descuento" step="0.01">
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="stock">Tipo</label>
            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="tipo" id="tipo" required onchange="toggleCreditoFields()">
                <option value="contado">Contado</option>
                <option value="credito">Crédito</option>
            </select>        </div>

       

       
            <div class="mb-4" id="credito-fields" style="display: none;">
                <input type="number" name="dias_credito" placeholder="Días de crédito">
                <label for="porcentaje_credito">Porcentaje adicional:</label>
                <select name="porcentaje_credito" id="porcentaje_credito">
                    <option value="5">5%</option>
                    <option value="10">10%</option>
                    <option value="15">15%</option>
                    <option value="20">20%</option>
                </select>
            </div>

        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Registrar Venta</button>
            <a href="{{ route('ventas.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Cancelar</a>
        </div>
    </form>
</div>


<script>function toggleCreditoFields() {
    const tipo = document.getElementById('tipo').value;
    const creditoFields = document.getElementById('credito-fields');
    
    if (tipo === 'credito') {
        creditoFields.style.display = 'block';
    } else {
        creditoFields.style.display = 'none';
    }
}
</script>
<script>
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




