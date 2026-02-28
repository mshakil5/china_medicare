<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhyChooseTranslation extends Model
{
    protected $fillable = [
        'why_choose_id',
        'locale',
        'title',
        'description'
    ];

    public function whyChoose()
    {
        return $this->belongsTo(WhyChoose::class);
    }
}
