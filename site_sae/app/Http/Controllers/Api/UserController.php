<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use PDO;
use PDOExeption;

class UserController extends Controller
{

    /**
     * Supprime l'utilisateur par son id
     * @param $id l'id de l'utilisateur
     * @return \Illuminate\Http\JsonResponse réponse en json
     */
    public function suprimerUser($id)
    {
        $user = User::find($id); // On récupère l'utilisateur
        if ($user) {
            $user->delete();
            return response()->json(['message' => 'Utilisateur supprimé avec succès']);
        } else {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }
    }
    public function index()
    {
        return response()->json(User::get());
    }

    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }
    }

    /**
     * Accepte un utilisateur
     * @param $id l'id de l'utilisateur
     * @return \Illuminate\Http\JsonResponse réponse en json
     */
    public function accepter($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->statut = 1;
            $user->save();
            return response()->json(['message' => 'Utilisateur accepté avec succès'], 200);
        } else {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }
    }

}
