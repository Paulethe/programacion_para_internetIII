<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function index()
    {
        return response()->json(Tarea::all());
    }

    public function guardar(Request $request)
    {
        $titulo = $request->input('titulo') ?? $request->json('titulo');

        if (empty($titulo)) {
            return response()->json([
                'error' => 'El campo titulo no llego al backend',
                'datos_recibidos' => $request->all()
            ], 400);
        }

        $tarea = Tarea::create([
            'titulo' => $titulo
        ]);
        return response()->json($tarea);
    }

    public function eliminar($id)
    {
        $tarea = Tarea::find($id);

        if (!$tarea) {
            return response()->json(['mensaje' => 'Tarea no encontrada'], 404);
        }

        $tarea->delete();
        return response()->json(['mensaje' => 'Tarea eliminada con éxito']);
    }
}