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
                    <th class="px-4 py-3">Utilidad</th>
                    <th class="px-4 py-3">Total</th>
                    <th class="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $venta)
                    <tr class="hover:bg-pink-50 transition-colors">
                        <td class="border-t px-4 py-3">{{ $venta->id }}</td>
                        <td class="border-t px-4 py-3"> <span
                                class="inline-block w-3 h-3 rounded-full @if ($venta->estado === 'pagado') bg-green-600 @else bg-yellow-300 @endif">
                            </span> </td> <!-- Estado visual -->
                        <td class="border-t px-4 py-3">{{ $venta->nombre_cliente }}</td>
                        <td class="border-t px-4 py-3">{{ $venta->fecha_venta }}</td>
                        <td class="border-t px-4 py-3">{{ ucfirst($venta->tipo) }}</td>
                        <td class="border-t px-4 py-3">${{ number_format($venta->utilidad, 0) }}</td>
                        <td class="border-t px-4 py-3">${{ number_format($venta->valor_total, 0) }}</td>
                        <td class="border-t px-4 py-3"> <a href="{{ route('ventas.ticket', $venta->id) }}"
                                class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-1 px-3 rounded text-sm custom-shadow btn-hover-effect">
                                <i class="fas fa-receipt mr-1"></i>Ticket </a> <button
                                onclick="cambiarEstado({{ $venta->id }})"
                                class="ml-2 bg-gray-500 hover:bg-gray-600 text-white font-bold py-1 px-3 rounded text-sm custom-shadow btn-hover-effect">
                                Cambiar Estado </button> </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        function cambiarEstado(id) {
            // Aquí puedes realizar una llamada AJAX para actualizar el estado en el servidor
            fetch(`/ventas/cambiar-estado/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    // Aquí puedes actualizar la interfaz de usuario para reflejar el nuevo estado
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
