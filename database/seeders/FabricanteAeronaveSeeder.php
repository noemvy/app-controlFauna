<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FabricanteAeronave;

class FabricanteAeronaveSeeder extends Seeder
{
    public function run()
    {
        $fabricantes = [
            ['nombre' => 'Boeing', 'estado' => 1],
            ['nombre' => 'Cessna', 'estado' => 1],
            ['nombre' => 'Airbus', 'estado' => 1],
            ['nombre' => 'Beechcraft', 'estado' => 1],
            ['nombre' => 'Gulfstream', 'estado' => 1],
            ['nombre' => 'Learjet', 'estado' => 1],
            ['nombre' => 'Bell', 'estado' => 1],
            ['nombre' => 'Piper', 'estado' => 1],
            ['nombre' => 'Beechcraf', 'estado' => 1],
            ['nombre' => 'Otro', 'estado' => 1]
        ];

        foreach ($fabricantes as $fabricante) {
            FabricanteAeronave::create($fabricante);
        }
    }
}
