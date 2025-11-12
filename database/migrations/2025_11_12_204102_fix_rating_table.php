<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Verificar si la tabla existe
        if (!Schema::hasTable('rating')) {
            Schema::create('rating', function (Blueprint $table) {
                $table->id('id_rating');
                $table->tinyInteger('rating')->default(1);
                $table->text('comentario')->nullable();
                $table->unsignedBigInteger('id_usuario')->nullable();
                $table->unsignedBigInteger('id_publicaciones')->nullable();
                $table->unsignedBigInteger('id_usuario_rankeado')->nullable();
                $table->timestamps();
            });

            // Agregar las foreign keys después de crear la tabla
            Schema::table('rating', function (Blueprint $table) {
                $table->foreign('id_publicaciones')
                    ->references('id_publicaciones')
                    ->on('publicaciones')
                    ->onDelete('cascade');
                
                $table->foreign('id_usuario')
                    ->references('id_usuario')
                    ->on('usuarios')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('rating');
        Schema::enableForeignKeyConstraints();
    }
};