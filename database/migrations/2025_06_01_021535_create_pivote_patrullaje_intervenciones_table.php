<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pivote_patrullaje_intervenciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('catinventario_id')->constrained('catalogo_inventarios')->onDelete('cascade');
            $table->foreignId('acciones_id')->constrained('acciones')->onDelete('cascade');
            $table->integer('cantidad_utilizada')->nullable()->default(0);
            $table->foreignId('intervencion_draft_id')->nullable()->constrained('intervenciones_drafts')->onDelete('cascade');
            $table->foreignId('intervencion_id')->nullable()->constrained('intervenciones')->onDelete('cascade');
            $table->timestamps();


        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pivote_patrullaje_intervenciones');
    }
};
