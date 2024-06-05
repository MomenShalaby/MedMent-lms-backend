<?php

namespace App\Http\Resources;

use App\Models\CourseImages;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseImagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'url' => $this->url,

        ];
    }
}
