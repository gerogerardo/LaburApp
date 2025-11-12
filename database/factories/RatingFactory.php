<?php

namespace Database\Factories;

use App\Models\Rating;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingFactory extends Factory
{
    protected $model = Rating::class;

    public function definition(): array
    {
        return [
            'rating' => $this->faker->numberBetween(1, 5),
            'id_usuario' => $this->faker->numberBetween(1, 15),
            'id_publicaciones' => $this->faker->numberBetween(1, 27),
            'comentario' => $this->faker->sentence(),
            'id_usuario_rankeado' => $this->faker->numberBetween(1, 15),
        ];
    }
}
