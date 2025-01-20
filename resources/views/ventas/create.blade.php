@extends('layouts.app')

@section('content')
    <style>
        .venta-form:first-child .eliminar-venta {
            display: none;
        }
    </style>

    <div class="bg-pink-50 min-h-screen py-6">
        @if ($errors->any())
            <div class="bg-pink-100 border border-pink-400 text-pink-700 px-4 py-3 rounded relative mb-4 max-w-6xl mx-auto"
                role="alert">
                <strong class="font-bold">¡Error!</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="container mx-auto px-4">
            <a href="{{ route('ventas.index') }}"
                class="bg-pink-400 hover:bg-pink-500 text-white font-bold py-2 px-4 rounded inline-flex items-center transition-all duration-300 shadow-md hover:shadow-lg">
                <i class="fas fa-shopping-cart mr-2"></i>Ver ventas
            </a>
            <div class="flex justify-center items-center gap-4 mb-6">
                <h1 class="text-4xl font-bold text-center text-pink-600" style="font-family: 'Dancing Script', cursive;">
                    FACTURA DE VENTA
                </h1>
                <span class="text-4xl font-bold text-pink-600" style="font-family: 'Dancing Script', cursive;">
                    N° {{ str_pad($nextId, 5, '0', STR_PAD_LEFT) }}
                </span>
            </div>
            <form id="ventaForm" action="{{ route('ventas.store') }}" method="POST"
                class="max-w-6xl mx-auto bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-4">
                @csrf

                <div id="ventas-container">
                    <div class="venta-form mb-8 pb-6 border-b border-pink-200">
                        <div class="flex flex-wrap -mx-3">
                            <!-- Columna 1: Información básica -->
                            <div class="w-full md:w-1/3 px-3 mb-6">

                                <script>
                                    function obtenerArticulo1() {
                                        var articuloId = document.getElementById("articulo_id").value;
                                        var xhr = new XMLHttpRequest();
                                        xhr.open("GET", "/obtener-articulo/" + articuloId, true);
                                        xhr.onreadystatechange = function() {
                                            if (xhr.readyState == 4 && xhr.status == 200) {
                                                var response = JSON.parse(xhr.responseText);
                                                document.getElementById("nombre").value = response.nombre;
                                                document.getElementById("valor_unitario").value = response.valor_venta;
                                            }
                                        };
                                        xhr.send();
                                    }
                                </script>
                                <div>
                                    <h1 class="block text-pink-600  font-bold ">Datos del cliente</h1>
                                    <br>
                                    <div class="mb-4">
                                        <label class="block text-pink-600 text-sm font-bold mb-2" for="nombre_articulo">
                                            <i class="fas fa-tag mr-2"></i>Nombre
                                        </label>
                                        <input
                                            class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300"
                                            type="text" name="nombre_cliente">
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-pink-600 text-sm font-bold mb-2" for="nombre_articulo">
                                            <i class="fas fa-tag mr-2"></i>Dirección
                                        </label>
                                        <input
                                            class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300"
                                            type="text" name="direccion_cliente">
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-pink-600 text-sm font-bold mb-2" for="nombre_articulo">
                                            <i class="fas fa-tag mr-2"></i>Cedula
                                        </label>
                                        <input
                                            class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300"
                                            type="text" name="cedula_cliente">
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-pink-600 text-sm font-bold mb-2" for="nombre_articulo">
                                            <i class="fas fa-tag mr-2"></i>Telefono
                                        </label>
                                        <input
                                            class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300"
                                            type="text" name="telefono_cliente">
                                    </div>

                                </div>


                            </div>
                            <!-- Columna 3: Tipo de pago -->
                            <div class="w-full md:w-1/3 px-3 mb-6 ">
                                <br><br>
                                <div class="mb-4">
                                    <label class="block text-pink-600 text-sm font-bold mb-2" for="tipo">
                                        <i class="fas fa-money-bill-wave mr-2"></i>Tipo
                                    </label>
                                    <select
                                        class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300"
                                        name="tipo" id="tipo" required onchange="toggleCreditoFields()">
                                        <option value="contado">Contado</option>
                                        <option value="credito">Crédito</option>
                                    </select>
                                </div>

                                <div id="credito-fields" style="display: none;">
                                    {{-- <div class="mb-4">
                                        <label class="block text-pink-600 text-sm font-bold mb-2" for="dias_credito">
                                            <i class="fas fa-calendar-alt mr-2"></i>Días de crédito
                                        </label>
                                        <input
                                            class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300"
                                            type="number" name="dias_credito">
                                    </div> --}}

                                    <div class="mb-4">
                                        <label class="block text-pink-600 text-sm font-bold mb-2" for="porcentaje_credito">
                                            <i class="fas fa-percent mr-2"></i>Porcentaje adicional
                                        </label>
                                        <select
                                            class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300"
                                            name="porcentaje_credito" id="porcentaje_credito">
                                            <option value="5">5%</option>
                                            <option value="10">10%</option>
                                            <option value="15">15%</option>
                                            <option value="20">20%</option>
                                        </select>
                                    </div>

                                </div>
                                
                                    <div class="w-full md:w-1/3 px-3">
                                        <div class="mb-4">
                                            <label class="block text-pink-600 text-sm font-bold mb-2" for="subtotal">
                                                <i class="fas fa-calculator mr-2"></i>Subtotal
                                            </label>
                                            <input id="subtotal"
                                                class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300"
                                                type="text" readonly>
                                        </div>

                                        <div class="mb-4">
                                            <label class="block text-pink-600 text-sm font-bold mb-2" for="total">
                                                <i class="fas fa-coins mr-2"></i>Total
                                            </label>
                                            <input id="total"
                                                class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300"
                                                type="text" readonly>
                                        </div>
                                    </div>
                                
                                <script>
                                    document.addEventListener('input', calcularTotales);

                                    function calcularTotales() {
                                        let subtotal = 0;

                                        // Iterar sobre todos los formularios de artículos
                                        document.querySelectorAll('.venta-form').forEach(ventaForm => {
                                            const cantidad = parseFloat(ventaForm.querySelector('input[name$="[cantidad]"]').value) || 0;
                                            const valorUnitario = parseFloat(ventaForm.querySelector('input[name$="[valor_unitario]"]')
                                                .value) || 0;
                                            const descuento = parseFloat(ventaForm.querySelector('input[name$="[descuento]"]').value) || 0;

                                            // Calcular subtotal del artículo considerando el descuento
                                            const subtotalArticulo = (cantidad * valorUnitario) - ( descuento);
                                            subtotal += subtotalArticulo;
                                        });

                                        // Mostrar subtotal y total
                                        document.getElementById('subtotal').value = subtotal.toFixed();

                                        // Calcular total (considerando un porcentaje adicional en caso de crédito)
                                        const tipoPago = document.getElementById('tipo').value;
                                        let total = subtotal;

                                        if (tipoPago === 'credito') {
                                            const porcentajeCredito = parseFloat(document.getElementById('porcentaje_credito').value) || 0;
                                            total += subtotal * (porcentajeCredito / 100);
                                        }

                                        document.getElementById('total').value = total.toFixed();
                                    }
                                </script>


                            </div>
                        </div>
                        <hr>
                        <br>
                        <!-- Columna 2: Detalles de venta -->
                        <div class="flex flex-wrap space-x-4">
                            <div class="mb-4">
                                <label class="block text-pink-600 text-sm font-bold mb-2" for="codigo">
                                    <i class="fas fa-barcode mr-2"></i>Código
                                </label>
                                {{-- <input id="codigo" 
                            class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300" 
                            type="text" 
                            name="codigo" 
                            required> --}}
                                <input id="codigo"
                                    class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300"
                                    type="text" name="articulos[0][codigo]" onchange="obtenerArticulo2()" required>

                                <script>
                                    function obtenerArticulo2() {
                                        var codigo = document.getElementById("codigo").value;
                                        var xhr = new XMLHttpRequest();
                                        xhr.open("GET", "/obtener-articulo-por-codigo/" + codigo, true);
                                        xhr.onreadystatechange = function() {
                                            if (xhr.readyState == 4 && xhr.status == 200) {
                                                var response = JSON.parse(xhr.responseText);
                                                document.getElementById("nombre").value = response.nombre;
                                                document.getElementById("valor_unitario").value = response.valor_venta;
                                            }
                                        };
                                        xhr.send();
                                    }
                                </script>
                            </div>

                            <div class="mb-4">
                                <label class="block text-pink-600 text-sm font-bold mb-2" for="nombre_articulo">
                                    <i class="fas fa-tag mr-2"></i>Nombre del Artículo
                                </label>
                                <input id="nombre"
                                    class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300"
                                    type="text" name="nombre" readonly>
                            </div>
                            <div class="mb-4">
                                <label class="block text-pink-600 text-sm font-bold mb-2" for="cantidad">
                                    <i class="fas fa-boxes mr-2"></i>Cantidad
                                </label>
                                {{-- <input class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300" 
                            type="number" 
                            name="cantidad" 
                            required> --}}
                                <input
                                    class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300"
                                    type="number" name="articulos[0][cantidad]" min="1" required>

                            </div>

                            <div class="mb-4">
                                <label class="block text-pink-600 text-sm font-bold mb-2" for="valor_unitario">
                                    <i class="fas fa-dollar-sign mr-2"></i>Valor Unitario
                                </label>
                                {{-- <input
                                class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300"
                                type="number" name="valor_unitario" step="0.01" required> --}}
                                {{-- <input id="valor_unitario"
                                class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300"
                                type="number" name="valor_unitario" step="0.01"> --}}
                                <input
                                    class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300"
                                    id="valor_unitario" type="number" name="articulos[0][valor_unitario]"
                                    min="0" step="0.01" required>

                            </div>

                            <div class="mb-4">
                                <label class="block text-pink-600 text-sm font-bold mb-2" for="descuento">
                                    <i class="fas fa-percentage mr-2"></i>Descuento
                                </label>
                                {{-- <input
                                class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300"
                                type="number" name="descuento" step="0.01"> --}}
                                <input
                                    class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300"
                                    type="number" name="articulos[0][descuento]" min="0" step="0.01">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-6">
                    {{-- <button type="button" onclick="agregarNuevaVenta()"
                        class="bg-pink-400 hover:bg-pink-500 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-opacity-50 transition duration-300 transform hover:-translate-y-1">
                        <i class="fas fa-plus mr-2"></i>Agregar Otro Articulo
                    </button> --}}

                    <button
                        class="bg-pink-400 hover:bg-pink-500 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-opacity-50 transition duration-300 transform hover:-translate-y-1"
                        type="button" id="add-articulo"> <i class="fas fa-plus mr-2"></i>Agregar Otro ArtÍculo</button>


                    <div>
                        <button
                            class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-opacity-50 transition duration-300 transform hover:-translate-y-1 mr-4"
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
                            body: JSON.stringify({
                                codigo: this.value
                            }),
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

        document.getElementById('codigo').addEventListener('input', function() {
            const codigo = this.value;

            if (codigo) {
                fetch("{{ route('articulos.get') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            codigo: codigo
                        }),
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
    <script>
        document.getElementById('add-articulo').addEventListener('click', function() {
            const container = document.getElementById('ventas-container');
            const index = container.children.length;

            const articuloDiv = document.createElement('div');
            articuloDiv.classList.add('articulo');

            articuloDiv.innerHTML = `
       <div class="venta-form mb-8 pb-6 border-b border-pink-200">
          
                <!-- Columna 1: Información básica -->
               

                <!-- Columna 2: Detalles de venta -->
                <div class="flex flex-wrap space-x-4">
                     <div class="mb-4">
                        <label class="block text-pink-600 text-sm font-bold mb-2" for="codigo_${index}">
                            <i class="fas fa-barcode mr-2"></i>Código
                        </label>
                        <input id="codigo_${index}"
                            class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300"
                            type="text" name="articulos[${index}][codigo]" onchange="obtenerArticulo(${index})" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-pink-600 text-sm font-bold mb-2" for="nombre_${index}">
                            <i class="fas fa-tag mr-2"></i>Nombre del Artículo
                        </label>
                        <input id="nombre_${index}"
                            class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300"
                            type="text" name="articulos[${index}][nombre]" readonly>
                    </div>
                    <div class="mb-4">
                        <label class="block text-pink-600 text-sm font-bold mb-2" for="cantidad_${index}">
                            <i class="fas fa-boxes mr-2"></i>Cantidad
                        </label>
                        <input
                            class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300"
                            type="number" name="articulos[${index}][cantidad]" min="1" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-pink-600 text-sm font-bold mb-2" for="valor_unitario_${index}">
                            <i class="fas fa-dollar-sign mr-2"></i>Valor Unitario
                        </label>
                        <input
                            class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300"
                            id="valor_unitario_${index}" type="number" name="articulos[${index}][valor_unitario]" min="0"
                            step="0.01" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-pink-600 text-sm font-bold mb-2" for="descuento_${index}">
                            <i class="fas fa-percentage mr-2"></i>Descuento
                        </label>
                        <input class="shadow-sm appearance-none border border-pink-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-300"
                            type="number" name="articulos[${index}][descuento]" min="0" step="0.01">
                    </div>
                </div>
                
                <!-- Columna 3: Tipo de pago -->
               
                </div>
            </div>
        </div>
    `;
            container.appendChild(articuloDiv);
        });




        function obtenerArticulo(index) {
            var codigo = document.getElementById("codigo_" + index).value;
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "/obtener-articulo-por-codigo/" + codigo, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById("nombre_" + index).value = response.nombre;
                    document.getElementById("valor_unitario_" + index).value = response.valor_venta;
                }
            };
            xhr.send();
        }
    </script>
    <script>
        document.getElementById('ventaForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            try {
                const response = await fetch("{{ route('ventas.store') }}", {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (response.ok) {
                    await Swal.fire({
                        title: '¡Éxito!',
                        text: 'Venta registrada correctamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#ec4899'
                    });

                    window.location.href = "{{ route('ventas.index') }}";
                } else {
                    Swal.fire({
                        title: '¡Error!',
                        text: 'Hubo un problema al registrar la venta',
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#ec4899'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });



        document.getElementById('tipo_venta').addEventListener('change', toggleCreditoFields);
    </script>
@endsection
