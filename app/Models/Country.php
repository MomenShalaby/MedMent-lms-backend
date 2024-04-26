<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'sortname',
        'phoneCode',
    ];
    public $timestamps = false;

    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }
}
