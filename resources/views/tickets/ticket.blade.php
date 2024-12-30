<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Venta</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h2>Ticket de Venta</h2>
    <p><strong>Fecha:</strong> {{ $venta->fecha_venta }}</p>
    <p><strong>Código:</strong> {{ $venta->codigo }}</p>
    <p><strong>Producto:</strong> {{ $articulo->nombre }}</p>
    
    <table>
        <thead>
            <tr>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Descuento</th>
                <th>N° Coutas</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $venta->cantidad }}</td>
                <td>${{ number_format($venta->valor_unitario, 2) }}</td>
                <td>${{ number_format($venta->descuento, 2) }}</td>
                <td>{{ number_format($venta->dias_credito) }}</td>
                <td>${{ number_format($venta->valor_total, 2) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
