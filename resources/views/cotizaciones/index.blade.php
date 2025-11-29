<x-app-layout>
    <div class="container mx-auto py-8 text-white">
        <h1 class="text-3xl font-bold mb-6 text-center">Listado de Cotizaciones</h1>

        <div class="mb-4">
            <a href="{{ route('cotizaciones.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">Nueva Cotización</a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full table-auto border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-800">
                    <th class="border py-2 px-2 text-white">ID</th>
                    <th class="border py-2 px-2 text-white">Cliente</th>
                    <th class="border py-2 px-2 text-white">Dirección</th>
                    <th class="border py-2 px-2 text-white">Usuario</th>
                    <th class="border py-2 px-2 text-white">Fecha</th>
                    <th class="border py-2 px-2 text-white">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cotizaciones as $cotizacion)
                    <tr class="bg-gray-700">
                        <td class="border p-2">{{ $cotizacion->id }}</td>
                        <td class="border p-2">{{ $cotizacion->cliente->nombre }}</td>
                        <td class="border p-2">{{ $cotizacion->cliente->direccion ?? 'Sin dirección' }}</td>
                        <td class="border p-2">{{ $cotizacion->user->name }}</td>
                        <td class="border p-2">{{ $cotizacion->fecha }}</td>
                        <td class="border p-2 space-x-1">
                            <a href="{{ route('cotizaciones.show', $cotizacion->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded">Ver</a>
                            <a href="{{ route('cotizaciones.edit', $cotizacion->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Editar</a>
                            <form action="{{ route('cotizaciones.destroy', $cotizacion->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta cotización?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
