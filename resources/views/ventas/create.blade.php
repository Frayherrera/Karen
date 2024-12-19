<form action="{{ route('ventas.store') }}" method="POST">
    @csrf
    <input type="text" name="codigo" placeholder="Código del producto" required>
    <input type="number" name="cantidad" placeholder="Cantidad" required>
    <input type="number" name="valor_unitario" placeholder="Valor unitario" step="0.01" required>
    <input type="number" name="descuento" placeholder="descuento" step="0.01" >
    <select name="tipo" required>
        <option value="contado">Contado</option>
        <option value="credito">Crédito</option>
    </select>
    <input type="number" name="dias_credito" placeholder="Días de crédito (solo para crédito)">
    <button type="submit">Registrar Venta</button>
</form>
