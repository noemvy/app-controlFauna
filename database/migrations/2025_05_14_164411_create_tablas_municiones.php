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
        //Tabla Catalogos de Herramientos y Recursos del Inventario de forma global osea : malla, candela etc.
        Schema::create('catalogo_inventarios', function (Blueprint $table) {
                $table->id();
                $table->foreignId('acciones_id')->constrained('acciones')->restrictOnDelete();
                $table->string('nombre');
                $table->string('categoria_equipo');
                $table->string('tipo');
                $table->string('descripcion')->nullable();
                $table->integer('estado');
                $table->timestamps();



        });

        //Tabla inventario de municiones
        Schema::create('inventario_municiones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('catinventario_id')->constrained('catalogo_inventarios')->restrictOnDelete();
            $table->foreignId('aerodromo_id')->constrained('aerodromos')->restrictOnDelete();
            $table->string('cantidad_actual')->nullable();
            $table->string('cantidad_minima')->nullable();
            $table->timestamps();



    });

            //Tabla movimiento inventario
            Schema::create('movimiento_inventario', function (Blueprint $table) {
                $table->id();
                $table->foreignId('aerodromo_id')->constrained('aerodromos')->restrictOnDelete();
                $table->foreignId('catinventario_id')->constrained('catalogo_inventarios')->restrictOnDelete();
                $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
                $table->string('tipo_movimiento');
                $table->integer('cantidad_usar');
                $table->string('comentario')->nullable();
                $table->timestamps();


    });

    Schema::create('transferencias_municiones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aerodromo_origen_id')->nullable()->constrained('aerodromos')->nullOnDelete();
            $table->foreignId('aerodromo_destino_id')->nullable()->constrained('aerodromos')->nullOnDelete();
            $table->foreignId('catinventario_id')->constrained('catalogo_inventarios')->restrictOnDelete();
            $table->integer('cantidad');
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });


}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::dropIfExists('transferencias_municiones');
        Schema::dropIfExists('movimiento_inventario');
        Schema::dropIfExists('inventario_municiones');
        Schema::dropIfExists('catalogo_inventarios');

    }
};
