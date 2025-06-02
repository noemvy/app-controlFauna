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

            $table->foreignId('intervencion_draft_id')
                ->nullable()
                ->constrained('intervenciones_drafts')
                ->onDelete('cascade');

            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pivote_patrullaje_intervenciones');
    }
};
