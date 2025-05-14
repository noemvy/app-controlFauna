<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GrupoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('grupos')->insert([
            ['nombre' => 'Reptiles', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Aves', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Mamíferos', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
