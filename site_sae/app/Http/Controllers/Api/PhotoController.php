<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EvenementResource;
use App\Http\Resources\PhotoResource;
use App\Models\Photo;
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
            \Log::info('Request data:', $request->all());

            // Vérification que le fichier a bien été uploadé
            if ($request->hasFile('nom')) {
                $file = $request->file('nom');

                // Log pour déboguer
                \Log::info('File details:', [
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize()
                ]);

                // Génération d'un nom de fichier unique
                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

                // Stockage du fichier dans le dossier public/photos
                $path = $file->storeAs('photos', $fileName, 'public');
                // Création de l'entrée dans la base de données

                $photo = Photo::create([
                    'nom' => $path,
                    'legende' => $request->input('legende', 'Sans légende'),
                    'date_prise_vue' => $request->input('date_prise_vue'),
                    'id_utilisateur' => $request->input('id_utilisateur'),
                    'id_utilisateur_1' => 1
                ]);


//                return response()->json([
//                    'message' => 'Photo uploadee avec succes'
//                ], 201);
//            }

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
