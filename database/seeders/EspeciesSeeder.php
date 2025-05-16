<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class EspeciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('especies')->insert([
            [
                'grupos_id' => 1, // Aves
                'nombre_comun' => 'Garza Blanca',
                'nombre_cientifico' => 'Ardea alba',
                'familia' => 'Ardeidae',
                'rango_peligrosidad' => 'Bajo',
                'foto' => json_encode(['https://example.com/fotos/garza_blanca.jpg']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'grupos_id' => 1,
                'nombre_comun' => 'Caracara Crestado',
                'nombre_cientifico' => 'Caracara cheriway',
                'familia' => 'Falconidae',
                'rango_peligrosidad' => 'Bajo',
                'foto' => json_encode(['https://example.com/fotos/caracara.jpg']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'grupos_id' => 2, // Mamíferos
                'nombre_comun' => 'Perezoso de dos dedos',
                'nombre_cientifico' => 'Choloepus hoffmanni',
                'familia' => 'Megalonychidae',
                'rango_peligrosidad' => 'Bajo',
                'foto' => json_encode(['https://example.com/fotos/perezoso.jpg']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'grupos_id' => 2,
                'nombre_comun' => 'Mono aullador',
                'nombre_cientifico' => 'Alouatta palliata',
                'familia' => 'Atelidae',
                'rango_peligrosidad' => 'Medio',
                'foto' => json_encode(['https://example.com/fotos/mono_aullador.jpg']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'grupos_id' => 3, // Reptiles
                'nombre_comun' => 'Iguana verde',
                'nombre_cientifico' => 'Iguana iguana',
                'familia' => 'Iguanidae',
                'rango_peligrosidad' => 'Bajo',
                'foto' => json_encode(['https://example.com/fotos/iguana_verde.jpg']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
