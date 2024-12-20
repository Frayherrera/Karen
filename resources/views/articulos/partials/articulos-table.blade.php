@if($articulos->isEmpty())
    <div class="text-center bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative">
        No se encontraron artículos.
    </div>
@else
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Código</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nombre</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Categoria</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Valor Costo</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Valor Venta</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Stock</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Estado del Stock</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($articulos as $articulo)
                    <tr class="hover:bg-gray-100">
                        <td class="py-4 px-6">{{ $articulo->codigo }}</td>
                        <td class="py-4 px-6">{{ $articulo->nombre }}</td>
                        <td class="py-4 px-6">{{ $articulo->categoria->nombre ?? 'Sin categoría' }}</td>
                        <td class="py-4 px-6">${{ number_format($articulo->valor_costo, 2) }}</td>
                        <td class="py-4 px-6">${{ number_format($articulo->valor_venta, 2) }}</td>
                        <td class="py-4 px-6">{{ $articulo->stock }}</td>
                        <td class="py-4 px-6">
                            @if($articulo->stock > 15)
                                <span class="inline-block px-2 py-1 text-xs font-semibold text-green-700 bg-green-200 rounded-full">Sobrante</span>
                            @elseif($articulo->stock <= 15 && $articulo->stock >= 4)
                                <span class="inline-block px-2 py-1 text-xs font-semibold text-yellow-700 bg-yellow-200 rounded-full">Poco Stock</span>
                            @else
                                <span class="inline-block px-2 py-1 text-xs font-semibold text-red-700 bg-red-200 rounded-full">Comprar Ya</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex space-x-2">
                                <a href="{{ route('articulos.show', $articulo->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-xs">Ver</a>
                                <a href="{{ route('articulos.edit', $articulo->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded text-xs">Editar</a>
                                <button 
                                    onclick="openModal('{{ $articulo->codigo }}', '{{ $articulo->nombre }}')" 
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-xs">
                                    Agregar Stock
                                </button>
                                <form id="delete-form-{{ $articulo->id }}" action="{{ route('articulos.destroy', $articulo->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete({{ $articulo->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Paginador -->
    <div class="mt-4">
        {{ $articulos->links() }}
    </div>
@endif