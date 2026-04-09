<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalPackage extends Model implements TranslatableContract
{
    use HasFactory, Translatable;  // ✅ FIXED: Removed duplicate Translatable

    protected $table = 'medical_packages';

    protected $fillable = [
        'category',
        'duration',
        'cities_count',
        'price_range',
        'is_popular',
        'is_featured',
        'features',
        'image',
        'og_image',
        'canonical_url',
        'status'
    ];

    protected $casts = [
        'is_popular'   => 'boolean',
        'is_featured'  => 'boolean',
        'features'     => 'array',
        'status'       => 'boolean',
    ];

    public $translatedAttributes = [
        'title',
        'subtitle',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    public static function getCategories(): array
    {
        return [
            'Surgery'           => 'Surgery',
            'Treatment'         => 'Treatment',
            'Checkup'           => 'Checkup',
            'Wellness'          => 'Wellness & Spa',
            'Dental'            => 'Dental Care',
            'Eye Care'          => 'Eye Care',
            'Cardiology'        => 'Cardiology',
            'Orthopedics'       => 'Orthopedics',
            'Oncology'          => 'Oncology',
            'Neurology'         => 'Neurology',
            'Fertility'         => 'Fertility Treatment',
            'Cosmetic'          => 'Cosmetic Surgery',
            'Weight Loss'       => 'Weight Loss',
            'Transplant'        => 'Organ Transplant',
            'Dialysis'          => 'Dialysis',
            'Rehabilitation'    => 'Rehabilitation',
            'Mental Health'     => 'Mental Health',
            'Pediatric'         => 'Pediatric',
            'Gynecology'        => 'Gynecology',
            'Urology'           => 'Urology',
        ];
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image ? asset($this->image) : asset('assets/images/no-image.png');
    }

    public function getOgImageUrlAttribute(): string
    {
        return $this->og_image ? asset($this->og_image) : $this->image_url;
    }
}