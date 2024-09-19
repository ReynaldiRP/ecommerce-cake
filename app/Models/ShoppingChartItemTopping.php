<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingChartItemTopping extends Model
{
    use HasFactory;


    protected $table = 'shopping_chart_item_topping';
    protected $fillable = ['shopping_chart_item_id', 'topping_id'];
}
