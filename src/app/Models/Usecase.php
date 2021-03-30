<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usecase extends Model
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
