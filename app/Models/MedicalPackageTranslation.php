<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicalPackageTranslation extends Model
{
    public $timestamps = false;

    use HasFactory;

    protected $table = 'medical_package_translations';

    protected $fillable = [
        'medical_package_id',
        'locale',
        'title',
        'subtitle',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];
}