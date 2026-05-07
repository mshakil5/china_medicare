<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'title', 'subtitle', 'file_path', 'thumbnail', 
        'video_link', 'sort_order', 'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    // Scopes for frontend
    public function scopeActive($query) { return $query->where('status', 1); }
    public function scopeOrdered($query) { return $query->orderBy('sort_order', 'asc'); }

    // Accessor to get correct preview image
    public function getPreviewImageAttribute()
    {
        if ($this->type === 'youtube' && $this->video_link) {
            // Extract YouTube ID and get high-res thumbnail
            preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|v\/)|youtu\.be\/)([a-zA-Z0-9\-_]+)/', $this->video_link, $matches);
            if (!empty($matches[1])) {
                return "https://img.youtube.com/vi/{$matches[1]}/hqdefault.jpg";
            }
        }
        if ($this->type === 'video' && $this->thumbnail) {
            return $this->thumbnail;
        }
        return $this->file_path;
    }

    // Accessor to convert watch URL to embed URL
    public function getEmbedUrlAttribute()
    {
        if (!$this->video_link) return null;
        
        preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|v\/)|youtu\.be\/)([a-zA-Z0-9\-_]+)/', $this->video_link, $matches);
        
        if (!empty($matches[1])) {
            return "https://www.youtube.com/embed/{$matches[1]}";
        }
        
        return null;
    }
}