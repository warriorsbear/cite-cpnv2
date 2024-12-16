<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParticipationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id_utilisateur' => $this->id_utilisateur,
            'id_evenement' => $this->id_evenement,
            'presence' => $this->presence
        ];
    }
}
