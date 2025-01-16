<?php

namespace App\Http\Controllers\Api;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with(['event', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['documents' => $documents]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,txt|max:10240', // 10 Mo max
            'nom' => 'required|string|max:50',
            'id_utilisateur' => 'required|exists:users,id',
            'id_evenement' => 'nullable|exists:evenement,id_evenement'
        ]);

        $file = $request->file('file');
        $path = $file->store('documents', 'public');



        $document = Document::create([
            'nom' => $request->input('nom'),
            'chemin' => $path,
            'id_utilisateur' => $request->input('id_utilisateur'),
            'id_evenement' => $request->input('id_evenement')
        ]);

        $document->load('event', 'user');

        return response()->json([
            'document' => $document
        ], 200);

    }

    public function download($id)
    {
        $document = Document::findOrFail($id);

        $filePath = storage_path('app/public/' . $document->chemin);

        if (!file_exists($filePath)) {
            abort(404, 'Fichier non trouvé');
        }

        // Récupérer le type MIME
        $mimeType = mime_content_type($filePath);

        // Vérifier si c'est une requête de prévisualisation ou de téléchargement
        $isInline = request()->has('preview') || str_contains(request()->header('Accept', ''), 'text/html');

        $headers = [
            'Content-Type' => $mimeType,
        ];

        if ($isInline) {
            // Pour prévisualisation
            $headers['Content-Disposition'] = 'inline; filename="' . $document->nom . '"';
            return response()->file($filePath, $headers);
        } else {
            // Pour téléchargement
            $headers['Content-Disposition'] = 'attachment; filename="' . $document->nom . '"';
            return response()->download($filePath, $document->nom, $headers);
        }
    }

    public function delete($id)
    {
        $document = Document::findOrFail($id);

        // Vérification des permissions
        if(Auth::user()->role == 'admin' or $document->id_utilisateur == Auth::id() ){
            // Suppression du fichier physique
            Storage::delete($document->chemin);
            $document->delete();

            return response()->json(['message' => 'Document supprimé avec succès'], 200);
        }
        else{
            return response()->json(['message' => 'Vous n\'avez pas les permissions nécessaires'], 403);
        }


    }
}
