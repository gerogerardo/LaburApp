<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudHecha extends Model
{
    protected $table = 'solicitudes_hechas';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function solicitud(){
        return $this->belongsTo(Solicitudes::class, 'id_de_la_solicitud', 'id_solicitudes');
    }
    
    public function publicacion(){
        return $this->belongsTo(Publicacion::class, 'id_de_la_solicitud', 'id_publicaciones');
    }
}