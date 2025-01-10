<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EvenementResource;
use App\Http\Resources\PhotoResource;
use App\Models\Photo;
use App\Models\Post;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
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

            if ($request->hasFile('nom')) {
                $file = $request->file('nom');
                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

                // Créer une instance de l'image
                $manager = new ImageManager(new Driver());
                $image = $manager->read($file);

                // Redimensionner l'image à 2048x2048 en maintenant les proportions
                $image->scale(width: 2048, height: 2048);

                // Créer le chemin de stockage
                $path = 'photos/' . $fileName;

                // Début de la transaction
                \DB::beginTransaction();

                try {
                    // Créer le post
                    $post = Post::create([
                        'Légende' => $request->input('legende'),
                        'id_utilisateur' => $request->input('id_utilisateur'),
                        'created_at' => now()->format('Y-m-d\TH:i:sP'),
                    ]);


                    // Sauvegarder l'image redimensionnée
                    $image->save(storage_path('app/public/' . $path));

                    // Créer la photo avec l'id_post
                    $photo = Photo::create([
                        'nom' => $path,
                        'legende' => $request->input('legende', 'Sans légende'),
                        'date_prise_vue' => $request->input('date_prise_vue'),
                        'id_utilisateur' => $request->input('id_utilisateur'),
                        'id_utilisateur_1' => 1,
                        'chemin' => 'http://127.0.0.1:8000/storage/' . $path,
                        'id_post' => $post->id_post
                    ]);

                    // Si tout s'est bien passé, on valide la transaction
                    \DB::commit();
                    LaravelNotify::success('Post et photo uploadés avec succès');

                } catch (\Exception $e) {
                    // En cas d'erreur, on annule la transaction
                    \DB::rollback();
                    throw $e;
                }

            } else {
                LaravelNotify::error('Aucun fichier uploadé');
            }

            return redirect()->back();

        } catch (\Exception $e) {
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
