<?php
namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function index()
    {
        $tareas = Tarea::all();
        return response()->json($tareas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255'
        ]);

        $tarea = Tarea::create([
            'titulo' => $request->titulo
        ]);

        return response()->json([
            'mensaje' => 'Tarea Guardada',
            'tarea' => $tarea
        ], 201);
    }
}