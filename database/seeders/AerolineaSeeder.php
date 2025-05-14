<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aerolinea;

class AerolineaSeeder extends Seeder
{
    public function run()
    {
        $aerolineas = [
            // Aerolíneas de Comercial
            ['iata' => '2K', 'nombre' => 'Aerogal', 'tipo' => 'Comercial', 'estado' => 1],
            ['iata' => 'UX', 'nombre' => 'Air Europa', 'tipo' => 'Comercial', 'estado' => 1],
            ['iata' => 'AF', 'nombre' => 'Air France', 'tipo' => 'Comercial', 'estado' => 1],
            ['iata' => 'AA', 'nombre' => 'American', 'tipo' => 'Comercial', 'estado' => 1],
            ['iata' => 'AV', 'nombre' => 'Avianca', 'tipo' => 'Comercial', 'estado' => 1],
            ['iata' => 'KX', 'nombre' => 'Cayman Airways', 'tipo' => 'Comercial', 'estado' => 1],
            ['iata' => 'CM', 'nombre' => 'Copa Airlines', 'tipo' => 'Comercial', 'estado' => 1],
            ['iata' => 'DL', 'nombre' => 'Delta', 'tipo' => 'Comercial', 'estado' => 1],
            ['iata' => 'FT', 'nombre' => 'FlyTrip', 'tipo' => 'Comercial', 'estado' => 1],
            ['iata' => 'IB', 'nombre' => 'Iberia', 'tipo' => 'Comercial', 'estado' => 1],
            ['iata' => 'KL', 'nombre' => 'KLM', 'tipo' => 'Comercial', 'estado' => 1],
            ['iata' => 'S6', 'nombre' => 'Sunrise Airways', 'tipo' => 'Comercial', 'estado' => 1],
            ['iata' => 'TA', 'nombre' => 'Taca', 'tipo' => 'Comercial', 'estado' => 1],
            ['iata' => 'TK', 'nombre' => 'Turkish', 'tipo' => 'Comercial', 'estado' => 1],
            ['iata' => 'UA', 'nombre' => 'United', 'tipo' => 'Comercial', 'estado' => 1],
            ['iata' => 'WG', 'nombre' => 'Wingo', 'tipo' => 'Comercial', 'estado' => 1],
            ['iata' => 'LR', 'nombre' => 'Lacsa', 'tipo' => 'Comercial', 'estado' => 1],

            // Aerolíneas de carga
            ['iata' => 'ABX', 'nombre' => 'ABX', 'tipo' => 'Cargo', 'estado' => 1],
            ['iata' => 'AEQ', 'nombre' => 'Aero Expreso del Ecuador', 'tipo' => 'Cargo', 'estado' => 1],
            ['iata' => 'ACB', 'nombre' => 'Aerolineas del Caribe', 'tipo' => 'Cargo', 'estado' => 1],
            ['iata' => 'KRE', 'nombre' => 'Aerosucre', 'tipo' => 'Cargo', 'estado' => 1],
            ['iata' => 'M6', 'nombre' => 'AJT Amerijet', 'tipo' => 'Cargo', 'estado' => 1],
            ['iata' => 'CPC', 'nombre' => 'COPA Cargo', 'tipo' => 'Cargo', 'estado' => 1],
            ['iata' => 'DHL', 'nombre' => 'DAE DHL Aero Expreso', 'tipo' => 'Cargo', 'estado' => 1],
            ['iata' => 'DHG', 'nombre' => 'DHL Guatemala', 'tipo' => 'Cargo', 'estado' => 1],
            ['iata' => 'FX', 'nombre' => 'Federal Express', 'tipo' => 'Cargo', 'estado' => 1],
            ['iata' => 'GXA', 'nombre' => 'Global Crossing Airlines', 'tipo' => 'Cargo', 'estado' => 1],
            ['iata' => 'LCO', 'nombre' => 'LATAM Cargo Colombia', 'tipo' => 'Cargo', 'estado' => 1],
            ['iata' => 'MAA', 'nombre' => 'MasAir Cargo', 'tipo' => 'Cargo', 'estado' => 1],
            ['iata' => 'TPA', 'nombre' => 'TAMPA Avianca Cargo', 'tipo' => 'Cargo', 'estado' => 1],
            ['iata' => 'UPS', 'nombre' => 'United Parcel Service', 'tipo' => 'Cargo', 'estado' => 1],
            ['iata' => 'UWA', 'nombre' => 'Uniworld Air Cargo', 'tipo' => 'Cargo', 'estado' => 1],
            ['iata' => 'WE', 'nombre' => 'Wingo', 'tipo' => 'Cargo', 'estado' => 1],
            ['iata' => 'XL', 'nombre' => 'Latam Ecuador', 'tipo' => 'Cargo', 'estado' => 1],
            ['iata' => 'OB', 'nombre' => 'Boliviana de Aviacion', 'tipo' => 'Cargo', 'estado' => 1],
            ['iata' => '2I', 'nombre' => '21 Air', 'tipo' => 'Cargo', 'estado' => 1],
            ['iata' => 'AWC', 'nombre' => 'Awesome Cargo', 'tipo' => 'Cargo', 'estado' => 1],
        ];

        foreach ($aerolineas as $aerolinea) {
            Aerolinea::create($aerolinea);
        }
    }
}
