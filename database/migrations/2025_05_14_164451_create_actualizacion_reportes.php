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
        Schema::create('actualizacion_reportes', function (Blueprint $table) {
            $table->id();
            $table->morphs('reportable'); // Esto crea reportable_id y reportable_type (relación polimórfica)
            $table->text('actualizacion'); // Contenido de la actualización
            $table->string('autor')->nullable(); // Quién realizó la actualización
            $table->boolean('estado')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actualizacion_reportes');
    }
};
