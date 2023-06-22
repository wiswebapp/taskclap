<?php

namespace App\Models;

use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\HasWallet;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements Wallet
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasWallet;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'country_id',
        'state_id',
        'city_id',
        'area_id',
        'address',
        'house_no',
        'landmark',
        'address_local',
        'address_lat',
        'address_long',
        'is_blocked',
        'status',
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user's Created Date
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date('d-m-Y', strtotime($value)),
        );
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
