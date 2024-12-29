@extends('layouts.app')

@section('content')
<style>
    .venta-form:first-child .eliminar-venta {
        display: none;
    }
</style>

<div class="bg-pink-50 min-h-screen py-6">
    @if ($errors->any())
        <div class="bg-pink-100 border border-pink-400 text-pink-700 px-4 py-3 rounded relative mb-4 max-w-6xl mx-auto" role="alert">
            <strong class="font-bold">¡Error!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-center mb-6 text-pink-600" style="font-family: 'Dancing Script', cursive;">Nueva Venta</h1>
        
        <form action="{{ route('ventas.store') }}" method="POST" class="max-w-6xl mx-auto bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-4">
            @csrf
            
            <div id="ventas-container">
                <div class="venta-form mb-8 pb-6 border-b border-pink-200">
                    <div class="flex flex-wrap -mx-3">
                        <!-- Columna 1: Información básica -->
                        <div class="w-full md:w-1/3 px-3 mb-6">
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
                        </div>

                        <!-- Columna 2: Detalles de venta -->
                        <div class="w-full md:w-1/3 px-3 mb-6">
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
                        </div>

                        <!-- Columna 3: Tipo de pago -->
                        <div class="w-full md:w-1/3 px-3 mb-6">
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

                            <div id="credito-fields" style="display: none;">
                                <div class="mb-4">
                                    <label class="block text-pink-600 text-sm font-bold mb-2" for="dias_credito">
                                        <i class="fas fa-calendar-alt mr-2"></i>Días de crédito
                                    </label>
                                    <input class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300" 
                                        type="number" 
                                        name="dias_credito">
                                </div>
                                
                                <div class="mb-4">
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
                        </div>
                    </div>
                    <div class="flex justify-end mt-2">
                        <button type="button" 
                            class="eliminar-venta text-pink-500 hover:text-pink-700 font-medium text-sm transition duration-300"
                            onclick="eliminarVenta(this)">
                            <i class="fas fa-trash mr-1"></i>Eliminar esta venta
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <button type="button" 
                    onclick="agregarNuevaVenta()"
                    class="bg-pink-400 hover:bg-pink-500 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-opacity-50 transition duration-300 transform hover:-translate-y-1">
                    <i class="fas fa-plus mr-2"></i>Agregar Otra Venta
                </button>
                <div>
                    <button class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-opacity-50 transition duration-300 transform hover:-translate-y-1 mr-4" 
                        type="submit">
                        <i class="fas fa-save mr-2"></i>Registrar Ventas
                    </button>
                    <a href="{{ route('ventas.index') }}" 
                        class="inline-block align-baseline font-bold text-sm text-pink-500 hover:text-pink-700 transition duration-300">
                        <i class="fas fa-times mr-2"></i>Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
let ventaCounter = 1;

function eliminarVenta(boton) {
    const ventaForm = boton.closest('.venta-form');
    // No eliminar si es el único formulario
    const totalForms = document.querySelectorAll('.venta-form').length;
    if (totalForms > 1) {
        ventaForm.remove();
    } else {
        alert('Debe haber al menos una venta en el formulario');
    }
}

function agregarNuevaVenta() {
    const ventasContainer = document.getElementById('ventas-container');
    const template = document.querySelector('.venta-form').cloneNode(true);
    
    // Actualizar IDs y names para que sean únicos
    const currentIndex = ventaCounter;
    template.querySelectorAll('input, select').forEach(element => {
        const oldName = element.name;
        if (oldName) {
            element.name = `ventas[${currentIndex}][${oldName}]`;
        }
        if (element.id) {
            element.id = `${element.id}_${currentIndex}`;
        }
    });

    // Limpiar valores
    template.querySelectorAll('input').forEach(input => {
        input.value = '';
    });
    template.querySelectorAll('select').forEach(select => {
        select.selectedIndex = 0;
    });

    // Agregar evento al nuevo código
    const nuevoCodigoInput = template.querySelector('input[name^="ventas"][name$="[codigo]"]');
    nuevoCodigoInput.addEventListener('input', function() {
        const nombreInput = this.closest('.venta-form').querySelector('input[name$="[nombre_articulo]"]');
        
        if (this.value) {
            fetch("{{ route('articulos.get') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ codigo: this.value }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    nombreInput.value = data.nombre;
                } else {
                    nombreInput.value = 'Artículo no encontrado';
                }
            })
            .catch(error => console.error('Error:', error));
        } else {
            nombreInput.value = '';
        }
    });

    // Actualizar el manejador de crédito
    template.querySelector('select[name$="[tipo]"]').onchange = function() {
        const creditoFields = this.closest('.venta-form').querySelector('div[id^="credito-fields"]');
        creditoFields.style.display = this.value === 'credito' ? 'block' : 'none';
    };

    // Asegurarse de que el botón de eliminar esté visible
    const eliminarButton = template.querySelector('.eliminar-venta');
    if (eliminarButton) {
        eliminarButton.style.display = 'block';
    }

    // Agregar separador visual
    template.classList.add('border-t', 'border-pink-200', 'pt-6');

    ventasContainer.appendChild(template);
    ventaCounter++;
}

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