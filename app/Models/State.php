<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'country_id',
    ];

    public $timestamps = false;

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class);
    }

    public function education(): HasMany
    {
        return $this->hasMany(Education::class);
    }
}
