<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogTranslation extends Model
{
    // public $timestamps = false;

    protected $fillable = [
        'blog_id', 
        'locale', 
        'title', 
        'summary', 
        'description', 
        'tags'
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
