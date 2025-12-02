<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <style>
        .bg-gradient {
            background: linear-gradient(to right, #1f2937, #4b5563); /* Azul oscuro a gris oscuro */
        }

        .table-bg {
            background-color: #1e1e2f; /* fondo de tabla más oscuro */
        }

        .table-head {
            background-color: #374151; /* gris oscuro */
        }

        .text-light {
            color: #f3f4f6; /* blanco grisáceo */
        }

        .btn-blue {
            background-color: #2563eb; /* azul */
        }

        .btn-blue:hover {
            background-color: #1e40af;
        }

        .btn-red {
            background-color: #dc2626; /* rojo */
        }

        .btn-red:hover {
            background-color: #991b1b;
        }

        .btn-orange {
            background-color: #f97316;
        }

        .btn-orange:hover {
            background-color: #c2410c;
        }

        .btn-yellow {
            background-color: #eab308;
        }

        .btn-yellow:hover {
            background-color: #ca8a04;
        }
    </style>
</head>
<body>
<x-app-layout>
    <div class="flex items-center justify-center min-h-screen bg-gradient px-4 py-8">
        <div class="w-full max-w-6xl bg-gradient p-6 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold mb-6 text-light text-center">Lista de Productos</h1>

            <div class="flex justify-between mb-6">
                <a href="{{ route('producto.create') }}" class="btn-orange text-white px-4 py-2 rounded">Nuevo Producto</a>
                <a href="{{ route('dashboard') }}" class="btn-blue text-white px-4 py-2 rounded">Volver al inicio</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-center table-bg rounded text-light">
                    <thead class="table-head text-white">
                        <tr>
                            <th class="py-2">ID</th>
                            <th class="py-2">Descripción</th>
                            <th class="py-2">Modelo</th>
                            <th class="py-2">Cantidad</th>
                            <th class="py-2">Marca</th>
                            <th class="py-2">Compra</th>
                            <th class="py-2">Mayor</th>
                            <th class="py-2">Técnico</th>
                            <th class="py-2">S/F</th>
                            <th class="py-2">C/F</th>
                            <th class="py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach ($product as $productos)
                            @php
                                $precio = $productos->precios->first();
                                $tipo = $precio?->tipodeprecio?->first();
                            @endphp
                            <tr class="border-b border-gray-600">
                                <td class="py-2">{{ $i++ }}</td>
                                <td class="py-2">{{ $productos->descripcion }}</td>
                                <td class="py-2">{{ $productos->modelo }}</td>
                                <td class="py-2">{{ $productos->cantidad }}</td>
                                <td class="py-2">{{ $productos->marca?->nombre ?? 'Sin marca' }}</td>
                                <td class="py-2">{{ $tipo->preciodecompra ?? 'N/A' }}</td>
                                <td class="py-2">{{ $tipo->precioventamayor ?? 'N/A' }}</td>
                                <td class="py-2">{{ $tipo->preciotecnico ?? 'N/A' }}</td>
                                <td class="py-2">{{ $tipo->psf ?? 'N/A' }}</td>
                                <td class="py-2">{{ $tipo->ps ?? 'N/A' }}</td>
                                <td class="py-2">
                                    <a href="{{ route('producto.edit', $productos->id) }}" class="btn-yellow text-white px-3 py-1 rounded">Editar</a>
                                    <form action="{{ route('producto.destroy', $productos->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este producto?')" class="btn-red text-white px-3 py-1 rounded">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
</body>
</html>
