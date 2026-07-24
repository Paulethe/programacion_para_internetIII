<?php

namespace Database\Factories;

use App\Models\Tarea;
use Illuminate\Database\Eloquent\Factories\Factory;

class TareaFactory extends Factory
{
    protected $model = Tarea::class;

    public function definition()
    {
        return [
            'titulo' => $this->faker->sentence,
        ];
    }
}
