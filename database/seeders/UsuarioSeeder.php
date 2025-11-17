<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {

        Usuario::factory(15)->create();


        Usuario::create([
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'mail' => 'juan@example.com',
            'telefono' => '1234567890',
            'domicilio' => 'Calle Principal 123',
            'foto_perfil' => 'imagenes/default-profile.jpg',
            'contraseña' => bcrypt('password'),
            'informacion' => 'Soy un programador con 5 años de experiencia',
            'id_localidad' => 1,
            'id_rating' => null,
        ]);
    }
}