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
        Schema::table('usuarios', function (Blueprint $table) {
            $table->foreign('id_localidad')
                ->references('id_localidad')
                ->on('localidades')
                ->onDelete('restrict');
            
            $table->foreign('id_rating')
                ->references('id_rating')
                ->on('rating')
                ->onDelete('set null');  // Cambiar de restrict a set null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropForeign('usuarios_id_localidad_foreign');
            $table->dropForeign('usuarios_id_rating_foreign');
        });
        
        Schema::enableForeignKeyConstraints();
    }
};
