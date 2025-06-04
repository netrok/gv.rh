<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Empleado;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    public function index()
    {
        // Carga la relación jefe para evitar múltiples consultas (N+1 problem)
        $departamentos = Departamento::with('jefe')->get();

        return view('departamentos.index', compact('departamentos'));
    }

    public function create()
    {
        $jefes = Empleado::orderBy('nombres')->get();  // Ordenado alfabéticamente para mejor UX
        return view('departamentos.create', compact('jefes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|unique:departamentos,nombre|max:255',
            'codigo' => 'required|string|unique:departamentos,codigo|max:50',
            'descripcion' => 'nullable|string',
            'activo' => 'nullable|boolean',
            'jefe_id' => 'nullable|exists:empleados,id',
        ]);

        // Asegura que el campo activo siempre tenga valor (checkboxes no enviados si no están seleccionados)
        $validated['activo'] = $request->has('activo');

        Departamento::create($validated);

        return redirect()->route('departamentos.index')->with('success', 'Departamento creado correctamente.');
    }

    public function show(Departamento $departamento)
    {
        return view('departamentos.show', compact('departamento'));
    }

    public function edit(Departamento $departamento)
    {
        $jefes = Empleado::orderBy('nombres')->get();
        return view('departamentos.edit', compact('departamento', 'jefes'));
    }

    public function update(Request $request, Departamento $departamento)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:departamentos,nombre,' . $departamento->id,
            'codigo' => 'required|string|max:50|unique:departamentos,codigo,' . $departamento->id,
            'descripcion' => 'nullable|string',
            'activo' => 'nullable|boolean',
            'jefe_id' => 'nullable|exists:empleados,id',
        ]);

        $validated['activo'] = $request->has('activo');

        $departamento->update($validated);

        return redirect()->route('departamentos.index')->with('success', 'Departamento actualizado correctamente.');
    }

    public function destroy(Departamento $departamento)
    {
        $departamento->delete();

        return redirect()->route('departamentos.index')->with('success', 'Departamento eliminado correctamente.');
    }
}
