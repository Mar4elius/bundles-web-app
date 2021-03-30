<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bundle;

class Section extends Model
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
        'description',
        'image_path' // TODO:remove later
    ];

    /**
     *  Get section bundles
     */
    public function bundles()
    {
        return $this->hasMany(Bundle::class);
    }
}
