<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AerodromosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $aerodromos = [
            [
                'nombre' => 'Aeropuerto Intl. de Tocumen',
                'codigo' => 'MPTO',
                'descripcion' => 'El Aeropuerto Internacional de Tocumen en Panamá, es considerado como el punto de unión de Las Américas por su cantidad de conexiones. Conecta con más de 84 ciudades de América y Europa en 34 países, cubriendo gran parte de Latinoamérica. Es también el hub principal de operaciones de Copa Airlines y centro de conexiones de Star Alliance para América Latina y el Caribe.',
                'autor' => null,
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Aeropuerto Intl. Enrique Jimenez',
                'codigo' => 'MPEJ',
                'descripcion' => 'El Aeropuerto Internacional Enrique Jimenez está ubicado en la ciudad de Colón, en la Provincia de Colón. En sus inicios en 1918 el aeródromo fue utilizado por el ejército de Estados Unidos como base militar. Más tarde en 1949 adquirió una función civil cuando los estadounidenses entregaron la terminal al gobierno.',
                'autor' => null,
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Aeropuerto Intl. Enrique Malek',
                'codigo' => 'MPDA',
                'descripcion' => 'El Aeropuerto Internacional Enrique Malek, está ubicado en la provincia de Chiriquí, a 6,5 Km al este del centro de la ciudad de David, al norte del Estero de Pedregal. Es el tercer aeropuerto de Panamá en tráfico aéreo de pasajeros transportados.',
                'autor' => null,
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Aeropuerto Intl. Panamá Pacífico',
                'codigo' => 'MPPA',
                'descripcion' => 'El Aeropuerto Internacional Panamá Pacífico, está ubicado en el área este del país, a 40 minutos del Aeropuerto Internacional de Tocumen, 10 minutos del Puerto de contenedores del Pacífico o a 1 hora de la Zona Libre de Colón y a sólo 20 minutos del centro de la cosmopolita Ciudad de Panamá.',
                'autor' => null,
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Aeropuerto Intl. Scarlett Martínez',
                'codigo' => 'MPSM',
                'descripcion' => 'El Aeropuerto Internacional Scarlett Martínez está ubicado en Río Hato, en la provincia de Coclé. Se construyó en el aeródromo edificado por los Estados Unidos en 1942, constituyéndose en el primer aeropuerto internacional en nuestro país, hasta la construcción del Aeropuerto Internacional de Tocumen, en 1947.',
                'autor' => null,
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insertar los aeródromos en la tabla
        DB::table('aerodromos')->insert($aerodromos);
    }
}
