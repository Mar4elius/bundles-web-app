<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// Models
use App\Models\Province;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get user province
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Get user's full name
     *
     * @return string
     */

    public function getFullName()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the user's first name.
     *
     * @param  string  $value
     *
     * @return string
     */
    public function getPhoneAttribute($value)
    {
        return substr($value, -10, -7) . '-' . substr($value, -7, -4) . '-' . substr($value, -4);
    }
}
