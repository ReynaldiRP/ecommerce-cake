<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShoppingChart extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'total_price'
    ];

    /**
     * The cart items associated with the ShoppingChart
     *
     * @return HasMany<ShoppingChartItem>
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(ShoppingChartItem::class, 'shopping_chart_id');
    }

    /**
     * Get the user that owns the ShoppingChart
     *
     * @return BelongsTo<User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
