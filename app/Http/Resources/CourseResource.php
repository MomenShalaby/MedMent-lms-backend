<?php

namespace App\Http\Resources;

use App\Models\CourseImages;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            // 'category' =>$this->categories_id,
            'id' => $this->id,
            'name' => $this->course_name,
            'description' => $this->description,
            'image' => $this->image,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'instructor' => $this->instructor,
            'title' => $this->course_title,
            'video' => $this->video,
            'label' => $this->label,
            'duration' => $this->duration,
            'resources' => $this->resources,
            'certificate' => $this->certificate,
            'price' => $this->price,
            'prerequisites' => $this->prerequisites,
            'featured' => $this->featured,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'sections' => CourseSectionResource::collection($this->whenLoaded('sections')),
        ];
    }
}
