<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departamentos')->insert([
            [
                'codigo' => 'OP001',
                'descripcion' => 'Departamento de Operaciones',
                'estado' => 1, // Estado activo
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'CF001',
                'descripcion' => 'Departamento de Control de Fauna',
                'estado' => 1, // Estado activo
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
