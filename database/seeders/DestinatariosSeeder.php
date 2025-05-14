<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DestinatariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinatarios = [
            [
                'nombre' => 'Dalys Rodriguez',
                'correo' => 'dalys.rodriguez@aeronautica.gob.pa',
                'tipo' => 'CC',
                'formulario' => 'RCR',
                'autor' => 'Administrador',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Gary Acosta',
                'correo' => 'gacosta@tocumenpanama.aero',
                'tipo' => 'CCO',
                'formulario' => 'RCR',
                'autor' => 'Administrador',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Franklin Aguilar',
                'correo' => 'feaguilar@tocumenpanama.aero',
                'tipo' => 'CC',
                'formulario' => 'RCR',
                'autor' => 'Administrador',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'nombre' => 'Hernando Gaitan',
                'correo' => 'hgaitan@tocumenpanama.aero',
                'tipo' => 'CCO',
                'formulario' => 'RCR',
                'autor' => 'Administrador',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'nombre' => 'Luis Herrera',
                'correo' => 'luis.herrera@aeronautica.gob.pa',
                'tipo' => 'CC',
                'formulario' => 'RCR',
                'autor' => 'Administrador',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'nombre' => 'Elis Rodriguez',
                'correo' => 'egrodriguez@tocumenpanama.aero',
                'tipo' => 'CCO',
                'formulario' => 'RCR',
                'autor' => 'Administrador',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'nombre' => 'Leonard Bowen',
                'correo' => 'lbowen@tocumenpanama.aero',
                'tipo' => 'CCO',
                'formulario' => 'RCR',
                'autor' => 'Administrador',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'nombre' => 'AIS AAC',
                'correo' => 'aisnoftum@gmail.com',
                'tipo' => 'Para',
                'formulario' => 'RCR',
                'autor' => 'Administrador',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'nombre' => 'Operaciones Plataforma',
                'correo' => 'operaciones1@tocumenpanama.aero',
                'tipo' => 'CC',
                'formulario' => 'RCR',
                'autor' => 'Administrador',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'nombre' => 'Operaciones Irregulares',
                'correo' => 'irrops@tocumenpanama.aero',
                'tipo' => 'CC',
                'formulario' => 'RCR',
                'autor' => 'Administrador',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'nombre' => 'TELECOM AAC',
                'correo' => 'telecomtocumen@gmail.com',
                'tipo' => 'Para',
                'formulario' => 'RCR',
                'autor' => 'Administrador',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'nombre' => 'AIS AAC',
                'correo' => 'aisnof@aeronautica.gob.pa',
                'tipo' => 'Para',
                'formulario' => 'RCR',
                'autor' => 'Administrador',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'nombre' => 'Ejecutivos de Gestion',
                'correo' => 'cdegestion@tocumenpanama.aero',
                'tipo' => 'CC',
                'formulario' => 'RCR',
                'autor' => 'Administrador',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('destinatarios')->insert($destinatarios);
    }
}
