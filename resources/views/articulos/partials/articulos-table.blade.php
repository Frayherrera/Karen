@if ($articulos->isEmpty())
    <div class="text-center bg-pink-50 border border-pink-300 text-pink-700 px-4 py-3 rounded-lg shadow-sm">
        No se encontraron artículos.
    </div>
@else
    <div class="overflow-x-auto shadow-lg rounded-lg">
        <table class="min-w-full bg-white border border-pink-100">
            <thead class="bg-gradient-to-r from-pink-50 to-pink-100">
                <tr>
                    <th class="py-3 px-6 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Código</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Nombre</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Categoria</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Valor Costo</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Valor Venta</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Stock</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Estado del Stock</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-pink-50">
                @foreach ($articulos as $articulo)
                    <tr class="hover:bg-pink-50 transition duration-150">
                        <td class="py-4 px-6">{{ $articulo->codigo }}</td>
                        <td class="py-4 px-6">{{ $articulo->nombre }}</td>
                        <td class="py-4 px-6">{{ $articulo->categoria->nombre ?? 'Sin categoría' }}</td>
                        <td class="py-4 px-6">${{ number_format($articulo->valor_costo, 0) }}</td>
                        <td class="py-4 px-6">${{ number_format($articulo->valor_venta, 0) }}</td>
                        <td class="py-4 px-6">{{ $articulo->stock }}</td>
                        <td class="py-4 px-6">
                            @if ($articulo->stock > 15)
                                <span class="inline-block px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full shadow-sm">
                                    <i class="fas fa-check-circle mr-1"></i>Sobrante
                                </span>
                            @elseif($articulo->stock <= 15 && $articulo->stock >= 4)
                                <span class="inline-block px-3 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded-full shadow-sm">
                                    <i class="fas fa-exclamation-circle mr-1"></i>Poco Stock
                                </span>
                            @else
                                <span class="inline-block px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full shadow-sm">
                                    <i class="fas fa-times-circle mr-1"></i>Comprar Ya
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex space-x-3">
                                <a href="{{ route('articulos.edit', $articulo->id) }}"
                                    class="text-pink-500 hover:text-pink-700 transition duration-150" 
                                    title="Editar">
                                    <i class="fas fa-edit text-lg"></i>
                                </a>
                                
                                {{-- <button onclick="openVentaModal('{{ $articulo->codigo }}', '{{ $articulo->nombre }}')"
                                    class="text-pink-500 hover:text-pink-700 transition duration-150"
                                    title="Vender">
                                    <i class="fas fa-shopping-cart text-lg"></i>
                                </button> --}}

                                <button onclick="openModal('{{ $articulo->codigo }}', '{{ $articulo->nombre }}')"
                                    class="text-pink-500 hover:text-pink-700 transition duration-150"
                                    title="Agregar Stock">
                                    <i class="fas fa-plus-circle text-lg"></i>
                                </button>

                                <form id="delete-form-{{ $articulo->id }}"
                                    action="{{ route('articulos.destroy', $articulo->id) }}" 
                                    method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                        onclick="confirmDelete({{ $articulo->id }})"
                                        class="text-pink-500 hover:text-pink-700 transition duration-150"
                                        title="Eliminar">
                                        <i class="fas fa-trash-alt text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Paginador con estilo rosa -->
    <div class="mt-4">
        {{ $articulos->links() }}
    </div>
@endif