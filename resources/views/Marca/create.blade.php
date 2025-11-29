<x-app-layout>
    <div class="flex items-center justify-center h-screen">
        <div class="text-center w-full max-w-md mx-auto bg-black p-8 rounded-lg shadow-lg">
            <h1 class="text-4xl text-white font-bold mb-6">Crear Marca</h1>

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('marcas.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="nombre" class="block text-left font-semibold mb-2">Nombre de la Marca</label>
                    <input type="text" name="nombre" id="nombre" class="w-full border border-gray-300 px-4 py-2 rounded-lg" placeholder="Ingrese el nombre de la marca" required>
                </div>

                <button type="submit" class="bg-black text-white px-4 py-2 rounded hover:bg-blue-500">Guardar</button>
            </form>
        </div>
    </div>
</x-app-layout>
