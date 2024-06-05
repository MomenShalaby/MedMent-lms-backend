<?php

namespace App\Models;

use App\Enums\Enums\SubscriptionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable = [
        'price',
    ];

    protected $hidden = [
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'type' => SubscriptionType::class,
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
