<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EvenementResource;
use App\Http\Resources\PhotoResource;
use App\Models\Photo;
use App\Models\Post;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Mckenziearts\Notify\Facades\LaravelNotify;

class PhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::get();
        if($photos)
        {
            return PhotoResource::collection($photos);
        }
        else
        {
            return response()->json(['message' => 'Aucune photo trouvé'],200);
        }

    }

    public function store(Request $request)
    {
        try {
            // Validation des données
            $request->validate([
                'nom' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:40000000',
                'date_prise_vue' => 'required|date',
                'legende' => 'nullable|string|max:255',
                'id_utilisateur' => 'required|exists:users,id'
            ]);

            // Log pour déboguer


            // Vérification que le fichier a bien été uploadé
            if ($request->hasFile('nom')) {
                $file = $request->file('nom');

                // Génération d'un nom de fichier unique
                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

                // Stockage du fichier dans le dossier public/photos
                $path = $file->storeAs('photos', $fileName, 'public');
                // Création de l'entrée dans la base de données

                // 1. D'abord créer le post
                $post = Post::create([
                    'Légende' => $request->input('legende'),
                    'id_utilisateur' => $request->input('id_utilisateur')
                ]);

                $photo = Photo::create([
                    'nom' => $path,
                    'legende' => $request->input('legende', 'Sans légende'),
                    'date_prise_vue' => $request->input('date_prise_vue'),
                    'id_utilisateur' => $request->input('id_utilisateur'),
                    'id_utilisateur_1' => 1,
                    'chemin' => 'http://127.0.0.1:8000/storage/' .$path,
                    'id_post' => $post->id_post
                ]);



//            return response()->json(['error' => 'Aucun fichier uploade'], 400);
                LaravelNotify::success('Photo uploadée avec succès');

            } else {
                // Notification d'erreur
                LaravelNotify::error('Aucun fichier uploadé');
            }

            return redirect()->back();
        } catch (\Exception $e) {
            // Log de l'erreur complète
            \Log::error('Upload error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            return response()->json([
                'error' => 'Erreur lors de l\'upload',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function getUserPhotos($userId)
    {
        try {
            $photos = Photo::where('id_utilisateur', $userId)->get();

            if($photos->isEmpty()) {
                return response()->json(['message' => 'Aucune photo trouvée pour cet utilisateur'], 200);
            }

            return PhotoResource::collection($photos);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la récupération des photos',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
