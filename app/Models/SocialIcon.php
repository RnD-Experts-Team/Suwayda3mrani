<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialIcon extends Model
{
    protected $fillable = [
        'name', 'icon_class', 'url', 'color', 'is_active', 'sort_order'
    ];

    public static function getActive()
    {
        return self::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Optional: Add a mutator to handle the conversion
    public function setIsActiveAttribute($value)
    {
        $this->attributes['is_active'] = $value === 'on' || $value === '1' || $value === 1 || $value === true ? 1 : 0;
    }
}
