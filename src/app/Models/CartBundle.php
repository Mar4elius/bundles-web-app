<?php

namespace App\Models;
// Support
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Models
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;

class CartBundle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cart_id',
        'order_id',
        'quantity',
        'price_per_bundle'
    ];

    /**
     * Get the order to which cart bundles belong.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the cart to which cart bundles belong.
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Get the cart to which cart bundles belong.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
