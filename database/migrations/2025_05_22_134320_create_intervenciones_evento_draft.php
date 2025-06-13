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
        Schema::create('intervenciones_evento_draft', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('tipo_evento')->nullable();
            $table->string('origen');
            $table->integer('estado')->nullable();
            $table->decimal('coordenada_x', 10, 6)->nullable();
            $table->decimal('coordenada_y', 10, 6)->nullable();
            $table->float('temperatura')->nullable();
            $table->float('viento')->nullable();
            $table->float('humedad')->nullable();
            $table->foreignId('especies_id')->constrained('especies')->onDelete('cascade');
            $table->foreignId('atractivos_id')->constrained('atractivos')->onDelete('cascade');
            $table->integer('vistos')->nullable();
            $table->integer('sacrificados')->nullable();
            $table->integer('dispersados')->nullable();
            $table->json('fotos')->nullable();
            $table->text('comentarios')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('intervenciones_evento_draft', function (Blueprint $table) {
        $table->dropForeign(['atractivos_id']);
        $table->dropColumn('atractivos_id');
        });
        Schema::table('intervenciones_evento_draft', function (Blueprint $table) {
        $table->dropForeign(['especies_id']);
        $table->dropColumn('especies_id');
                });
        Schema::table('intervenciones_evento_draft', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropColumn('user_id');
                });

        Schema::dropIfExists('intervenciones_evento_draft');

    }
};
