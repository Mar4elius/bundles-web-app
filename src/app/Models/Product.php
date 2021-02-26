<?php

namespace App\Models;
// Support
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Model
use Illuminate\Database\Eloquent\Model;
use App\Models\Bundle;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * Get bundles to which product belongs
     */
    public function bundles()
    {
        return $this->belongsToMany(Bundle::class);
    }

    /**
     * Get category to which product belongs
     */
    public function category()
    {
        return $this->belongsTo(category::class);
    }
}
