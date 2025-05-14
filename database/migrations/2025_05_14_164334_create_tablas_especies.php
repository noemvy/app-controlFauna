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
        //Tabla Familia
        Schema::create('grupos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        //Tabla Especies
        Schema::create('especies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupos_id')->constrained('grupos')->onDelete('cascade');
            $table->string('nombre_comun');
            $table->string('nombre_cientifico');
            $table->string('familia');
            $table->json('foto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('especies');
        Schema::dropIfExists('grupos');
    }
};
