<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cake extends Model
{
    use HasFactory;
    protected $fillable = [
        'cake_size_id',
        'name',
        'image_url',
        'base_price',
        'personalization_type'
    ];

    public function cakeSize(): BelongsTo
    {
        return $this->belongsTo(CakeSize::class, 'cake_size_id', 'id');
    }
}
