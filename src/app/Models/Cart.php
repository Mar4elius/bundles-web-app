<?php

namespace App\Models;
// Support
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Models
use App\Models\CartBundle;

class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_completed',
        'is_checked_out',
        'total',
    ];

    /**
     * Get cart bundles
     */
    public function cartBundles()
    {
        return $this->hasMany(CartBundle::class);
    }
}
