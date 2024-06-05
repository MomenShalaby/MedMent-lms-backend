<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExperienceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'description' => $this->description,
            'hospital' => $this->whenLoaded('hospital'),
            'other_hospital' => $this->other_hospital,
            'country' => $this->whenLoaded('country'),
            'state' => $this->whenLoaded('state'),
            'user' => $this->whenLoaded('user'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            //  "country_id": 132,
            //         "state_id": 2034,
            //         "created_at": "2024-05-01T10:30:20.000000Z",
            //         "updated_at": "2024-05-01T10:30:20.000000Z"
        ];
    }
}
