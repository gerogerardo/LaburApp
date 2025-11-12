<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfesionSeeder extends Seeder
{
    public function run(): void
    {
        $profesiones = [
            'Programador',
            'Diseñador Gráfico',
            'Electricista',
            'Plomero',
            'Carpintero',
            'Contador',
            'Abogado',
            'Médico',
            'Enfermero',
            'Profesor',
        ];

        foreach ($profesiones as $profesion) {
            DB::table('profesiones')->insert([
                'nombre_profesion' => $profesion,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}