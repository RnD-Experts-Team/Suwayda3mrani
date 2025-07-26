<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    protected $fillable = [
        'title_en', 'title_ar', 'count', 'icon',
        'is_active', 'sort_order'
    ];

    public function getTitle($locale = 'en')
    {
        return $locale === 'ar' ? $this->title_ar : $this->title_en;
    }
}
