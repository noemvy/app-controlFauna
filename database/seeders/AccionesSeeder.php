<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccionesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('acciones')->insert([
            ['nombre' => 'Monitoreo', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Captura', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Dispercion', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Captura', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Monitore', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Dispercion', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
