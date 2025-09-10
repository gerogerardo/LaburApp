<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('rating', function (Blueprint $table) {
            // Agregar columna del usuario que fue calificado
            $table->unsignedBigInteger('id_usuario_rankeado')->after('comentario');

            // Agregar timestamps (created_at y updated_at)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('rating', function (Blueprint $table) {
            $table->dropColumn('id_usuario_rankeado');
            $table->dropTimestamps();
        });
    }
};
