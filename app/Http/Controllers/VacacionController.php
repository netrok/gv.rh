<?php

namespace App\Http\Controllers;

use App\Models\Vacacion;
use App\Models\Empleado;
use Illuminate\Http\Request;

class VacacionController extends Controller
{
    public function index()
    {
        $vacaciones = Vacacion::with('empleado')->orderBy('fecha_inicio', 'desc')->get();
        return view('vacaciones.index', compact('vacaciones'));
    }

    public function create()
    {
        $empleados = Empleado::orderBy('nombres')->get();
        return view('vacaciones.create', compact('empleados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'fecha_inicio' => 'required|date|before_or_equal:fecha_fin',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:pendiente,aprobada,rechazada',
            'comentarios' => 'nullable|string',
        ]);

        Vacacion::create($request->all());

        return redirect()->route('vacaciones.index')->with('success', 'Vacación creada correctamente.');
    }

    public function show(Vacacion $vacacion)
    {
        $vacacion->load('empleado');
        return view('vacaciones.show', compact('vacacion'));
    }

    public function edit(Vacacion $vacacion)
    {
        $empleados = Empleado::orderBy('nombres')->get();
        return view('vacaciones.edit', compact('vacacion', 'empleados'));
    }

    public function update(Request $request, Vacacion $vacacion)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'fecha_inicio' => 'required|date|before_or_equal:fecha_fin',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:pendiente,aprobada,rechazada',
            'comentarios' => 'nullable|string',
        ]);

        $vacacion->update($request->all());

        return redirect()->route('vacaciones.index')->with('success', 'Vacación actualizada correctamente.');
    }

    public function destroy(Vacacion $vacacion)
    {
        $vacacion->delete();

        return redirect()->route('vacaciones.index')->with('success', 'Vacación eliminada correctamente.');
    }
}