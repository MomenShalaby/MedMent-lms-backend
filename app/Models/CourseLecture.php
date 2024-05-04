<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseLecture extends Model
{
    use HasFactory;

    public function section()
    {
        return $this->belongsTo(CourseSection::class, 'section_id');
    }
}
