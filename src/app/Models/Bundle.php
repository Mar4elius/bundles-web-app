<?php

namespace App\Models;
// Support
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Models
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Bundle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'total',
    ];

    /**
     * Get orders that belong to Bundle
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    /**
     * Get products that belong to bundle
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
