<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseGoal extends Model
{
    use HasFactory;
    public function section()
    {
        return $this->belongsTo(Course::class);
    }
}