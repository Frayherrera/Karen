@if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                
            </div>
        @endif
<form action="{{ route('entradas.store') }}" method="POST">
    @csrf
    <input type="text" name="codigo" placeholder="Código del producto" required>
    <input type="number" name="cantidad" placeholder="Cantidad" required>
    <input type="number" name="valor_costo" placeholder="Valor de costo" step="0.01" required>
    <button type="submit">Registrar Entrada</button>
</form>
