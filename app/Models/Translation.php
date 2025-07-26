<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Language;

class Translation extends Model
{
    protected $fillable = ['key', 'translations', 'group', 'is_active'];
    protected $casts = ['translations' => 'array'];

    public static function trans($key, $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        
        $translation = self::where('key', $key)
            ->where('is_active', true)
            ->first();
        
        if (!$translation) {
            return $key; // Return key if translation not found
        }
        
        return $translation->translations[$locale] ?? $translation->translations['en'] ?? $key;
    }

    public static function getByGroup($group = null, $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $query = self::where('is_active', true);
        
        if ($group) {
            $query->where('group', $group);
        }
        
        $translations = $query->get();
        $result = [];
        
        foreach ($translations as $translation) {
            $result[$translation->key] = $translation->translations[$locale] ?? $translation->translations['en'] ?? $translation->key;
        }
        
        return $result;
    }
}
