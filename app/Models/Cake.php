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

    public function cakeSize(): BelongsTo
    {
        return $this->belongsTo(CakeSize::class, 'cake_size_id', 'id');
    }

    public function cartItem(): HasMany
    {
        return $this->hasMany(ShoppingChartItem::class, 'cake_id');
    }
}
