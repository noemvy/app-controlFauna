<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AtractivosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('atractivos')->insert([
            ['nombre' => 'Vertederos de basura', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Fuentes de agua estancada', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Áreas con vegetación densa', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Cultivos cercanos', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Presencia de insectos', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Animales domésticos sueltos', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Cuerpos de agua como lagunas o ríos', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Disponibilidad de alimento', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
