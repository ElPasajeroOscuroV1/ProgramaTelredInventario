<!-- resources/views/marcas/index.blade.php -->
<x-app-layout>
    <div class="flex items-center justify-center h-screen bg-orange-500">
        <div class="text-center w-full max-w-3xl mx-auto bg-orange-600 p-8 rounded-lg shadow-lg">
            <h1 class="text-4xl font-bold mb-6 text-white">Marcas</h1>

            <a href="{{ route('marcas.create') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4">Crear Marca</a>
            <a href="{{ route('dashboard') }}" class="inline-block bg-blue-900 text-white px-4 py-2 rounded hover:bg-blue-400">
                Volver al inicio
            </a>

            @if(session('success'))
                <div class="alert alert-success mb-4 bg-green-100 text-green-700 p-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table-auto w-full text-center border-collapse">
                <thead>
                    <tr>
                        <th class="border-b-2 border-white py-2 text-white">ID</th>
                        <th class="border-b-2 border-white py-2 text-white">Nombre</th>
                        <th class="border-b-2 border-white py-2 text-white">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i=1;
                    ?>
                    @foreach($brand as $marca)
                        <tr>
                            <td class="border-b border-white py-2 text-white">{{ $i }}</td>
                            <td class="border-b border-white py-2 text-white">{{ $marca->nombre }}</td>
                            <td class="border-b border-white py-2">
                                <a href="{{ route('marcas.edit', $marca) }}" class="inline-block bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Editar</a>
                                <form action="{{ route('marcas.destroy', $marca) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-block bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                        $i++;
                        ?>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
