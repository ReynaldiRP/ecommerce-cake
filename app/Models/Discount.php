<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Discount extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'discount_percentage', 'start_date', 'end_date'];


    public function cake (): HasMany
    {
        return $this->hasMany(Cake::class, 'discount_id');
    }
}
