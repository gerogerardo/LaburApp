<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publicacion;
use Illuminate\Support\Facades\Auth;
use App\Models\Rating;


class RatingController extends Controller
{

    // Crear nuevo rating
    public function store(Request $datos)
    {
        $datos->validate([
            'rating' => 'required|integer|between:1,5' ,
            'id_publicaciones' => 'required' ,
            'comentario' => 'nullable'
        ]);
        
        // Verificar que la publciación existe
        $publicacion = Publicacion::findOrFail($datos->id_publicaciones);
        

        //Verificar que el usuario no sea dueño de la publicación
        if($publicacion->id_usuario == Auth::id()){
            return back()->with('success', 'No puedes calificar tu propia publicación');
        }
        
        //Verificar que el usuario no haya clasificado ya la publicación
        $ratingExistente = Rating::where('id_usuario', Auth::id())
        ->where('id_publicaciones', $datos->id_publicaciones)
        ->first();
        if($ratingExistente){
            return back()->with('success', 'Ya has calificado esta publicación');
        }
        
        $rating = Rating::create([
            'id_usuario' => Auth::id(),
            'id_publicaciones' => $datos->id_publicaciones,
            'rating' => $datos->rating,
            'comentario' => $datos->comentario,
            'id_usuario_rankeado' => $publicacion->id_usuario,
        ]);

        return back()->with('success', 'Calificación creada exitosamente');

    }

// Actualizar un rating
public function update(Request $datos,$id)
{
    $datos->validate([
        'rating' => 'required|integer|between:1,5',
        'comentario' => 'nullable|string'
    ]);

$rating = Rating::findOrFail($id);

if($rating->id_usuario != Auth::id()) {
    return back()->with('success', 'No tienes permiso para actualizar esta calificación');
}

$rating->update([
    'rating' => $datos->rating,
    'comentario' => $datos->comentario
]);

return back()->with('success', 'Calificación actualizada correctamente');
}

// Eliminar un rating
public function destroy($id)
{
    $rating = Rating::findOrFail($id);

    if ($rating->id_usuario !== Auth::id()) {
        return back()->with('success', 'No tienes permiso para eliminar esta calificación');
    }

    $rating->delete();

    return back()->with('success', 'Calificación eliminada exitosamente');
}





}