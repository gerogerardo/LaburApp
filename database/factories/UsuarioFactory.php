<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->firstName(),
            'apellido' => $this->faker->lastName(),
            'mail' => $this->faker->unique()->safeEmail(),
            'telefono' => $this->faker->phoneNumber(),
            'domicilio' => $this->faker->address(),
            'foto_perfil' => 'imagenes/default-profile.jpg',
            'contraseña' => Hash::make('password'),
            'informacion' => $this->faker->paragraph(),
            'id_localidad' => $this->faker->numberBetween(1, 10),
            'id_rating' => null,
        ];
    }
}