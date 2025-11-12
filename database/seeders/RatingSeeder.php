<?php

namespace Database\Seeders;

use App\Models\Rating;
use App\Models\Usuario;
use App\Models\Publicacion;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener todos los usuarios y publicaciones existentes
        $usuarios = Usuario::pluck('id_usuario')->toArray();
        $publicaciones = Publicacion::pluck('id_publicaciones')->toArray();

        // Si no hay datos, no crear ratings
        if (empty($usuarios) || empty($publicaciones)) {
            $this->command->warn('No hay usuarios o publicaciones. Saltando RatingSeeder.');
            return;
        }

        // Crear 100 ratings con datos válidos
        for ($i = 0; $i < 100; $i++) {
            Rating::create([
                'rating' => rand(1, 5),
                'id_usuario' => $usuarios[array_rand($usuarios)],
                'id_publicaciones' => $publicaciones[array_rand($publicaciones)],
                'comentario' => fake()->sentence(),
                'id_usuario_rankeado' => $usuarios[array_rand($usuarios)],
            ]);
        }
    }
}