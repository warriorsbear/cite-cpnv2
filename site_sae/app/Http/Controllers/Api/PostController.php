<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user', 'photos')->latest()->get(); // Exemple de relations
        return response()->json($posts);
    }

    public function store(request $request)
    {
        $request->validate([
            'Légende' => 'required|string|max:255',
            'id_utilisateur' => 'required|exists:users,id'
        ]);

        Post::create([
            'Légende' => $request->input('Légende'),
            'id_utilisateur' => $request->input('id_utilisateur')
        ]);
    }
}
