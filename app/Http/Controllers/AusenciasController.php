<?php

namespace App\Http\Controllers;

use App\Models\Ausencias;
use App\Models\Empleado;
use Illuminate\Http\Request;

class AusenciasController extends Controller
{
    public function index()
    {
        $ausencias = Ausencias::with('empleado')->orderBy('fecha_inicio', 'desc')->get();
        return view('ausencias.index', compact('ausencias'));
    }

    public function create()
    {
        $empleados = Empleado::where('activo', true)->orderBy('nombres')->get();
        return view('ausencias.create', compact('empleados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'motivo' => 'required|string|max:255',
            'comentarios' => 'nullable|string|max:500',
            'estatus' => 'required|in:pendiente,aprobada,rechazada',
        ]);

        Ausencias::create([
            'empleado_id' => $request->empleado_id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'motivo' => $request->motivo,
            'comentarios' => $request->comentarios,
            'estatus' => $request->estatus,
        ]);

        return redirect()->route('ausencias.index')->with('success', 'Ausencia registrada correctamente.');
    }

    public function show(Ausencias $ausencia)
    {
        $ausencia->load('empleado');
        return view('ausencias.show', compact('ausencia'));
    }

    public function edit(Ausencias $ausencia)
    {
        $empleados = Empleado::where('activo', true)->orderBy('nombres')->get();
        return view('ausencias.edit', compact('ausencia', 'empleados'));
    }

    public function update(Request $request, Ausencias $ausencia)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'motivo' => 'required|string|max:255',
            'comentarios' => 'nullable|string|max:500',
            'estatus' => 'required|in:pendiente,aprobada,rechazada',
        ]);

        $ausencia->update([
            'empleado_id' => $request->empleado_id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'motivo' => $request->motivo,
            'comentarios' => $request->comentarios,
            'estatus' => $request->estatus,
        ]);

        return redirect()->route('ausencias.index')->with('success', 'Ausencia actualizada correctamente.');
    }

    public function destroy(Ausencias $ausencia)
    {
        $ausencia->delete();
        return redirect()->route('ausencias.index')->with('success', 'Ausencia eliminada correctamente.');
    }
}
