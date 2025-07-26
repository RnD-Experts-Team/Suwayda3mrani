<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
   protected $fillable = [
        'title_en', 'title_ar', 'content_en', 'content_ar',
        'image_url', 'is_active'
    ];

    public function getTitle($locale = 'en')
    {
        return $locale === 'ar' ? $this->title_ar : $this->title_en;
    }

    public function getContent($locale = 'en')
    {
        return $locale === 'ar' ? $this->content_ar : $this->content_en;
    }

    public function getExcerpt($locale = 'en', $length = 100)
    {
        $content = $this->getContent($locale);
        return strip_tags(substr($content, 0, $length)) . '...';
    }
}
