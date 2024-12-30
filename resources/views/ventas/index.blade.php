@extends('layouts.app')

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Ventas</title>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .dancing-script {
            font-family: 'Dancing Script', cursive;
        }
        
        .custom-shadow {
            box-shadow: 0 4px 6px -1px rgba(219, 39, 119, 0.1), 0 2px 4px -1px rgba(219, 39, 119, 0.06);
        }
        
        .table-header {
            background: linear-gradient(to right, #ec4899, #db2777);
            color: white;
        }
        
        .btn-hover-effect:hover {
            transform: translateY(-1px);
            transition: all 0.3s ease;
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            background-color: white;
            border-radius: 0.5rem;
            margin: 2rem 0;
        }

        .empty-state-icon {
            font-size: 3rem;
            color: #db2777;
            margin-bottom: 1rem;
        }
    </style>
</head>

@section('content')
<body class="bg-pink-50">
    @if(session('success'))
        <div class="bg-pink-100 border border-pink-400 text-pink-700 px-4 py-3 rounded relative mb-4 custom-shadow" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="container mt-5">
        <h1 class="text-4xl font-bold text-center my-6 dancing-script text-pink-600">Lista de Ventas</h1>
        
        <div class="flex gap-4 mb-6">
            <a href="{{ url('/articulos') }}" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded custom-shadow btn-hover-effect">
                <i class="fas fa-arrow-left mr-2"></i>Atrás
            </a>
            <a href="{{ route('salida') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded custom-shadow btn-hover-effect">
                <i class="fas fa-plus mr-2"></i>Nueva venta
            </a>
        </div>

        @if($ventas->isEmpty())
            <div class="empty-state custom-shadow">
                <i class="fas fa-shopping-cart empty-state-icon"></i>
                <h2 class="text-2xl font-semibold text-pink-600 mb-2">No hay ventas registradas</h2>
                <p class="text-gray-600 mb-4">Aún no se han realizado ventas en el sistema.</p>
                <a href="{{ route('salida') }}" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded custom-shadow btn-hover-effect">
                    <i class="fas fa-plus mr-2"></i>Realizar primera venta
                </a>
            </div>
        @else
            <div class="bg-white rounded-lg overflow-hidden custom-shadow">
                <table class="w-full table-auto">
                    <thead class="table-header">
                        <tr>
                            <th class="px-4 py-3">ID</th>
                            <th class="px-4 py-3">Fecha de Venta</th>
                            
                            
                            <th class="px-4 py-3">Tipo</th>
                           
                            <th class="px-4 py-3">Utilidad</th>
                            <th class="px-4 py-3">Total</th>
                            <th class="px-4 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventas as $venta)
                            <tr class="hover:bg-pink-50 transition-colors">
                                <td class="border-t px-4 py-3">{{ $venta->id }}</td>
                                <td class="border-t px-4 py-3">{{ $venta->fecha_venta }}</td>
                               
                                <td class="border-t px-4 py-3">{{ ucfirst($venta->tipo) }}</td>
                                <td class="border-t px-4 py-3">${{ number_format($venta->utilidad, 2) }}</td>
                                <td class="border-t px-4 py-3">${{ number_format($venta->valor_total, 2) }}</td>
                                <td class="border-t px-4 py-3">
                                    <a href="{{ route('ventas.ticket', $venta->id) }}" 
                                       class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-1 px-3 rounded text-sm custom-shadow btn-hover-effect">
                                        <i class="fas fa-receipt mr-1"></i>Ticket
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $ventas->links() }}
            </div>
        @endif
    </div>

    <script>
        // Personalización de SweetAlert2 con tema rosa
        const Toast = Swal.mixin({
            customClass: {
                confirmButton: 'bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded mx-2',
                cancelButton: 'bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mx-2'
            },
            buttonsStyling: false
        });
    </script>
</body>
@endsection
</html>