<?php

namespace Database\Seeders;

use App\Models\PiezaAvion;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
    $this->call([
        AerodromosTableSeeder::class,
        DepartamentosTableSeeder::class,
        AerolineaSeeder::class,
        UsersSeeder::class,
        DestinatariosSeeder::class,
        FabricanteAeronaveSeeder::class,
        ModeloAeronaveSeeder::class,
        PiezaAvionSeeder::class,
        PistasTableSeeder::class,
        AccionesSeeder::class,
        AtractivosSeeder::class,
        GrupoSeeder::class,
        CatalogoInventarioSeeder::class,
        EspeciesSeeder::class,

    ]);
}
}
