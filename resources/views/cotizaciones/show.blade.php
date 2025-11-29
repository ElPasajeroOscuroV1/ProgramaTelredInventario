<x-app-layout>
    <div class="container mx-auto px-4 py-8 text-white">
        <h1 class="text-2xl font-bold mb-6">Detalle de Cotización #{{ $cotizacion->id }}</h1>

        {{-- Información del cliente --}}
        <div class="mb-4 text-white bg-gray-800 p-4 rounded">
            <h2 class="text-lg font-bold mb-2">Cliente</h2>
            <p><strong>Nombre:</strong> {{ $cotizacion->cliente->nombre }}</p>
            <p><strong>Teléfono:</strong> {{ $cotizacion->cliente->telefono }}</p>
            <p><strong>Tipo:</strong> {{ ucfirst($cotizacion->cliente->tipo) }}</p>
            <p><strong>Código:</strong> {{ $cotizacion->cliente->codigo }}</p>
        </div>

        {{-- Tabla de productos --}}
        <table class="w-full table-auto text-black bg-white rounded mb-4">
            <thead>
                <tr class="bg-gray-300">
                    <th>Producto</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $subtotalGeneral = 0; @endphp
                @foreach ($cotizacion->productos as $producto)
                    @php
                        $subtotal = $producto->pivot->precio_unitario * $producto->pivot->cantidad;
                        $subtotalGeneral += $subtotal;
                    @endphp
                    <tr>
                        <td class="border px-4 py-2">{{ $producto->descripcion }} ({{ $producto->modelo }})</td>
                        <td class="border px-4 py-2">{{ number_format($producto->pivot->precio_unitario, 2) }} Bs</td>
                        <td class="border px-4 py-2">{{ $producto->pivot->cantidad }}</td>
                        <td class="border px-4 py-2">{{ number_format($subtotal, 2) }} Bs</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Aplicar descuento --}}
        <div class="mb-4 text-white bg-gray-700 p-4 rounded">
            <h2 class="text-lg font-bold mb-2">Total</h2>

            {{-- Subtotal visible solo en pantalla --}}
            <p class="subtotal mt-2"><strong>Subtotal:</strong> {{ number_format($subtotalGeneral, 2) }} Bs</p>

            {{-- Formulario de descuento --}}
            <form method="POST" action="{{ route('cotizaciones.aplicar_descuento', $cotizacion->id) }}" id="descuento-form" class="mt-2">
                @csrf
                <label for="descuento" class="mr-2">Descuento (%):</label>
                <input type="number" name="porcentaje" id="descuento" class="text-black rounded p-1"
                       min="0" max="100" value="{{ old('porcentaje', $cotizacion->porcentaje_descuento ?? 0) }}" />
                <input type="hidden" name="total_con_descuento" id="total_con_descuento_hidden">
                <button type="submit" class="ml-2 bg-green-600 px-3 py-1 rounded text-white">Guardar</button>
            </form>

            {{-- Total visible en pantalla --}}
            <p class="mt-2 total-con-descuento"><strong>Total:</strong>
                <span id="totalConDescuento">{{ number_format($cotizacion->total_con_descuento ?? $subtotalGeneral, 2) }}</span> Bs
            </p>

            {{-- Solo visible en impresión --}}
            <p class="total-descuento-print" style="display:none;">
                <strong>Total:</strong> <span id="totalDescuentoPrint">{{ number_format($cotizacion->total_con_descuento ?? $subtotalGeneral, 2) }}</span> Bs
            </p>
        </div>

        <button onclick="window.print()" class="bg-blue-700 text-white px-4 py-2 rounded">Imprimir</button>
        <a href="{{ route('cotizaciones.index') }}" class="ml-4 text-white underline">Volver</a>
    </div>

    {{-- Ocultar cosas al imprimir --}}
        <style>
        @media print {
            /* Ocultar elementos no deseados al imprimir */
            .subtotal,
            #descuento,
            #descuento-form,
            .total-con-descuento,
            h2,           /* Oculta títulos como "Total" */
            label,        /* Oculta "Descuento (%)" */
            #descuento-form button,
            button,       /* Oculta botón de imprimir */
            a {           /* Oculta botón de volver */
                display: none !important;
            }

            /* Mostrar solo el total final limpio */
            .total-descuento-print {
                display: block !important;
                color: black;
                background: white;
                padding: 10px;
                font-size: 1.5rem;
                font-weight: bold;
            }
        }
    </style>



    {{-- Script para calcular descuento --}}
    <script>
        function actualizarTotales() {
            const descuentoInput = document.getElementById('descuento');
            let descuento = parseFloat(descuentoInput.value);
            if (isNaN(descuento) || descuento < 0) descuento = 0;
            if (descuento > 100) descuento = 100;

            const subtotal = {{ $subtotalGeneral }};
            const totalConDescuento = subtotal - (subtotal * (descuento / 100));

            document.getElementById('totalConDescuento').textContent = totalConDescuento.toFixed(2);
            document.getElementById('totalDescuentoPrint').textContent = totalConDescuento.toFixed(2);
            document.getElementById('total_con_descuento_hidden').value = totalConDescuento.toFixed(2);
        }

        document.getElementById('descuento').addEventListener('input', actualizarTotales);
        actualizarTotales();
    </script>
</x-app-layout>
