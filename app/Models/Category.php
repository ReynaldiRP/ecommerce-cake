<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    /**
     * Get the cakes for the category.
     *
     * @return HasMany
     */
    public function cake(): HasMany
    {
        return $this->hasMany(Cake::class, 'category_id');
    }
}
