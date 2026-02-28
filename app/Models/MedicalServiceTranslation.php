<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalServiceTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'medical_service_id',
        'locale',
        'title',
        'description',
        'features'
    ];

    protected $casts = [
        'features' => 'array'
    ];
}
