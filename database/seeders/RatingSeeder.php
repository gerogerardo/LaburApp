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

        $usuarios = Usuario::pluck('id_usuario')->toArray();
        $publicaciones = Publicacion::pluck('id_publicaciones')->toArray();

        if (empty($usuarios) || empty($publicaciones)) {
            $this->command->warn('No hay usuarios o publicaciones. Saltando RatingSeeder.');
            return;
        }

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