<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaItem extends Model
{
    protected $fillable = [
        'title_en', 'title_ar', 'description_en', 'description_ar',
        'media_url', 'type', 'is_active', 'sort_order'
    ];

    public function getTitle($locale = 'en')
    {
        return $locale === 'ar' ? $this->title_ar : $this->title_en;
    }

    public function getDescription($locale = 'en')
    {
        return $locale === 'ar' ? $this->description_ar : $this->description_en;
    }
}
