<?php

namespace App\Models;
// Support
use Illuminate\Database\Eloquent\Factories\HasFactory;
// Models
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Category extends Model
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
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
