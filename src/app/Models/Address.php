<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// Models
use Illuminate\Database\Eloquent\Model;
use App\Models\Province;

class Address extends Model
{
    use HasFactory;


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_billing' => 'boolean',
        'is_active'  => 'boolean',
    ];

    /**
     * Get address province
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Get user the belongs to addresses
     */
    public function user()
    {
        return $this->belongsTo(Province::class);
    }
}
