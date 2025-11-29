<!-- resources/views/marcas/edit.blade.php -->
<x-app-layout>
        <div class="container">
            <h1 class="text-2xl font-bold mb-4">Editar Marca</h1>

            <form action="{{ route('chirps.update',)}}" method="POST">
                @csrf @method('PUT')
                <div class="mb-4">
                    <label for="nombre" class="block text-gray-700">Nombre</label>
                    <input type="text" id="nombre" name="nombre" class="form-input mt-1 block w-full" value="{{ old('nombre', $marcas->nombre) }}" required>
                    @error('nombre')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>
        </div>
</x-app-layout>