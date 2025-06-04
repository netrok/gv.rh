<?php

namespace App\Http\Controllers;

use App\Models\Puesto;
use App\Models\Departamento;
use Illuminate\Http\Request;

class PuestoController extends Controller
{
    public function index(Request $request)
    {
        $query = Puesto::with('departamento'); // Eager loading para evitar N+1

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nombre', 'like', "%{$search}%");
        }

        $puestos = $query->orderByDesc('id')->paginate(10)->withQueryString();

        return view('puestos.index', compact('puestos'));
    }

    public function create()
    {
        // Obtener todos los departamentos ordenados por nombre
        $departamentos = Departamento::orderBy('nombre')->get();

        // Enviar departamentos a la vista para que el select funcione
        return view('puestos.create', compact('departamentos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:puestos,nombre',
            'clave' => 'nullable|string|max:50|unique:puestos,clave',
            'descripcion' => 'nullable|string|max:1000',
            'salario_base' => 'nullable|numeric|min:0',
            'departamento_id' => 'nullable|exists:departamentos,id',
        ]);

        Puesto::create($validated);

        return redirect()->route('puestos.index')->with('success', 'Puesto creado correctamente.');
    }

    public function show(Puesto $puesto)
    {
        $puesto->load('departamento');
        return view('puestos.show', compact('puesto'));
    }

    public function edit(Puesto $puesto)
    {
        // También enviar departamentos para editar el select
        $departamentos = Departamento::orderBy('nombre')->get();
        return view('puestos.edit', compact('puesto', 'departamentos'));
    }

    public function update(Request $request, Puesto $puesto)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:puestos,nombre,' . $puesto->id,
            'clave' => 'nullable|string|max:50|unique:puestos,clave,' . $puesto->id,
            'descripcion' => 'nullable|string|max:1000',
            'salario_base' => 'nullable|numeric|min:0',
            'departamento_id' => 'nullable|exists:departamentos,id',
        ]);

        $puesto->update($validated);

        return redirect()->route('puestos.index')->with('success', 'Puesto actualizado correctamente.');
    }

    public function destroy(Puesto $puesto)
    {
        $puesto->delete();

        return redirect()->route('puestos.index')->with('success', 'Puesto eliminado correctamente.');
    }
}
