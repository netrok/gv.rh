<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    public function index()
    {
        $documentos = Documento::with('empleado')->get();
        return view('documentos.index', compact('documentos'));
    }

    public function create()
    {
        $empleados = Empleado::where('activo', true)->get();
        return view('documentos.create', compact('empleados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'nombre' => 'required|string|max:255',
            'archivo' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx',
            'tipo' => 'nullable|string|max:100',
            'fecha_vencimiento' => 'nullable|date',
        ]);

        // Guardar archivo en storage/app/public/documentos
        if ($request->hasFile('archivo')) {
            $path = $request->file('archivo')->store('documentos', 'public');
        }

        Documento::create([
            'empleado_id' => $request->empleado_id,
            'nombre' => $request->nombre,
            'archivo' => $path ?? null,
            'tipo' => $request->tipo,
            'fecha_vencimiento' => $request->fecha_vencimiento,
        ]);

        return redirect()->route('documentos.index')->with('success', 'Documento creado correctamente.');
    }

    public function show(Documento $documento)
    {
        return view('documentos.show', compact('documento'));
    }

    public function edit(Documento $documento)
    {
        $empleados = Empleado::where('activo', true)->get();
        return view('documentos.edit', compact('documento', 'empleados'));
    }

    public function update(Request $request, Documento $documento)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'nombre' => 'required|string|max:255',
            'archivo' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx',
            'tipo' => 'nullable|string|max:100',
            'fecha_vencimiento' => 'nullable|date',
        ]);

        // Si suben un archivo nuevo, eliminar el antiguo y guardar el nuevo
        if ($request->hasFile('archivo')) {
            if ($documento->archivo) {
                Storage::disk('public')->delete($documento->archivo);
            }
            $path = $request->file('archivo')->store('documentos', 'public');
        } else {
            $path = $documento->archivo;
        }

        $documento->update([
            'empleado_id' => $request->empleado_id,
            'nombre' => $request->nombre,
            'archivo' => $path,
            'tipo' => $request->tipo,
            'fecha_vencimiento' => $request->fecha_vencimiento,
        ]);

        return redirect()->route('documentos.index')->with('success', 'Documento actualizado correctamente.');
    }

    public function destroy(Documento $documento)
    {
        if ($documento->archivo) {
            Storage::disk('public')->delete($documento->archivo);
        }
        $documento->delete();

        return redirect()->route('documentos.index')->with('success', 'Documento eliminado correctamente.');
    }
}
