<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticket de Venta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
            color: #333;
        }
        h1 {
            color: #4c6aaf;
            text-align: center;
        }
        p {
            font-size: 14px;
            line-height: 1.6;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #4c6aaf;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .totals {
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ticket de Venta</h1>
        <p><strong>Código de Venta:</strong> {{ $venta->id }}</p>
        <p><strong>Fecha de Venta:</strong> {{ $venta->fecha_venta }}</p>
        <p><strong>Tipo de Venta:</strong> {{ $venta->tipo }}</p>
        <p><strong>Nombre Cliente:</strong> {{ $venta->nombre_cliente }}</p>
        <p><strong>Cedula Cliente:</strong> {{ $venta->cedula_cliente }}</p>
        <p><strong>Dirección Cliente:</strong> {{ $venta->direccion_cliente }}</p>
        <p><strong>Telefono Cliente:</strong> {{ $venta->telefono_cliente }}</p>


        
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Valor Unitario</th>
                    <th>Descuento</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articulos as $articulo)
                <tr>
                    <td>{{ $articulo->codigo }}</td>
                    <td>{{ $articulo->nombre }}</td>
                    <td>{{ $articulo->pivot->cantidad }}</td>
                    <td>{{ $articulo->pivot->valor_unitario }}</td>
                    <td>{{ $articulo->pivot->descuento }}</td>
                    <td>{{ ($articulo->pivot->cantidad * $articulo->pivot->valor_unitario) - $articulo->pivot->descuento }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <p><strong>Valor Total:</strong> {{ $venta->valor_total }}</p>
        
        </div>
    </div>
</body>
</html>
