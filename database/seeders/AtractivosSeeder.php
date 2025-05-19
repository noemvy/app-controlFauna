<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AtractivosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('atractivos')->insert([
            ['nombre' => 'Asfalto/Concreto', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Suelo Desnudo', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Limpieza', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Arroyo/Corriente', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Valla', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Hierba', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Campo Abierto', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Polo/Señal/Cable', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Estanque', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Rocoso', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Pista', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Arbusto', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Pega', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Estructura', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Muñon', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Temperatura Agua/Estancada', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Calle de Rodaje', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
