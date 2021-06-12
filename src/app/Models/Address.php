<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// Models
use Illuminate\Database\Eloquent\Model;
use App\Models\Province;
use App\Models\User;

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
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Create new address
     *
     * @param Array $data
     *
     * return void
     */

    public function storeAddress($data)
    {
        $this->address = $data['address'] ?: null;
        $this->apartment = $data['apartment'] ?: null;
        $this->city = $data['city'] ?: null;

        if (isset($data['province_id'])) {
            $province = Province::find($data['province_id']);
            $this->province()->associate($province);
        }
        $this->postal_code = $data['postal_code'] ?: null;
        $this->phone = $data['phone'] ?: null;

        $this->save();
    }
}
