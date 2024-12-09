<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EvenementResource;
use App\Models\Evenement;
use Illuminate\Http\Request;

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
        $validatedData = $request->validate([
            'titre' => 'required|string|max:50',
            'date_heure' => 'required|date',
            'lieu' => 'required|string|max:50',
            'type' => 'required|string|max:50',
            'descriptif' => 'nullable|string',
            'officiel' => 'nullable|string',
            'id_utilisateur'=> 'required|integer'
        ]);

        // Créer un nouvel événement
        $evenement = Evenement::create($validatedData);

        // Retourner une réponse appropriée
        return new EvenementResource($evenement);
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
    public function destroy(Evenement $evenement)
    {
        //
    }
}
