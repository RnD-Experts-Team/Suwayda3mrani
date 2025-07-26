<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = [
        'name_en', 'name_ar', 'logo_url', 'website_url',
        'is_active', 'sort_order'
    ];

    public function getName($locale = 'en')
    {
        return $locale === 'ar' ? $this->name_ar : $this->name_en;
    }
}
