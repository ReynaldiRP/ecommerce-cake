<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CakeSize extends Model
{
    use HasFactory;
    protected $table = 'cake_sizes';
    protected $fillable = ['size', 'price'];


    public function shoppingChartItem(): HasMany
    {
        return $this->hasMany(ShoppingChartItem::class, 'cake_size_id', 'id');
    }

    public function orderItem(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'cake_size_id', 'id');
    }
}
