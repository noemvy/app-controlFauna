<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogoInventarioSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener IDs de acciones disponibles
        $acciones = DB::table('acciones')->pluck('id');

        if ($acciones->isEmpty()) {
            $this->command->warn('No hay acciones registradas. Ejecuta primero AccionesSeeder.');
            return;
        }

        DB::table('catalogo_inventarios')->insert([
            [
                'acciones_id' => 1,
                'nombre' => 'Candelas',
                'categoria_equipo' => 'Arma',
                'descripcion' => '',
                'tipo' => '',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'acciones_id' => 1,
                'nombre' => 'Capa',
                'categoria_equipo' => 'Instrumento',
                'descripcion' => '',
                'tipo' => '',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'acciones_id' => 1,
                'nombre' => 'Tubos Electrónicos',
                'categoria_equipo' => 'Instrumento',
                'descripcion' => '',
                'tipo' => '',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'acciones_id' => 1,
                'nombre' => 'Sirens',
                'categoria_equipo' => 'Municiones',
                'descripcion' =>'',
                'tipo' => '',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'acciones_id' =>1,
                'nombre' => 'Bangers',
                'categoria_equipo' => 'Arma',
                'descripcion' => '',
                'tipo' => '',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'acciones_id' =>1,
                'nombre' => 'Cañón de Gas',
                'categoria_equipo' => 'Arma',
                'descripcion' => '',
                'tipo' => '',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'acciones_id' =>2,
                'nombre' => 'Bocinas',
                'categoria_equipo' => 'Arma',
                'descripcion' => '',
                'tipo' => '',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'acciones_id' =>2,
                'nombre' => 'Vehículo',
                'categoria_equipo' => 'Vehiculo',
                'descripcion' => '',
                'tipo' => '',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'acciones_id' =>3,
                'nombre' => 'Rifle de Aire',
                'categoria_equipo' => 'Arma',
                'descripcion' => '',
                'tipo' => '',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'acciones_id' =>3,
                'nombre' => 'Arma de Fuego',
                'categoria_equipo' => 'Arma',
                'descripcion' => '',
                'tipo' => '',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'acciones_id' =>4,
                'nombre' => 'Bastón de Captura',
                'categoria_equipo' => 'Arma',
                'descripcion' => '',
                'tipo' => '',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'acciones_id' =>4,
                'nombre' => 'Malla',
                'categoria_equipo' => 'Arma',
                'descripcion' => '',
                'tipo' => '',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
