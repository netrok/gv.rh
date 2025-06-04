<?php

namespace App\Http\Controllers;

use App\Models\Puesto;
use Illuminate\Http\Request;

class PuestoController extends Controller
{
    public function index(Request $request)
    {
        $query = Puesto::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nombre', 'like', "%{$search}%");
        }

        $puestos = $query->orderBy('id', 'desc')->paginate(10);  // <- paginate aquí

        return view('puestos.index', compact('puestos'));
    }

    public function create()
    {
        return view('puestos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:puestos,nombre',
            'descripcion' => 'nullable'
        ]);

        Puesto::create($request->all());

        return redirect()->route('puestos.index')->with('success', 'Puesto creado correctamente.');
    }

    public function show(Puesto $puesto)
    {
        return view('puestos.show', compact('puesto'));
    }

    public function edit(Puesto $puesto)
    {
        return view('puestos.edit', compact('puesto'));
    }

    public function update(Request $request, Puesto $puesto)
    {
        $request->validate([
            'nombre' => 'required|unique:puestos,nombre,' . $puesto->id,
            'descripcion' => 'nullable'
        ]);

        $puesto->update($request->all());

        return redirect()->route('puestos.index')->with('success', 'Puesto actualizado correctamente.');
    }

    public function destroy(Puesto $puesto)
    {
        $puesto->delete();
        return redirect()->route('puestos.index')->with('success', 'Puesto eliminado correctamente.');
    }
}