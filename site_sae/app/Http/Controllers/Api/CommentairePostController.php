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
}
