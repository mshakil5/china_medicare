<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalPackage extends Model implements TranslatableContract
{
    use HasFactory, Translatable; 

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

    // ✅ Priority categories (shown first in this exact order)
    public static function getPriorityCategories(): array
    {
        return ['Surgery', 'Treatment', 'Checkup'];
    }

    // ✅ Last category (shown at the end)
    public static function getLastCategory(): string
    {
        return 'Other Services';
    }

    public static function getCategories(): array
    {
        return [
            'Surgery'           => 'Surgery',
            'Treatment'         => 'Treatment',
            'Checkup'           => 'Checkup',
            'Consultation'      => 'Consultation',
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
            'Other Services'    => 'Other Services',
        ];
    }

    /**
     * ✅ Returns categories sorted: Priority first, then alphabetical, then "Other Services" last
     */
    public static function getOrderedCategories(): array
    {
        $allCategories = self::getCategories();
        $priority = self::getPriorityCategories();
        $last = self::getLastCategory();

        $ordered = [];

        // 1. Add priority categories first
        foreach ($priority as $cat) {
            if (isset($allCategories[$cat])) {
                $ordered[$cat] = $allCategories[$cat];
            }
        }

        // 2. Add remaining categories alphabetically (excluding priority and last)
        $remaining = array_diff_key($allCategories, array_flip($priority), [$last => '']);
        ksort($remaining);
        $ordered = array_merge($ordered, $remaining);

        // 3. Add "Other Services" at the very end
        if (isset($allCategories[$last])) {
            $ordered[$last] = $allCategories[$last];
        }

        return $ordered;
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