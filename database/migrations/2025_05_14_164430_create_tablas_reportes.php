<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // /**
    //  * Run the migrations.
    //  */
    public function up(): void
    {
        Schema::create('reporte_impactoaviar', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->foreignId('aerodromo_id')->constrained('aerodromos')->onDelete('restrict');
            $table->foreignId('pista_id')->constrained('pistas')->onDelete('restrict');
            $table->dateTime('fecha');
            $table->foreignId('aerolinea_id')->constrained('aerolineas')->onDelete('restrict');
            $table->foreignId('modelo_id')->constrained('modelo_aeronaves')->onDelete('restrict');
            $table->string('matricula');
            $table->integer('Altitud');
            $table->integer('Velocidad')->nullable();
            $table->string('Luminosidad');
            $table->string('Fase_vuelo');
            $table->string('cielo')->nullable();
            $table->decimal('temperatura', 5, 2)->nullable();
            $table->integer('viento_velocidad')->nullable();
            $table->string('viento_direccion')->nullable();
            $table->string('condicion_visual')->nullable();
            $table->foreignId('especies_id')->nullable()->constrained('especies')->onDelete('restrict');
            $table->string('fauna_observada')->nullable(); //especies cantidad
            $table->string('fauna_impactada')->nullable(); // cantidad
            $table->string('fauna_tamano')->nullable(); 
            $table->json('fotos')->nullable();
            $table->string('consecuencia');
            $table->text('observacion')->nullable();
            $table->integer('tiempo_fs')->nullable();
            $table->decimal('costo_reparacion', 10, 2)->nullable();
            $table->decimal('costo_otros', 10, 2)->nullable();
            $table->integer('estado');
            $table->timestamps();
        });

        //Tabla Pieza Avion
        Schema::create('pieza_avion', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('estado');
            $table->timestamps();
        });

        //Tabala Partes Golpeadas
        Schema::create('partes_golpeadas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporte_id')->constrained('reporte_impactoaviar')->onDelete('restrict');
            $table->foreignId('pieza_id')->constrained('pieza_avion')->onDelete('restrict');
            $table->timestamps();
        });

        //Tabla Partes dañadas
        Schema::create('partes_danadas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporte_id')->nullable()->constrained('reporte_impactoaviar')->onDelete('restrict');
            $table->foreignId('pieza_id')->nullable()->constrained('pieza_avion')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('partes_danadas');
        Schema::dropIfExists('partes_golpeadas');
        Schema::dropIfExists('pieza_avion');
        Schema::dropIfExists('reporte_impactoaviar');
    }
};
