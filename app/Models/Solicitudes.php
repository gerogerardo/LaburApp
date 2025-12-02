<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Solicitudes extends Model

{


        use HasFactory;
    protected $table = 'solicitudes';
    protected $primaryKey = 'id_solicitudes';

    protected $fillable = [
        'id_publicaciones',
        'id_usuario'
    ];

    public $timestamps = true;
    
    public function usuario(){
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
    public function publicacion(){
    return $this->belongsTo(Publicacion::class, 'id_publicaciones', 'id_publicaciones');
    }


}
