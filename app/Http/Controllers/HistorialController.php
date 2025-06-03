<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    public function index(Request $request)
    {
        // Paginación y orden por fecha descendente
        $historiales = Historial::with('usuario')
            ->orderBy('fecha', 'desc')
            ->paginate(15);

        return view('historiales.index', compact('historiales'));
    }

    // Crear historial manualmente no es lo más común, pero dejo el método por si quieres
    public function create()
    {
        return view('historiales.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'modulo' => 'required|string|max:100',
            'registro_id' => 'required|integer',
            'accion' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha' => 'required|date',
        ]);

        Historial::create($request->all());

        return redirect()->route('historial.index')->with('success', 'Historial registrado correctamente.');
    }

    public function show(Historial $historial)
    {
        return view('historiales.show', compact('historial'));
    }

    public function edit(Historial $historial)
    {
        return view('historiales.edit', compact('historial'));
    }

    public function update(Request $request, Historial $historial)
    {
        $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'modulo' => 'required|string|max:100',
            'registro_id' => 'required|integer',
            'accion' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha' => 'required|date',
        ]);

        $historial->update($request->all());

        return redirect()->route('historial.index')->with('success', 'Historial actualizado correctamente.');
    }

    public function destroy(Historial $historial)
    {
        $historial->delete();
        return redirect()->route('historial.index')->with('success', 'Historial eliminado correctamente.');
    }
}
