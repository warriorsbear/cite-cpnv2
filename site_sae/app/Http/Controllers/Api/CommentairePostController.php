<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CommentairePost;
use Illuminate\Http\Request;

class CommentairePostController extends Controller
{
    public function index()
    {
        $commentaires = CommentairePost::with('user', 'post')->latest()->get(); // Exemple de relations
        return response()->json($commentaires);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'texte' => 'required|string|max:500',
            'id_post' => 'required|exists:post,id_post',
            'id_utilisateur' => 'required|exists:users,id',
        ]);

        $commentaire = CommentairePost::create([
            'texte' => $validated['texte'],
            'id_utilisateur' => $validated['id_utilisateur'],
            'id_post' => $validated['id_post'],
            'updated_at' => now()->format('Y-m-d\TH:i:sP'),
            'created_at' => now()->format('Y-m-d\TH:i:sP'),
        ]);

        return response()->json([
            'message' => 'Commentaire ajouté avec succès !',
            'commentaire' => $commentaire,
        ], 201);
    }
}
