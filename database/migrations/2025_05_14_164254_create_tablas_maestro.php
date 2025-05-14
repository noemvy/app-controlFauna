<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         // Tabla Departamentos
    Schema::create('departamentos', function (Blueprint $table) {
        $table->id();
        $table->string('codigo');
        $table->string('descripcion');
        $table->integer('estado');
        $table->timestamps();
    });;

    //Tabla Aerolineas
    Schema::create('aerolineas', function (Blueprint $table) {
        $table->id();
        $table->string('iata');
        $table->string('nombre');
        $table->string('tipo');
        $table->integer('estado');
        $table->timestamps();
    });

    // Tabla Aeródromos
    Schema::create('aerodromos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('codigo')->unique();
        $table->text('descripcion')->nullable();
        $table->string('autor')->nullable();
        $table->integer('estado');
        $table->timestamps();
    });

    //Tabla Fabricante
    Schema::create('fabricante_aeronave', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->integer('estado');
        $table->timestamps();
    });


     //Tabla Modelo Aeronaves
    Schema::create('modelo_aeronaves', function (Blueprint $table) {
        $table->id();
        $table->string('modelo');
        $table->foreignId('fabricante_id')->constrained('fabricante_aeronave')->onDelete('restrict');
        $table->integer('estado');
        $table->timestamps();
    });

    // Tabla Pistas
    Schema::create('pistas', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('codigo');
        $table->text('descripcion');
        $table->string('autor')->nullable();
        $table->integer('estado');
        $table->foreignId('aerodromo_id')->constrained('aerodromos')->onDelete('restrict');
        $table->timestamps();
    });


    // Tabla Destinatarios
    Schema::create('destinatarios', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('correo');
        $table->string('tipo');
        $table->string('formulario');
        $table->string('autor')->nullable();
        $table->integer('estado');
        $table->timestamps();
    });

    // Tabla Destinatario Aeródromo
    Schema::create('destinatario_aerodromo', function (Blueprint $table) {
        $table->id();
        $table->foreignId('aerodromo_id')->constrained('aerodromos')->onDelete('cascade');
        $table->foreignId('destinatario_id')->constrained('destinatarios')->onDelete('cascade');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinatario_aerodromo');
        Schema::dropIfExists('destinatarios');
        Schema::dropIfExists('pistas');
        Schema::dropIfExists('modelo_aeronaves');
        Schema::dropIfExists('fabricante_aeronave');
        Schema::dropIfExists('aerodromos');
        Schema::dropIfExists('aerolineas');
        Schema::dropIfExists('departamentos');
    }
};
