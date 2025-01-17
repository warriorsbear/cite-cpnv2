<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\Visionnage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VisionnageController extends Controller
{
    public function startVisionnage($id_visionnage)
    {
        // Vérifier si l'utilisateur est admin
        if (!Auth::user()->role === 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Mettre à jour la date de diffusion
        $visionnage = Visionnage::find($id_visionnage);
        $visionnage->date_diffusion = Carbon::now();
        $visionnage->save();

        // Récupérer toutes les photos dans un ordre aléatoire
        $photos = Photo::where('id_visionnage', $id_visionnage)
            ->inRandomOrder()
            ->with('utilisateur:id,nom,prenom')
            ->get();

        return response()->json([
            'photos' => $photos->map(function ($photo) {
                return [
                    'id' => $photo->id_photo,
                    'url' => $photo->chemin,
                    'legende' => $photo->legende,
                    'date_prise' => $photo->date_prise_vue,
                    'auteur' => [
                        'id' => $photo->utilisateur->id,
                        'nom' => $photo->utilisateur->nom,
                        'prenom' => $photo->utilisateur->prenom
                    ]
                ];
            })
        ]);
    }

    public function getVisionnageStatus($id_visionnage)
    {
        $visionnage = Visionnage::find($id_visionnage);

        if (!$visionnage) {
            return response()->json(['error' => 'Visionnage not found'], 404);
        }

        return response()->json([
            'status' => $visionnage->date_diffusion ? 'en_cours' : 'non_commence',
            'date_diffusion' => $visionnage->date_diffusion
        ]);
    }
}
