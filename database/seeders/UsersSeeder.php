<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lista de usuarios a insertar manualmente
        $usuarios = [
            [
                'name' => 'Ernesto Fisher',
                'email' => 'efisher@tocumenpanama.aero',
                'password' => Hash::make('
                '),
                'codigo_colaborador' => 'E04289',
                'estado' => '1',
                'aerodromo_id' => 1,
                'departamento_id' => 1,
            ],
            [
                'name' => 'Jefe',
                'email' => 'jefe@tocumenpanama.aero',
                'password' => Hash::make('Tocumen123'), // 🔒 Contraseña encriptada
                'estado' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Supervisor',
                'email' => 'supervisor@tocumenpanama.aero',
                'password' => Hash::make('Tocumen123'),
                'estado' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'noemi',
                'email' => 'noemi@gmail.com',
                'password' => Hash::make('Tocumen123'),
                'estado' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insertar los usuarios en la base de datos
        foreach ($usuarios as $usuario) {
            User::create($usuario);
        }
    }
}
