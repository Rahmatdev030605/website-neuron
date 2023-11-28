<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPages extends Model
{
    use HasFactory;
    
    protected $table = 'product_pages';

    protected $fillable = [
        'hero_title',
        'hero_desc',
        'hero_image',
    ];
}
