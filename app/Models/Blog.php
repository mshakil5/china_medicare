<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['image', 'slug', 'read_time', 'status'];

    public function translations()
    {
        return $this->hasMany(BlogTranslation::class);
    }

    // public function translation($locale = null)
    // {
    //     $locale = $locale ?? app()->getLocale();
    //     return $this->hasMany(BlogTranslation::class)->where('locale', $locale)->first() 
    //            ?? $this->hasMany(BlogTranslation::class)->first();
    // }

    public function translation($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        
        // Use 'translations' (the relationship collection) instead of 'translations()' (the query builder)
        return $this->translations->where('locale', $locale)->first() 
            ?? $this->translations->first();
    }


}
