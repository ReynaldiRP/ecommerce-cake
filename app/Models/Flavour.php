<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flavour extends Model
{
    use HasFactory;
    protected $table = 'flavours';
    protected $fillable = ['name', 'price', 'image_url'];
}