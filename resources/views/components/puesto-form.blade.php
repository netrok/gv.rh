@props(['puesto' => null])

<div class="space-y-4 bg-white p-6 rounded shadow">

    <!-- Nombre -->
    <div>
        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
        <input
            type="text"
            name="nombre"
            id="nombre"
            value="{{ old('nombre', $puesto->nombre ?? '') }}"
            class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300"
            required
        />
        @error('nombre')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Clave -->
    <div>
        <label for="clave" class="block text-sm font-medium text-gray-700">Clave</label>
        <input
            type="text"
            name="clave"
            id="clave"
            value="{{ old('clave', $puesto->clave ?? '') }}"
            class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300"
        />
        @error('clave')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Salario Base -->
    <div>
        <label for="salario_base" class="block text-sm font-medium text-gray-700">Salario Base</label>
        <input
            type="number"
            name="salario_base"
            id="salario_base"
            step="0.01"
            min="0"
            value="{{ old('salario_base', $puesto->salario_base ?? '') }}"
            class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300"
            required
        />
        @error('salario_base')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Departamento -->
    <div>
        <label for="departamento_id" class="block text-sm font-medium text-gray-700">Departamento</label>
        <select
            name="departamento_id"
            id="departamento_id"
            class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300"
            required
        >
            <option value="">Seleccione un departamento</option>
            @foreach ($departamentos as $departamento)
                <option
                    value="{{ $departamento->id }}"
                    {{ old('departamento_id', $puesto->departamento_id ?? '') == $departamento->id ? 'selected' : '' }}
                >
                    {{ $departamento->nombre }}
                </option>
            @endforeach
        </select>
        @error('departamento_id')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

</div>
