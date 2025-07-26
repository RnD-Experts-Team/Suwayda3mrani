<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteContent extends Model
{
    protected $fillable = ['key', 'content_en', 'content_ar', 'is_active'];
    protected $casts = [
        'content_en' => 'array',
        'content_ar' => 'array',
    ];

    public static function getContent($key, $locale = 'en')
    {
        $content = self::where('key', $key)->where('is_active', true)->first();
        if (!$content) return null;
        
        return $locale === 'ar' ? $content->content_ar : $content->content_en;
    }
}
