<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'rating';
    protected $primaryKey = 'id_rating';
    protected $fillable = [
        'rating',
        'id_usuario',
        'id_publicaciones',
        'comentario',
        'id_usuario_rankeado'
    ];

public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    // Relación con la publicación calificada
    public function publication()
    {
        return $this->belongsTo(Publicacion::class, 'id_publicaciones');
    }

    // Relación con el usuario que fue calificado (dueño de la publicación)
    public function ratedUser()
    {
        return $this->belongsTo(User::class, 'id_usuario_rankeado');
    }


}
