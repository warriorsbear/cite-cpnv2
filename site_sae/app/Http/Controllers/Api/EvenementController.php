<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EvenementResource;
use App\Models\Evenement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EvenementController extends Controller
{
    public function index()
    {

        $evenements = Evenement::get();
        if($evenements)
        {
            return EvenementResource::collection($evenements);
        }
        else
        {
            return response()->json(['message' => 'Aucun événement trouvé'],200);
        }

    }
    public function getEvenementById(Request $request)
    {
        $eventId = $request->query('id_evenement');

        if ($eventId) {
            $evenements = Evenement::where('id_evenement', $eventId)->get();
        } else {
            $evenements = Evenement::all();
        }

        return response()->json($evenements);
    }


    public function listEvents()
    {
        $events = Evenement::select('id', 'titre')->get();
        return response()->json(['events' => $events]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valider les données de la requête
        $validator = Validator::make($request->all(), [
            'titre' => 'required|string|max:50',
            'date_heure' => 'required|date',
            'lieu' => 'required|string|max:50',
            'type' => 'required|string|max:50',
            'descriptif' => 'nullable|string',
            'officiel' => 'nullable|boolean',
            'id_utilisateur'=> 'required|integer'
        ]);

        if($validator->fails())
        {
            return response()->json(['error' => $validator->errors()], 422);
        }



        // Créer un nouvel événement
        $evenement = Evenement::create([
            'titre' => $request->titre,
            'date_heure' => $request->date_heure,
            'lieu' => $request->lieu,
            'type' => $request->type,
            'descriptif' => $request->descriptif,
            'officiel' => $request->officiel,
            'id_utilisateur' => $request->id_utilisateur
        ]);
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $evenement = Evenement::findOrFail($id);

        // Retourner la vue avec l'événement
        return view('evenements.show', compact('evenement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evenement $evenement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Evenement $evenement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_evenement' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }
        $deleted=Evenement::deleteById($request['id_evenement']);
        if ($deleted) {
            return response()->json([
                'message' => 'Événement supprimé avec succès'
            ], 200);
        }
        else{
            return response()->json([
                'message' => 'Événement non trouvé'
            ], 404);
        }
    }
}
