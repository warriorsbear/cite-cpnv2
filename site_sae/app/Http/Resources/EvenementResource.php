<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EvenementResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id_evenement,
            'titre' => $this->titre,
            'description' => $this->descriptif,
            'lieu' => $this->lieu,
            'type' => $this->type,
            'officiel' => $this->officiel,
            'id_utilisateur' => $this->id_utilisateur,
            'date_heure' => $this->date_heure,
        ];
    }
}
