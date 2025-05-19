<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DeleteDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('acciones')->whereIn('nombre', [
            'Monitoreo',
            'Captura',
            'Dispercion',
            'Captura',
            'Monitore',
        ])->delete();

        DB::table('acciones')->whereIn('nombre', [
            'Monitoreo',
            'Captura',
            'Dispercion',
            'Captura',
            'Monitore',
        ])->delete();
    }
}
