<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Course extends Model
{
    use HasFactory;
    // use HasUuids;

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'instructor',
        'course_name',
        'course_title',
        'image',
        'description',
        'video',
        'label',
        'duration',
        'resources',
        'certificate',
        'price',
        'prerequisites',
        'featured',
        'status',
    ];


    protected function image(): Attribute
    {
        return Attribute::make(function ($value, $attributes) {
            if (!$value) {
                return "/course.png"; // Assuming the image is stored in the 'storage/avatars' directory
            }
            return $value; // Adjust the path as needed if the image is stored elsewhere
        });
    }
    public function sections()
    {
        return $this->hasMany(CourseSection::class);
    }
    
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // public function price()
    // {
    //     return $this->hasOne(CoursePrice::class);
    // }
}
