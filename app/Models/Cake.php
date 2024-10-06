<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cake extends Model
{
    use HasFactory;
    protected $fillable = [
        'cake_size_id',
        'name',
        'image_url',
        'base_price',
        'description',
        'personalization_type'
    ];

    /**
     * Get the cake size that owns the Cake
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cakeSize(): BelongsTo
    {
        return $this->belongsTo(CakeSize::class, 'cake_size_id', 'id');
    }

    /**
     * Get the cart items for the Cake
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cartItem(): HasMany
    {
        return $this->hasMany(ShoppingChartItem::class, 'cake_id');
    }

    /**
     * Get the order items for the Cake
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderItem(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'cake_id');
    }
}
