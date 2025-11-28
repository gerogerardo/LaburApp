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
        Schema::table('solicitudes_hechas', function (Blueprint $table) {
            $table->unsignedBigInteger('id_publicacion')->nullable()->after('id_de_la_solicitud');
            $table->unsignedBigInteger('id_profesion')->nullable()->after('id_publicacion');

            $table->foreign('id_publicacion')->references('id_publicaciones')->on('publicaciones')->onDelete('cascade');
            $table->foreign('id_profesion')->references('id_profesion')->on('profesiones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solicitudes_hechas', function (Blueprint $table) {
            $table->dropForeign(['id_publicacion']);
            $table->dropForeign(['id_profesion']);
            $table->dropColumn('id_publicacion');
            $table->dropColumn('id_profesion');
        });
    }
};
