<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShoppingChart extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'total_price'
    ];

    public function cartItems(): HasMany
    {
        return $this->hasMany(ShoppingChartItem::class, 'shopping_chart_id');
    }
}
