<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSectionTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['badge', 'title', 'description', 'btn1_text', 'btn2_text'];
}