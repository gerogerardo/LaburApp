<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalidadSeeder extends Seeder
{
    public function run(): void
    {
        $localidades = [
            'Santa Fe Capital',
            'Rosario',
            'Venado Tuerto',
            'Rafaela',
            'Santo Tomé',
            'Esperanza',
            'Arroyo Seco',
            'Casilda',
            'Sunchales',
            'San Cristóbal',
        ];

        foreach ($localidades as $localidad) {
            DB::table('localidades')->insert([
                'nombre_localidad' => $localidad,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}