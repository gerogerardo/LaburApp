<?php

namespace Database\Seeders;

use App\Models\Publicacion;
use Illuminate\Database\Seeder;

class PublicacionSeeder extends Seeder
{
    public function run(): void
    {
        // Crear 50 publicaciones
        Publicacion::factory(50)->create();
    }
}