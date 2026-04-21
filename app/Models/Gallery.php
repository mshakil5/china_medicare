<?php
// app/Models/Gallery.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    use HasFactory;

    protected $table = 'galleries';

    protected $fillable = [
        'type',
        'file_path',
        'thumbnail',
        'link',
        'title',
        'subtitle',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    // ── Scopes ──────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeImages($query)
    {
        return $query->where('type', 'image');
    }

    public function scopeVideos($query)
    {
        return $query->where('type', 'video');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->latest();
    }

    // ── Accessors ────────────────────────────────────────
    // Returns thumbnail for videos, file_path for images
    public function getPreviewImageAttribute(): string
    {
        return $this->type === 'video' && $this->thumbnail
            ? $this->thumbnail
            : $this->file_path;
    }
}