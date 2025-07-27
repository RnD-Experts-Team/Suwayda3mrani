<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    protected $fillable = [
        'title_en', 'title_ar', 'count', 'icon', 'image_url', 'type', 'is_active', 'sort_order'
    ];

    public function getTitle($locale = 'en')
    {
        return $this->{"title_$locale"} ?? $this->title_en ?? '';
    }

    public static function getActive()
    {
        return self::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }
}
