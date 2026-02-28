<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhyChoose extends Model
{
    protected $fillable = [
        'icon',
        'serial',
        'status'
    ];

    // Relationship
    public function translations()
    {
        return $this->hasMany(WhyChooseTranslation::class);
    }

    // THIS METHOD WAS MISSING 
    public function translate($locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return $this->translations
            ->where('locale', $locale)
            ->first();
    }
}
