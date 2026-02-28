<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class HeroSection extends Model implements TranslatableContract
{
    use Translatable;

    // These fields are handled by HeroSectionTranslation
    public $translatedAttributes = ['badge', 'title', 'description', 'btn1_text', 'btn2_text'];
    
    // These fields are in the main hero_sections table
    protected $fillable = ['image', 'video_url', 'btn1_url', 'btn2_url', 'stats', 'info_cards'];

    protected $casts = [
        'stats' => 'array',
        'info_cards' => 'array'
    ];
}