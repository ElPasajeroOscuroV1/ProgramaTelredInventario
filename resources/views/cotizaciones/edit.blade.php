<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6 text-center">Editar Cotización</h1>

        <div class="mb-4">
            <a href="{{ route('cotizaciones.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Volver</a>
        </div>

        <form action="{{ route('cotizaciones.update', $cotizacion->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="cliente_id" class="block font-medium">Cliente:</label>
                <select name="cliente_id" id="cliente_id" class="border rounded px-3 py-2 w-full" required>
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ $cotizacion->cliente_id == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="fecha" class="block font-medium">Fecha:</label>
                <input type="date" name="fecha" id="fecha" class="border rounded px-3 py-2 w-full" value="{{ $cotizacion->fecha }}" required>
            </div>

            <div class="mb-4">
                <label for="estado" class="block font-medium">Estado:</label>
                <select name="estado" id="estado" class="border rounded px-3 py-2 w-full">
                    <option value="pendiente" {{ $cotizacion->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="aprobada" {{ $cotizacion->estado == 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                    <option value="rechazada" {{ $cotizacion->estado == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Actualizar Cotización</button>
            </div>
        </form>
    </div>
</x-app-layout>
