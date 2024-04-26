<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\Enums\Gender;
use App\Enums\Enums\SubscriptionType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fname',
        'lname',
        'email',
        'password',
        'gender',
        'subscription_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'gender' => Gender::class,
            // 'subscription_type' => SubscriptionType::class,
        ];
    }

    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value === 'doctor.png' || $value === 'fdoctor.png' ? $value : "/storage/avatars/$value",
        );
        // $user = Auth::user();
        // $avatar = $user->gender = 'female' ? 'fdoctor.png' : 'doctor.png';
        // return Attribute::make(
        //     get: fn($value) => $value ? "/storage/avatars/$value" : $avatar,
        // );
        // return Attribute::make(
        //     get: fn($value) => Str::endsWith($value, '.svg') ? "/avatars/$value" : "/storage/uploadedAvatars/$value",
        // );
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
