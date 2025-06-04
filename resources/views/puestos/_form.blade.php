@php
    $departamentos = \App\Models\Departamento::all();
@endphp

<div>
    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Puesto</label>
    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $puesto->nombre ?? '') }}"
        class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
        placeholder="Ejemplo: Analista de Sistemas" required>
    @error('nombre')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="clave" class="block text-sm font-medium text-gray-700 mb-1">Clave</label>
    <input type="text" name="clave" id="clave" value="{{ old('clave', $puesto->clave ?? '') }}"
        class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
        placeholder="Clave única (opcional)">
    @error('clave')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="salario_base" class="block text-sm font-medium text-gray-700 mb-1">Salario Base</label>
    <input type="number" step="0.01" name="salario_base" id="salario_base" value="{{ old('salario_base', $puesto->salario_base ?? '') }}"
        class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
        placeholder="0.00">
    @error('salario_base')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="departamento_id" class="block text-sm font-medium text-gray-700 mb-1">Departamento</label>
    <select name="departamento_id" id="departamento_id"
        class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
        <option value="">-- Seleccionar Departamento --</option>
        @foreach ($departamentos as $departamento)
            <option value="{{ $departamento->id }}" {{ old('departamento_id', $puesto->departamento_id ?? '') == $departamento->id ? 'selected' : '' }}>
                {{ $departamento->nombre }}
            </option>
        @endforeach
    </select>
    @error('departamento_id')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
    <textarea name="descripcion" id="descripcion" rows="3"
        class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
        placeholder="Descripción del puesto...">{{ old('descripcion', $puesto->descripcion ?? '') }}</textarea>
    @error('descripcion')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
