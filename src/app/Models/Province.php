<?php

namespace App\Models;
// Support
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Models
use Illuminate\Database\Eloquent\Model;
use App\Models\Country;

class Province extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id',
        'name',
        'abbreviation'
    ];

    /**
     * Get province country
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
