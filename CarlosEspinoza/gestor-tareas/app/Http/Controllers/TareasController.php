<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;

class TareasController extends Controller
{
    public function index()
    {
        return response()->json(Tarea::all());
    }

    public function store(Request $request)
    {
        $titulo = $request->input('titulo');
        if (!$titulo) {
            return response()->json(['error' => 'El titulo es requerido'], 400);
        }

        $tarea = Tarea::create(['titulo' => $titulo]);
        return response()->json($tarea, 201);
    }

    public function destroy($id)
    {
        $tarea = Tarea::find($id);
        if (!$tarea) {
            return response()->json(['error' => 'Tarea no encontrada'], 404);
        }

        $tarea->delete();
        return response()->json(['mensaje' => 'Tarea eliminada']);
    }
}
