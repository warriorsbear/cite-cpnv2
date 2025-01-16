<?php
// PostController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Photo;
use Illuminate\Http\Request;
use App\Services\ExifHandler;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PostController extends Controller
{
    protected $exifHandler;

    public function __construct(ExifHandler $exifHandler)
    {
        $this->exifHandler = $exifHandler;
    }

    // Stocker un post
    public function store(Request $request)
    {
        try {
            // Validation
            $request->validate([
                'legende' => 'required|string|max:255',
                'id_utilisateur' => 'required|exists:users,id',
                'photos' => 'required|array|min:1|max:5',
                'photos.*' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:40000000',
                'date_prise_vue' => 'required|date'
            ]);

            // Début de la transaction
            \DB::beginTransaction();

            // Créer le post
            $post = Post::create([
                'Légende' => $request->input('legende'),
                'id_utilisateur' => $request->input('id_utilisateur'),
                'created_at' => now()->format('Y-m-d\TH:i:sP'),
            ]);

            // Traiter chaque photo
            $manager = new ImageManager(new Driver());

            foreach($request->file('photos') as $photoFile) {
                $fileName = uniqid() . '.' . $photoFile->getClientOriginalExtension();
                $image = $manager->read($photoFile);

                // Redimensionner l'image
                $image->scale(width: 2048, height: 2048);
                // Définir le chemin
                $path = 'photos/' . $fileName;
                // Sauvegarder l'image
                $image->save(storage_path('app/public/' . $path));

                $exifData = $this->exifHandler->extractExif($photoFile);
                Log::info('Données EXIF extraites:', $exifData);


                // Créer l'entrée Photo
                $photoData = [
                    'nom' => $path,
                    'legende' => $request->input('legende'),
                    'date_prise_vue' => $request->input('date_prise_vue'),
                    'id_utilisateur' => $request->input('id_utilisateur'),
                    'id_utilisateur_1' => 1,
                    'created_at' => now()->format('Y-m-d\TH:i:sP'),
                    'chemin' => 'http://127.0.0.1:8000/storage/' . $path,
                    'id_post' => $post->id_post,
                    'exif1' => $exifData['exif1'],
                    'exif2' => $exifData['exif2'],
                    'exif3' => $exifData['exif3'],
                    'exif4' => $exifData['exif4'],
                    'exif5' => $exifData['exif5'],
                    'exif6' => $exifData['exif6']
                ];
                $photo = Photo::create($photoData);
                Log::info('Photo créée:', ['photo_id' => $photo->id_photo, 'data' => $photoData]);

            }

            // Valider la transaction
            \DB::commit();


        } catch (\Exception $e) {
            // Annuler la transaction en cas d'erreur
            \DB::rollback();

            return response()->json([
                'error' => 'Erreur lors de la création du post',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function fetchPosts(Request $request)
    {
        $posts = Post::with('user', 'photos')->latest()->paginate(10);
        return response()->json($posts);
    }

    public function index()
    {
        $posts = Post::with(['user', 'photos'])->latest()->get();
        return response()->json($posts);
    }
}
