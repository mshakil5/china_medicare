<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalTranslation extends Model
{
    
    protected $fillable = ['name', 'hospital_id', 'locale', 'specialty'];
}
