<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Course extends Model
{
    use HasFactory;
    // use HasUuids;

    protected $fillable = ['course_name', 'user_id', 'description'];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    // public function attendees(): HasMany
    // {
    //     return $this->hasMany(Attendee::class);
    // }
}
