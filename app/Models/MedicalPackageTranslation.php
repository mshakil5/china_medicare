<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalPackageTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'subtitle', 'description'];
}