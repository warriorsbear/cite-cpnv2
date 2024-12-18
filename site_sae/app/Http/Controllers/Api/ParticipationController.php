<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ParticipationResource;
use App\Models\Participation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ParticipationController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->query('user_id');

        if ($userId) {
            $participations = Participation::where('id_utilisateur', $userId)->get();
        } else {
            $participations = Participation::all();
        }

        return response()->json($participations);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_utilisateur' => 'required|integer',
            'id_evenement' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }

        // Vérifier si la participation existe déjà
        $existingParticipation = Participation::where('id_utilisateur', $request['id_utilisateur'])
            ->where('id_evenement', $request['id_evenement'])
            ->first();

        if ($existingParticipation) {
            return response()->json([
                'error' => 'La participation existe deja'
            ], 409); // 409 Conflict
        }


        $participation = Participation::create([
            'id_utilisateur' => $request['id_utilisateur'],
            'id_evenement' => $request['id_evenement'],
            'presence' => true

        ]);

        return response()->json([
            'data' => new ParticipationResource($participation),
            'message' => 'Participation creee avec succes'
        ],201);


    }

}
