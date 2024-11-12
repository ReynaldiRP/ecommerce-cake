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
        'category_id',
        'name',
        'image_url',
        'base_price',
        'description',
        'personalization_type'
    ];

    /**
     * Get the category that owns the Cake.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
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
