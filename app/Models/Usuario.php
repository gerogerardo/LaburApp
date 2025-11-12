<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Authenticatable
{
use HasFactory;
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'nombre',
        'apellido',
        'mail',
        'domicilio',
        'foto_perfil',
        'contraseña',
        'telefono',
        'informacion',
        'id_localidad',
        'id_rating'
    ];

    public $timestamps = true;

    public function getAuthPassword()
{
    return $this->contraseña;
}

public function localidad() {
    return $this->belongsTo(Localidad::class, 'id_localidad', 'id_localidad');
}

//RATINGS

    public function ratingsRecibidos()
{
    return $this->hasMany(Rating::class, 'id_usuario_rankeado', 'id_usuario');
}

public function promedioRating()
{
    return $this->ratingsRecibidos()->avg('rating');
}



}
