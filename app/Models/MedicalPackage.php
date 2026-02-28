<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class MedicalPackage extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['title', 'subtitle', 'description'];
    protected $fillable = ['image', 'category', 'duration', 'cities_count', 'price_range', 'is_popular', 'is_featured', 'features'];
    
    protected $casts = [
        'features' => 'array',
        'is_popular' => 'boolean',
        'is_featured' => 'boolean',
    ];
}