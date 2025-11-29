<x-app-layout>
    <div class="flex justify-center py-10 px-4 bg-white">
        <div class="w-full max-w-3xl bg-white shadow-lg rounded-lg border border-blue-300 p-8">
            <h2 class="text-3xl font-bold text-blue-800 text-center mb-8">Editar Producto</h2>

            @if($errors->any())
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-800 p-4 rounded">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('producto.update', $producto->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Datos del producto --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-blue-900 mb-1">Descripción:</label>
                        <input type="text" name="descripcion" value="{{ old('descripcion', $producto->descripcion) }}" required class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-blue-400">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-blue-900 mb-1">Modelo:</label>
                        <input type="text" name="modelo" value="{{ old('modelo', $producto->modelo) }}" required class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-blue-400">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-blue-900 mb-1">Cantidad:</label>
                        <input type="number" name="cantidad" value="{{ old('cantidad', $producto->cantidad) }}" required class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-blue-400">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-blue-900 mb-1">Marca:</label>
                        <select name="marca_id" required class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-blue-400">
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ $producto->marca_id == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @php
                    $precio = optional($producto->precios)->first();
                    $tipo = optional($precio?->tipodeprecio)->first();
                @endphp

                <hr class="my-6 border-t border-blue-300">

                {{-- Sección de Precios --}}
                <h3 class="text-xl font-bold text-blue-800 mb-4 text-center">Precios del Producto</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-blue-900 mb-1">Precio de Compra:</label>
                        <input type="number" step="0.01" name="preciodecompra" value="{{ old('preciodecompra', $tipo->preciodecompra ?? '') }}" required class="w-full border border-gray-300 rounded px-4 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-blue-900 mb-1">Precio Venta Mayor:</label>
                        <input type="number" step="0.01" name="precioventamayor" value="{{ old('precioventamayor', $tipo->precioventamayor ?? '') }}" required class="w-full border border-gray-300 rounded px-4 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-blue-900 mb-1">Precio Técnico:</label>
                        <input type="number" step="0.01" name="preciotecnico" value="{{ old('preciotecnico', $tipo->preciotecnico ?? '') }}" required class="w-full border border-gray-300 rounded px-4 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-blue-900 mb-1">PSF (Sin Factura):</label>
                        <input type="number" step="0.01" name="psf" value="{{ old('psf', $tipo->psf ?? '') }}" required class="w-full border border-gray-300 rounded px-4 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-blue-900 mb-1">PS (Con Factura):</label>
                        <input type="number" step="0.01" name="ps" value="{{ old('ps', $tipo->ps ?? '') }}" required class="w-full border border-gray-300 rounded px-4 py-2">
                    </div>
                </div>

                {{-- Botones --}}
                <div class="flex justify-center mt-8 space-x-4">
                    <button type="submit" class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-6 rounded transition duration-200">
                        Guardar Cambios
                    </button>
                    <a href="{{ route('producto.index') }}" class="text-red-600 hover:text-red-800 font-semibold py-2 px-4">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
