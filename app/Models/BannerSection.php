<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BannerSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'page',
        'name',
        'short_title',
        'long_title',
        'image',
        'short_description',
        'long_description',
        'meta_title',
        'meta_description',
        'meta_image',
        'meta_keywords',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}