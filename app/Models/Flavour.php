<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Flavour extends Model
{
    use HasFactory;
    protected $table = 'flavours';
    protected $fillable = ['name', 'price', 'image_url'];


    public function cartItem(): HasMany
    {
        return $this->hasMany(ShoppingChartItem::class, 'cake_flavour_id');
    }
}
