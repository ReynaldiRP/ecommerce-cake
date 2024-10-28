<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'cake_id',
        'cake_flavour_id',
        'quantity',
        'price',
    ];

    /**
     * Get the order that owns the OrderItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    /**
     * Get the cake that owns the OrderItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cake(): BelongsTo
    {
        return $this->belongsTo(Cake::class, 'cake_id', 'id');
    }

    /**
     * Get the flavour that owns the OrderItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cakeFlavour(): BelongsTo
    {
        return $this->belongsTo(Flavour::class, 'cake_flavour_id', 'id');
    }

    /**
     * The toppings that belong to the OrderItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cakeTopping(): BelongsToMany
    {
        return $this->belongsToMany(Topping::class, 'order_item_toppings', 'order_item_id', 'topping_id');
    }
}
