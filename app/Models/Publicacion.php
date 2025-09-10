<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Publicacion extends Model
{
    use HasFactory;
    protected $table = 'publicaciones';
    protected $primaryKey = 'id_publicaciones';

    protected $fillable = [
        'nombre_publicacion',
        'descripcion',
        'fecha',
        'foto_portada',
        'id_usuario',
        'id_profesion'
    ];

    public $timestamps = true;

    public function profesion()
{
    return $this->belongsTo(Profesion::class, 'id_profesion', 'id_profesion');
}

    public function usuario(){
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }


public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    // Relación con los ratings que recibió
    public function ratings()
    {
        return $this->hasMany(Rating::class, 'id_publicaciones', 'id_publicaciones');
    }

    // Promedio de calificación
    public function averageRating()
    {
        return round($this->ratings()->avg('rating'), 1);
    }

}
