<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Factura de Venta</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono&family=Inter:wght@400;600&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
        }

        h1 {
            text-align: center;
            font-size: 1.5em;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #ec4899; /* Pink-500 */
        }

        .container {
            background-color: #fff;
            padding: 40px;
            max-width: 800px;
            margin: 20px auto;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .header {
            border-bottom: 2px solid #ec4899;
            margin-bottom: 20px;
            padding-bottom: 20px;
        }

        .factura-numero {
            font-family: 'Roboto Mono', monospace;
            font-size: 1.2em;
            margin-bottom: 15px;
            border: 1px solid #ec4899;
            display: inline-block;
            padding: 5px 10px;
            color: #ec4899;
        }

        .info-empresa {
            float: left;
            width: 50%;
        }

        .info-factura {
            float: right;
            width: 50%;
            text-align: right;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        .info-cliente {
            border: 1px solid #fbcfe8; /* Pink-200 */
            padding: 15px;
            margin: 20px 0;
            background-color: #fdf2f8; /* Pink-50 */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 0.9em;
        }

        th, td {
            border: 1px solid #fbcfe8; /* Pink-200 */
            padding: 4px;
            text-align: left;
            font-size: 0.9em;
        }

        th {
            background-color: #fdf2f8; /* Pink-50 */
            font-weight: 500;
            color: #be185d; /* Pink-700 */
        }

        tr:nth-child(even) {
            background-color: #fdf2f8; /* Pink-50 */
        }

        .totals {
            margin-top: 20px;
            text-align: right;
            border-top: 2px solid #ec4899;
            padding-top: 20px;
        }

        .monospace {
            font-family: 'Roboto Mono', monospace;
        }

        .valor {
            font-weight: 600;
            font-family: 'Roboto Mono', monospace;
        }

        .calculations {
            text-align: right;
            background-color: #fdf2f8; /* Pink-50 */
            border: 1px solid #fbcfe8; /* Pink-200 */
            padding: 15px;
            margin-top: 20px;
        }

        .calculation-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
            padding: 5px 0;
            border-bottom: 1px solid #fbcfe8; /* Pink-200 */
        }

        .calculation-row:last-child {
            border-bottom: none;
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #fbcfe8;
            font-size: 0.8em;
            text-align: center;
            color: #be185d; /* Pink-700 */
        }

        @media print {
            body {
                background: none;
                margin: 0;
                padding: 0;
            }
            .container {
                box-shadow: none;
                border: none;
                padding: 20px;
            }
            table {
                page-break-inside: auto;
            }
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            .totals, .calculations {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
@php
    $subtotal = 0; // Inicializamos el subtotal

    foreach ($articulos as $articulo) {
        // Calcular el subtotal por artículo
        $subtotalArticulo = ($articulo->pivot->cantidad * $articulo->pivot->valor_unitario) - $articulo->pivot->descuento;
        $subtotal += $subtotalArticulo; // Sumar al subtotal general
    }

    // Calcular el valor del crédito basado en el porcentaje (si es aplicable)
    $porcentajeCredito = $venta->porcentaje_credito ?? 0; // Si no hay porcentaje, asumimos 0
    $valorCredito = $venta->valor_total - $subtotal ;

    // Calcular el total final
    $valorTotal = $subtotal + $valorCredito;
@endphp

<body>
    <div class="container">
        <div class="header clearfix">
            <div class="info-empresa">
                <h1>FACTURA</h1>
                <div class="factura-numero">N° {{ str_pad($venta->id, 4, '0', STR_PAD_LEFT) }}</div>
            </div>
            <div class="info-factura">
                <p><strong>Fecha:</strong> {{ $venta->fecha_venta }}</p>
                <p><strong>Tipo de Venta:</strong> {{ $venta->tipo }}</p>
            </div>
        </div>

        <div class="info-cliente">
            <h3>DATOS DEL CLIENTE</h3>
            <p><strong>Nombre:</strong> {{ $venta->nombre_cliente }}</p>
            <p><strong>C.C/NIT:</strong> {{ $venta->cedula_cliente }}</p>
            <p><strong>Dirección:</strong> {{ $venta->direccion_cliente }}</p>
            <p><strong>Teléfono:</strong> {{ $venta->telefono_cliente }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>CÓDIGO</th>
                    <th>DESCRIPCIÓN</th>
                    <th>CANT.</th>
                    <th>V. UNIT</th>
                    <th>DESC.</th>
                    <th>SUBTOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articulos as $articulo)
                <tr>
                    <td class="monospace">{{ $articulo->codigo }}</td>
                    <td>{{ $articulo->nombre }}</td>
                    <td class="monospace">{{ $articulo->pivot->cantidad }}</td>
                    <td class="monospace">${{ number_format($articulo->pivot->valor_unitario) }}</td>
                    <td class="monospace">${{ number_format($articulo->pivot->descuento) }}</td>
                    <td class="monospace">${{ number_format(($articulo->pivot->cantidad * $articulo->pivot->valor_unitario) - $articulo->pivot->descuento) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="calculations">
            <div class="calculation-row">
                <span>Subtotal:</span>
                <span class="valor">${{ number_format($subtotal) }}</span>
            </div>
            <div class="calculation-row">
                <span>Crédito ({{ $venta->porcentaje_credito }}%):</span>
                <span class="valor">${{ number_format($valorCredito) }}</span>
            </div>
            <div class="calculation-row">
                <span>Total Final:</span>
                <span class="valor">${{ number_format($venta->valor_total) }}</span>
            </div>
        </div>
      
        
       
    </div>
</body>
</html>