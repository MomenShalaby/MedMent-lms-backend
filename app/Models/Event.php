<?php

namespace App\Models;

use App\Traits\NotifiableEvent;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use NotifiableEvent;

    use HasFactory;
    protected $fillable = ['name', 'image', 'description', 'start_date', 'end_date'];



    protected function image(): Attribute
    {
        return Attribute::make(function ($value, $attributes) {
            if (!$value) {
                return "/event.png"; // Assuming the image is stored in the 'storage/avatars' directory
            }
            return $value; // Adjust the path as needed if the image is stored elsewhere
        });
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }


    public function attendees(): HasMany
    {
        return $this->hasMany(Attendee::class);
    }
}
