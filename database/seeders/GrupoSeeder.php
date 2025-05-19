<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GrupoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('grupos')->insert([
            ['nombre' => 'ÁGUILA y GAVILANES', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'ANFIBIOS', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'AVES ACUÁTICAS', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'AVES MIGRATORIAS', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'AVES NOCTURAS', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'AVES PLAYERAS', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'CARPINTEROS', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'CHACALACA', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'COLIBRIES', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'CRUSTÁCEOS', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'CUCO', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'DESCONOCIDO', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'GALLINAZOS', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'GOLONDRINAS', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'HALCONES', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'HORNEROS', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'ICTERIDOS', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'INSECTOS', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'JILGUEROS', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'LOROS Y PERICOS', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'MAMIFEROS', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'MARTÍN PESCADOR', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'MOSQUEROS', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'PALOMAS', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'PATOS,ZAMBU y JACANA', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'PAVOS', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'PECES', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'PINZONES', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'PIQUEROS Y GAVIOTAS', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'REINITAS', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'REPTILES', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'SINSONTE', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'SOTORREYES', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'TANGARAS', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'TAPACAMINOS', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'TREPATRONCO', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'TUCAN', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'VIREO', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'ZORZALES', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
