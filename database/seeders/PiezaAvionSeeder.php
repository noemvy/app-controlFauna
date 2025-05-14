<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PiezaAvion;

class PiezaAvionSeeder extends Seeder
{
    public function run()
    {
        $piezas = [
            ['nombre' => 'Ala/Rotor', 'estado' => 1],
            ['nombre' => 'Cola', 'estado' => 1],
            ['nombre' => 'Fuselaje', 'estado' => 1],
            ['nombre' => 'Hélice', 'estado' => 1],
            ['nombre' => 'Luces', 'estado' => 1],
            ['nombre' => 'Motor N°1', 'estado' => 1],
            ['nombre' => 'Motor N°2', 'estado' => 1],
            ['nombre' => 'Motor N°3', 'estado' => 1],
            ['nombre' => 'Motor N°4', 'estado' => 1],
            ['nombre' => 'Parabrisas', 'estado' => 1],
            ['nombre' => 'Proa', 'estado' => 1],
            ['nombre' => 'Radomo', 'estado' => 1],
            ['nombre' => 'Tren de aterrizaje', 'estado' => 1],
        ];

        foreach ($piezas as $pieza) {
            PiezaAvion::create($pieza);
        }
    }
}
