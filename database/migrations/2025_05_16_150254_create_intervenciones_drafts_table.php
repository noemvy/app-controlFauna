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
        Schema::create('intervenciones_drafts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('especies_id')->constrained('especies')->onDelete('cascade');
            $table->foreignId('catinventario_id')->constrained('catalogo_inventarios')->onDelete('cascade');
            $table->json('municion_utilizada')->nullable();
            $table->json('cantidad_utilizada')->nullable();
            $table->foreignId('acciones_id')->constrained('acciones')->onDelete('cascade');
            $table->foreignId('atractivos_id')->constrained('atractivos')->onDelete('cascade');
            // $table->morphs('reportable');
            $table->integer('vistos')->nullable();
            $table->integer('sacrificados')->nullable();
            $table->integer('dispersados')->nullable();
            $table->decimal('coordenada_x', 10, 6)->nullable();
            $table->decimal('coordenada_y', 10, 6)->nullable();
            $table->json('fotos')->nullable();
            $table->float('temperatura')->nullable();
            $table->float('viento')->nullable();
            $table->float('humedad')->nullable();
            $table->text('comentarios')->nullable();
            $table->foreignId('patrullaje_id')->nullable()->constrained('patrullaje')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('intervenciones_drafts', function (Blueprint $table) {
        $table->dropForeign(['patrullaje_id']);
        $table->dropColumn('patrullaje_id');
        });
    }
};
