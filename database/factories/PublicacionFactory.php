<?php

namespace Database\Factories;

use App\Models\Publicacion;
use Illuminate\Database\Eloquent\Factories\Factory;

class PublicacionFactory extends Factory
{
    protected $model = Publicacion::class;

    public function definition(): array
    {
        return [
            'nombre_publicacion' => $this->faker->sentence(3),
            'descripcion' => $this->faker->paragraph(3),
            'fecha' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'foto_portada' => 'imagenes/default-publication.jpg',
            'id_usuario' => $this->faker->numberBetween(1, 15),
            'id_profesion' => $this->faker->numberBetween(1, 10),
        ];
    }
}
