@if ($ventas->isEmpty())
    <div class="empty-state custom-shadow">
        <i class="fas fa-shopping-cart empty-state-icon"></i>
        <h2 class="text-2xl font-semibold text-pink-600 mb-2">No hay ventas registradas</h2>
        <p class="text-gray-600 mb-4">No se encontraron ventas con ese criterio de búsqueda.</p>
        <a href="{{ route('salida') }}"
            class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded custom-shadow btn-hover-effect">
            <i class="fas fa-plus mr-2"></i>Realizar primera venta
        </a>
    </div>
@else
    <div class="bg-white rounded-lg overflow-hidden custom-shadow">
        <table class="w-full table-auto">
            <thead class="table-header">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Estado</th>
                    <th class="px-4 py-3">Cliente</th>
                    <th class="px-4 py-3">Fecha de Venta</th>
                    <th class="px-4 py-3">Tipo</th>
                    <th class="px-4 py-3 text-right">Utilidad</th>
                    <th class="px-4 py-3 text-right">Total</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $venta)
                    <tr class="hover:bg-pink-50 transition-colors">
                        <td class="border-t px-4 py-3">{{ str_pad($venta->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td class="border-t px-4 py-3">
                            <span class="inline-block w-3 h-3 rounded-full @if ($venta->estado === 'pagado') bg-green-600 @else bg-yellow-300 @endif"></span>
                        </td>
                        <td class="border-t px-4 py-3">{{ $venta->nombre_cliente }}</td>
                        <td class="border-t px-4 py-3">{{ $venta->fecha_venta }}</td>
                        <td class="border-t px-4 py-3">{{ ucfirst($venta->tipo) }}</td>
                        <td class="border-t px-4 py-3 text-right">${{ number_format($venta->utilidad, 0) }}</td>
                        <td class="border-t px-4 py-3 text-right">${{ number_format($venta->valor_total, 0) }}</td>
                        <td class="border-t px-4 py-3 text-center">
                            <a href="{{ route('ventas.ticket', $venta->id) }}"
                                class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-1 px-3 rounded text-sm custom-shadow btn-hover-effect">
                                <i class="fas fa-receipt mr-1"></i>Ticket
                            </a>
                            <button onclick="cambiarEstado({{ $venta->id }})"
                                class="ml-2 bg-gray-500 hover:bg-gray-600 text-white font-bold py-1 px-3 rounded text-sm custom-shadow btn-hover-effect"
                                @if ($venta->tipo === 'contado') disabled @endif>
                                Cambiar Estado
                            </button>
                            <button onclick="confirmarEliminar({{ $venta->id }})"
                                class="ml-2 bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-sm custom-shadow btn-hover-effect">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                <tr class="bg-pink-50 font-bold border-t-2 border-pink-200">
                    <td class="px-4 py-3">Total</td>
                    <td colspan="4"></td>
                    <td class="px-4 py-3 text-right">
                        ${{ number_format($ventas->sum('utilidad'), 0) }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        ${{ number_format($ventas->sum('valor_total'), 0) }}
                    </td>
                    <td class="px-4 py-3"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <style>
        button:disabled {
            background-color: #d1d5db;
            cursor: not-allowed;
            opacity: 0.6;
        }
    </style>

    <script>
        function cambiarEstado(id) {
            fetch(`/ventas/cambiar-estado/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            })
            .then(response => response.json())
            .then(data => {
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>

    <div class="mt-6">
        {{ $ventas->links() }}
    </div>
@endif