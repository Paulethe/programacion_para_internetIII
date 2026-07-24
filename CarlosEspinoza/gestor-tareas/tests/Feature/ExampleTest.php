<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TareasApiTest extends TestCase
{
    use RefreshDatabase;

    public function testPuedeListarTareas()
    {
        $response = $this->getJson('/api/tareas');
        $response->assertStatus(200);
    }

    public function testPuedeCrearTarea()
    {
        $response = $this->postJson('/api/tareas', ['titulo' => 'Nueva tarea de prueba']);
        $response->assertStatus(201);
        $response->assertJson(['titulo' => 'Nueva tarea de prueba']);
    }

    public function testNoCreaTareaSinTitulo()
    {
        $response = $this->postJson('/api/tareas', []);
        $response->assertStatus(400);
    }

    public function testPuedeBorrarTarea()
    {
        $tarea = \App\Models\Tarea::create(['titulo' => 'Tarea a borrar']);
        $response = $this->deleteJson('/api/tareas/' . $tarea->id);
        $response->assertStatus(200);
        $this->assertNull(\App\Models\Tarea::find($tarea->id));
    }
}
