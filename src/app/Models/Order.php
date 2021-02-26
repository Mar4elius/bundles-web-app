<?php

namespace App\Models;

// Support
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Models
use App\Models\User;
use App\Models\Bundle;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'order_number',
        'total',
    ];

    /**
     * Get user that belong to order
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get bundles that belong to order
     */
    public function bundles()
    {
        return $this->belongsToMany(Bundle::class);
    }
}
