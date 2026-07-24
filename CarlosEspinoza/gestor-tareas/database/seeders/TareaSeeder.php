<?php

namespace Database\Seeders;

use App\Models\Tarea;
use Illuminate\Database\Seeder;

class TareaSeeder extends Seeder
{
    public function run()
    {
        Tarea::create(['titulo' => 'Hacer la tarea de Laravel']);
        Tarea::create(['titulo' => 'Estudiar AngularJS']);
        Tarea::create(['titulo' => 'Subir el proyecto a GitHub']);
    }
}
