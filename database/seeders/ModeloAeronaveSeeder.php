<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ModeloAeronave;
use App\Models\FabricanteAeronave;

class ModeloAeronaveSeeder extends Seeder
{
    public function run()
    {
        $modelos = [
            'Boeing' => ['(Douglas) DC-3 Passenge', '(Douglas) DC-9-10 Passenger', '727-200 Freighter', '737 MAX 8', '737 MAX 9'],
            'Cessna' => ['(Light Aircraft - singl', '170', '172 Skyhawk', '182T Skylane', '205/206/207 Super Skywa'],
            'Airbus' => ['A319', 'A320', 'A320-251 NEO', 'A330 all models', 'A330-200'],
            'Beechcraft' => ['100 King Air', '35 Bonanza', '90 King Air', 'Baron 58P', 'C-12 Huron'],
            'Gulfstream' => ['Aerospace G-150', 'G 450', 'G-100/ IAI 1125 Ast', 'G450', 'G600'],
            'Learjet' => ['35', '40', '45', '60', '75'],
            'Bell' => ['204/205', '206L-3 Longranger/Bell 20', '212 (Twin Huey)/Bell UH-1', '407', '412'],
            'Piper' => ['PA-23 Aztec', 'PA-28 Cherokee', 'PA-31 Navajo', 'PA32 Cherokee Six', 'PA-34 Seneca'],
            'Beechcraf' => ['90 King Air', 'Hawker 400', 'Super King Air (200)', 'Super King Air (300)'],
        ];

        foreach ($modelos as $fabricanteNombre => $modelosArray) {
            $fabricante = FabricanteAeronave::where('nombre', $fabricanteNombre)->first();
            if ($fabricante) {
                foreach ($modelosArray as $modelo) {
                    ModeloAeronave::create([
                        'modelo' => $modelo,
                        'fabricante_id' => $fabricante->id,
                        'estado' => 1,
                    ]);
                }
            }
        }
    }
}
