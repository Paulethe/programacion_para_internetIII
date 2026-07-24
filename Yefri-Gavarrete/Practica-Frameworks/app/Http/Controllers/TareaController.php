<?php

namespace App\Http\Controllers;
use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tareas = Tarea::all();
        return response()->json($tareas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'titulo' => ['required', 'max:50'],
        ]);
        $tarea = Tarea::create($datos);
        return response()->json($tarea, 201);
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        

        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tarea = Tarea::find($id);
        if (!$tarea){
            return response()->json(['mensaje' => "Tarea no encontrada"], 404);
        }

        $tarea->delete();
        return response()->json(['mensaje' => "Tarea eliminada correctamente"]);
    }

}

