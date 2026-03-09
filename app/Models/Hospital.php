<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Hospital extends Model implements TranslatableContract
{
    use Translatable;

    protected $fillable = ['image', 'slug'];
    public $translatedAttributes = ['name', 'specialty'];
}