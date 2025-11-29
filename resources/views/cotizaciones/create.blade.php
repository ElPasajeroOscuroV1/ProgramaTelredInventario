<x-app-layout>
    <div class="container mx-auto px-4 py-8 text-white">
        <h1 class="text-2xl font-bold mb-6">Nueva Cotización</h1>

        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('cotizaciones.store') }}">
            @csrf

            {{-- Seleccionar cliente existente --}}
            <div class="mb-6">
                <label class="block font-bold mb-2">Seleccionar Cliente:</label>
                <select name="cliente_id" class="w-full text-black rounded p-2">
                    <option value="">-- Seleccionar cliente existente --</option>
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->nombre }} - {{ $cliente->direccion }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Crear nuevo cliente --}}
            <div class="mb-6">
                <label class="block font-bold mb-2">O Crear Nuevo Cliente:</label>
                <input type="text" name="nuevo_cliente[nombre]" placeholder="Nombre" class="w-full text-black rounded p-2 mb-2">
                <input type="text" name="nuevo_cliente[direccion]" placeholder="Dirección" class="w-full text-black rounded p-2 mb-2">
                <input type="text" name="nuevo_cliente[telefono]" placeholder="Teléfono" class="w-full text-black rounded p-2 mb-2">

                <label class="block font-bold mb-2 mt-4">Tipo de Cliente:</label>
                <select name="nuevo_cliente[tipo]" class="w-full text-black rounded p-2">
                    <option value="">-- Seleccionar tipo --</option>
                    <option value="tecnico">Técnico</option>
                    <option value="normal">Cliente Normal</option>
                </select>
            </div>

            {{-- Tabla dinámica de productos --}}
            <h2 class="text-xl font-bold mb-4">Productos</h2>
            <table class="w-full table-auto text-black bg-white rounded mb-4" id="productos-table">
                <thead>
                    <tr class="bg-gray-300">
                        <th>Producto</th>
                        <th>Tipo de Precio</th>
                        <th>Precio Unitario</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            <button type="button" onclick="agregarProducto()" class="bg-green-600 text-white px-4 py-2 rounded">+ Aumentar Producto</button>

            <div class="mt-6">
                <label class="block font-bold text-lg mb-2">Total:</label>
                <input type="text" id="total" name="total" class="w-full text-black rounded p-2" readonly>
            </div>

            <div class="mt-8">
                <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded">Guardar Cotización</button>
                <a href="{{ route('cotizaciones.index') }}" class="ml-4 text-gray-300 hover:underline">Cancelar</a>
            </div>
        </form>
    </div>

    {{-- Script para productos dinámicos --}}
    <script>
        const productos = @json($productos);

        function agregarProducto() {
            const tbody = document.querySelector("#productos-table tbody");
            const rowIndex = tbody.rows.length;

            const row = document.createElement("tr");
            row.innerHTML = `
                <td>
                    <select name="productos[${rowIndex}][producto_id]" class="producto-select border rounded p-1 w-full" onchange="actualizarPrecios(this, ${rowIndex})">
                        <option value="">-- Seleccionar --</option>
                        ${productos.map(p => `<option value="${p.id}">${p.descripcion} (${p.modelo})</option>`).join('')}
                    </select>
                </td>
                <td>
                    <select name="productos[${rowIndex}][tipo]" class="tipo-select border rounded p-1 w-full" onchange="actualizarPrecioUnitario(${rowIndex})">
                        <option value="preciodecompra">Compra</option>
                        <option value="precioventamayor">Mayor</option>
                        <option value="preciotecnico" selected>Técnico</option>
                        <option value="psf">Sin Factura</option>
                        <option value="ps">Con Factura</option>
                    </select>
                </td>
                <td>
                    <input type="text" name="productos[${rowIndex}][precio]" class="precio border rounded p-1 w-full" readonly>
                </td>
                <td>
                    <input type="number" name="productos[${rowIndex}][cantidad]" value="1" min="1" class="cantidad border rounded p-1 w-full" oninput="actualizarSubtotal(${rowIndex})">
                </td>
                <td>
                    <input type="text" name="productos[${rowIndex}][subtotal]" class="subtotal border rounded p-1 w-full" readonly>
                </td>
                <td>
                    <button type="button" onclick="eliminarProducto(this)" class="bg-red-600 text-white px-2 py-1 rounded">Eliminar</button>
                </td>
            `;

            tbody.appendChild(row);
        }

        function actualizarPrecios(select, index) {
            const productoId = select.value;
            const producto = productos.find(p => p.id == productoId);

            if (producto) {
                const tipoSelect = document.getElementsByName(`productos[${index}][tipo]`)[0];
                const precioInput = document.getElementsByName(`productos[${index}][precio]`)[0];

                const tipo = tipoSelect.value;
                const precios = producto.precios?.[0]?.tipodeprecio?.[0];

                if (precios && precios[tipo] !== undefined) {
                    precioInput.value = precios[tipo];
                } else {
                    precioInput.value = 0;
                }

                actualizarSubtotal(index);
            }
        }

        function actualizarPrecioUnitario(index) {
            const productoSelect = document.getElementsByName(`productos[${index}][producto_id]`)[0];
            actualizarPrecios(productoSelect, index);
        }

        function actualizarSubtotal(index) {
            const precio = parseFloat(document.getElementsByName(`productos[${index}][precio]`)[0].value || 0);
            const cantidad = parseFloat(document.getElementsByName(`productos[${index}][cantidad]`)[0].value || 0);
            const subtotalInput = document.getElementsByName(`productos[${index}][subtotal]`)[0];

            const subtotal = precio * cantidad;
            subtotalInput.value = subtotal.toFixed(2);

            actualizarTotal();
        }

        function actualizarTotal() {
            let total = 0;
            document.querySelectorAll('.subtotal').forEach(input => {
                total += parseFloat(input.value || 0);
            });
            document.getElementById('total').value = total.toFixed(2);
        }

        function eliminarProducto(btn) {
            const row = btn.closest('tr');
            row.remove();
            actualizarTotal();
        }

        window.onload = agregarProducto;
    </script>
</x-app-layout>