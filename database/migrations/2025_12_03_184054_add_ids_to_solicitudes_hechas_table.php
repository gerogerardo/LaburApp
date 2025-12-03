<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('solicitudes_hechas', function (Blueprint $table) {
        $table->unsignedBigInteger('id_del_solicitante')->after('id');
        $table->unsignedBigInteger('id_del_solicitado')->after('id_del_solicitante');
    });
}

public function down()
{
    Schema::table('solicitudes_hechas', function (Blueprint $table) {
        $table->dropColumn(['id_del_solicitante', 'id_del_solicitado']);
    });
}

};
