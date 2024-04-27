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
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'fname' => $this->fname,
            'lname' => $this->lname,
            'email' => $this->email,
            'gender' => $this->gender,
            'avatar' => $this->avatar,
            'bio' => $this->bio,
            'subscription_id' => $this->subscription_id,
            'subscription' => $this->whenLoaded('subscription'),
            'country_id' => $this->country_id,
            'country' => $this->whenLoaded('country'),
            'state_id' => $this->state_id,
            'state' => $this->whenLoaded('state'),
            'experiences' => $this->whenLoaded('experiences'),
        ];
    }
}
