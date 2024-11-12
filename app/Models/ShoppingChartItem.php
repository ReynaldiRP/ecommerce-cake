<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ShoppingChartItemTopping;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ShoppingChartItem extends Model
{
    use HasFactory;

    protected $table = 'shopping_chart_items';
    protected $fillable = [
        'shopping_chart_id',
        'cake_id',
        'cake_flavour_id',
        'quantity',
        'price'
    ];


    public function cart(): BelongsTo
    {
        return $this->belongsTo(ShoppingChart::class, 'shopping_chart_id', 'id');
    }

    public function cake(): BelongsTo
    {
        return $this->belongsTo(Cake::class, 'cake_id', 'id');
    }

    public function cakeSize(): BelongsTo
    {
        return $this->belongsTo(CakeSize::class, 'cake_size_id', 'id');
    }

    public function cakeFlavour(): BelongsTo
    {
        return $this->belongsTo(Flavour::class, 'cake_flavour_id', 'id');
    }
    
    public function cakeTopping(): BelongsToMany
    {
        return $this->belongsToMany(Topping::class, 'shopping_chart_item_topping', 'shopping_chart_item_id', 'topping_id');
    }
}
