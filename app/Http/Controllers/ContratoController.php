<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Empleado;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
    public function index()
    {
        $contratos = Contrato::with('empleado')->get();
        return view('contratos.index', compact('contratos'));
    }

    public function create()
    {
        $empleados = Empleado::where('activo', true)->get();
        return view('contratos.create', compact('empleados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'tipo_contrato' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'salario' => 'required|numeric|min:0',
            'estatus' => 'required|string|max:255'
        ]);

        Contrato::create($request->all());

        return redirect()->route('contratos.index')->with('success', 'Contrato creado correctamente.');
    }

    public function show(Contrato $contrato)
    {
        return view('contratos.show', compact('contrato'));
    }

    public function edit(Contrato $contrato)
    {
        $empleados = Empleado::where('activo', true)->get();
        return view('contratos.edit', compact('contrato', 'empleados'));
    }

    public function update(Request $request, Contrato $contrato)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'tipo_contrato' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'salario' => 'required|numeric|min:0',
            'estatus' => 'required|string|max:255'
        ]);

        $contrato->update($request->all());

        return redirect()->route('contratos.index')->with('success', 'Contrato actualizado correctamente.');
    }

    public function destroy(Contrato $contrato)
    {
        $contrato->delete();
        return redirect()->route('contratos.index')->with('success', 'Contrato eliminado correctamente.');
    }
}
