<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PistasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pistas
        $pistas = [
            [
                'nombre' => '03L',
                'codigo' => '03L',
                'descripcion' => '',
                'autor' => 'Administrador',
                'estado' => 1,  // 1 significa activa
                'aerodromo_id' => 1,  // ID del Aeródromo (por ejemplo, Aeropuerto Int. de Tocumen)
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => '03R',
                'codigo' => '03R',
                'descripcion' => '',
                'autor' => 'Administrador',
                'estado' => 1,
                'aerodromo_id' => 1,  // ID del Aeródromo (por ejemplo, Enrique Jimenez)
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => '21L',
                'codigo' => '21L',
                'descripcion' => '',
                'autor' => 'Administrador',
                'estado' => 1,
                'aerodromo_id' => 1,  // ID del Aeródromo (por ejemplo, Panamá Pacífico)
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => '21R',
                'codigo' => '21R',
                'descripcion' => '',
                'autor' => 'Administrador',
                'estado' => 1,
                'aerodromo_id' => 1,  // ID del Aeródromo (por ejemplo, Panamá Pacífico)
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => '18',
                'codigo' => '18',
                'descripcion' => '',
                'autor' => 'Administrador',
                'estado' => 1,
                'aerodromo_id' => 2,  // ID del Aeródromo (por ejemplo, Panamá Pacífico)
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => '36',
                'codigo' => '36',
                'descripcion' => '',
                'autor' => 'Administrador',
                'estado' => 1,
                'aerodromo_id' => 2,  // ID del Aeródromo (por ejemplo, Panamá Pacífico)
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => '04',
                'codigo' => '04',
                'descripcion' => '',
                'autor' => 'Administrador',
                'estado' => 1,
                'aerodromo_id' => 3,  // ID del Aeródromo (por ejemplo, Panamá Pacífico)
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => '22',
                'codigo' => '22',
                'descripcion' => '',
                'autor' => 'Administrador',
                'estado' => 1,
                'aerodromo_id' => 3,  // ID del Aeródromo (por ejemplo, Panamá Pacífico)
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => '18',
                'codigo' => '18',
                'descripcion' => '',
                'autor' => 'Administrador',
                'estado' => 1,
                'aerodromo_id' => 4,  // ID del Aeródromo (por ejemplo, Panamá Pacífico)
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => '36',
                'codigo' => '36',
                'descripcion' => '',
                'autor' => 'Administrador',
                'estado' => 1,
                'aerodromo_id' => 4,  // ID del Aeródromo (por ejemplo, Panamá Pacífico)
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => '17',
                'codigo' => '17',
                'descripcion' => '',
                'autor' => 'Administrador',
                'estado' => 1,
                'aerodromo_id' => 5,  // ID del Aeródromo (por ejemplo, Panamá Pacífico)
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => '35',
                'codigo' => '35',
                'descripcion' => '',
                'autor' => 'Administrador',
                'estado' => 1,
                'aerodromo_id' => 5,  // ID del Aeródromo (por ejemplo, Panamá Pacífico)
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insertar las pistas en la tabla
        DB::table('pistas')->insert($pistas);
    }
}
