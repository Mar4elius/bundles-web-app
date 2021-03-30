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
        'category_id',
        'name',
        'slug',
        'description',
        'image_path', //TODO: remove later
        'price',
        'qnt_left'
    ];

    // /**
    //  * Get bundles to which product belongs
    //  */
    // public function bundles()
    // {
    //     return $this->belongsToMany(Bundle::class);
    // }
    /**
     * Get bundles to which product belongs
     */
    public function bundles()
    {
        return $this->morphToMany(Bundle::class, 'bundleable');
    }

    /**
     * Get category to which product belongs
     */
    public function category()
    {
        return $this->belongsTo(category::class);
    }
}
