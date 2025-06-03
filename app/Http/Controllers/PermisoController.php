<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use App\Models\Empleado;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    public function index()
    {
        $permisos = Permiso::with('empleado')->orderBy('fecha_inicio', 'desc')->get();
        return view('permisos.index', compact('permisos'));
    }

    public function create()
    {
        // Para seleccionar el empleado al crear el permiso
        $empleados = Empleado::orderBy('nombres')->get();
        return view('permisos.create', compact('empleados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'motivo' => 'required|string|max:255',
            'comentarios' => 'nullable|string',
            'estatus' => 'required|in:pendiente,aprobado,rechazado',
        ]);

        Permiso::create($request->all());

        return redirect()->route('permisos.index')->with('success', 'Permiso creado correctamente.');
    }

    public function show(Permiso $permiso)
    {
        $permiso->load('empleado');
        return view('permisos.show', compact('permiso'));
    }

    public function edit(Permiso $permiso)
    {
        $empleados = Empleado::orderBy('nombres')->get();
        return view('permisos.edit', compact('permiso', 'empleados'));
    }

    public function update(Request $request, Permiso $permiso)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'motivo' => 'required|string|max:255',
            'comentarios' => 'nullable|string',
            'estatus' => 'required|in:pendiente,aprobado,rechazado',
        ]);

        $permiso->update($request->all());

        return redirect()->route('permisos.index')->with('success', 'Permiso actualizado correctamente.');
    }

    public function destroy(Permiso $permiso)
    {
        $permiso->delete();
        return redirect()->route('permisos.index')->with('success', 'Permiso eliminado correctamente.');
    }
}
