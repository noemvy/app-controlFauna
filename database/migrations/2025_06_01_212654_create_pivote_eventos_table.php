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
        Schema::create('pivote_eventos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intervencion_id')->nullable()->constrained('intervenciones_evento_draft')->onDelete('cascade');
            $table->foreignId('catinventario_id')->constrained('catalogo_inventarios')->onDelete('cascade');
            $table->foreignId('acciones_id')->constrained('acciones')->onDelete('cascade');
            $table->integer('cantidad_utilizada')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pivote_eventos');
    }
};
