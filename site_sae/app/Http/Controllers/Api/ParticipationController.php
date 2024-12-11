<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Participation;
use Illuminate\Http\Request;

class ParticipationController extends Controller
{
    public function index(){
        return response()->json(Participation::get());
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_utilisateur' => 'required|integer',
            'id_evenement' => 'required|integer',
            'presence' => 'required|boolean'
        ]);

        $participation = Participation::create([
            'id_utilisateur' => $validatedData['id_utilisateur'],
            'id_evenement' => $validatedData['id_evenement'],
            'presence' => $validatedData['presence']

        ]);

        return response()->json($participation, 201);

    }

}
