<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    // Devuelve todas las tareas
    public function index()
    {
        $tareas = Tarea::all();
        return response()->json($tareas);
    }

  
    public function store(Request $request)
    {
        $tarea = Tarea::create([
            'titulo' => $request->input('titulo'),
        ]);

        return response()->json($tarea, 201);
    }

    public function destroy($id)
    {
        $tarea = Tarea::find($id);

        if (!$tarea) {
            return response()->json(['message' => 'Tarea no encontrada'], 404);
        }

        $tarea->delete();

        return response()->json(['message' => 'Tarea eliminada correctamente']);
    }
}

?>