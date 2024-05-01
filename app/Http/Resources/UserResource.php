<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'fname' => $this->fname,
            'lname' => $this->lname,
            'email' => $this->email,
            'gender' => $this->gender,
            'avatar' => $this->avatar,
            'bio' => $this->bio,
            'subscription' => $this->whenLoaded('subscription'),
            'country' => $this->whenLoaded('country'),
            'state' => $this->whenLoaded('state'),
            'experiences' => ExperienceResource::collection($this->whenLoaded('experiences')),
            'education' => EducationResource::collection($this->whenLoaded('education')),
            // 'education' => $this->whenLoaded('education'),
        ];
    }
}
