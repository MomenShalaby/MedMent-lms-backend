<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Education extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'degree_id',
        'start_date',
        'end_date',
        'description',
        'university_id',
        'other_university',
        'country_id',
        'state_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function degree(): BelongsTo
    {
        return $this->belongsTo(Degree::class);
    }
    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
}
