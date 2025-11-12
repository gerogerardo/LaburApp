<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ejecutar seeders en ORDEN CORRECTO (respetando claves foráneas)
        $this->call([
            LocalidadSeeder::class,      // 1. Localidades (no tiene dependencias)
            ProfesionSeeder::class,      // 2. Profesiones (no tiene dependencias)
            UsuarioSeeder::class,        // 3. Usuarios (depende de localidades)
            PublicacionSeeder::class,    // 4. Publicaciones (depende de usuarios y profesiones)
            RatingSeeder::class,         // 5. Ratings (depende de usuarios y publicaciones)
        ]);
    }
}
