<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-900 to-gray-800 py-10 sm:px-6 lg:px-8 text-white">
        <div class="max-w-2xl mx-auto bg-gray-900 p-8 rounded-lg shadow-lg">
            <h2 class="text-center text-3xl font-bold mb-6">Nuevo Producto</h2>

            <div class="text-center mb-4">
                <a href="{{ route('producto.index') }}" class="bg-blue-600 hover:bg-blue-800 text-white font-semibold py-2 px-4 rounded">
                    ← Volver
                </a>
            </div>

            @if($errors->any())
                <div class="mb-6 bg-red-500 text-white p-4 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('producto.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block font-semibold mb-1">Descripción:</label>
                    <input type="text" name="descripcion" required class="w-full px-3 py-2 rounded bg-gray-800 text-white border border-gray-600">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Modelo:</label>
                    <input type="text" name="modelo" value="{{ old('modelo', '') }}" class="w-full px-3 py-2 rounded bg-gray-800 text-white border border-gray-600">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Cantidad:</label>
                    <input type="number" name="cantidad" value="{{ old('cantidad', 0) }}" class="w-full px-3 py-2 rounded bg-gray-800 text-white border border-gray-600">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Marca:</label>
                    <select name="marca_id"  class="w-full px-3 py-2 rounded bg-gray-800 text-white border border-gray-600">
                        <option value="">Sin marca</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <h4 class="text-xl font-semibold mt-6 mb-2 border-b border-gray-600 pb-1">Precios:</h4>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold mb-1">Precio de Compra:</label>
                        <input type="number" step="0.01" name="preciodecompra" value="{{ old('preciodecompra', 0) }}" class="w-full px-3 py-2 rounded bg-gray-800 text-white border border-gray-600">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Precio Venta Mayor:</label>
                        <input type="number" step="0.01" name="precioventamayor" value="{{ old('precioventamayor', 0) }}" class="w-full px-3 py-2 rounded bg-gray-800 text-white border border-gray-600">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Precio Técnico:</label>
                        <input type="number" step="0.01" name="preciotecnico" value="{{ old('preciotecnico', 0) }}" class="w-full px-3 py-2 rounded bg-gray-800 text-white border border-gray-600">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">PSF (Precio sin factura):</label>
                        <input type="number" step="0.01" name="psf" value="{{ old('psf', 0) }}" class="w-full px-3 py-2 rounded bg-gray-800 text-white border border-gray-600">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">PS (Precio con factura):</label>
                        <input type="number" step="0.01" name="ps" value="{{ old('ps', 0) }}" class="w-full px-3 py-2 rounded bg-gray-800 text-white border border-gray-600">
                    </div>
                </div>

                <div class="text-center mt-6">
                    <button type="submit" class="bg-green-600 hover:bg-green-800 text-white font-bold py-2 px-6 rounded">
                        Crear Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
