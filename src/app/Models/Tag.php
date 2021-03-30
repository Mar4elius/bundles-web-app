<?php

namespace App\Models;
// Support
use Illuminate\Database\Eloquent\Factories\HasFactory;
// Models
use Illuminate\Database\Eloquent\Model;
use App\Models\Bundle;

class Tag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    /**
     * Get bundles to which usecase belongs
     */
    public function bundles()
    {
        return $this->morphToMany(Bundle::class, 'bundleable');
    }
}
