<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = ['code', 'name', 'direction', 'is_active', 'is_default'];

    public static function getActive()
    {
        return self::where('is_active', true)->get();
    }

    public static function getDefault()
    {
        return self::where('is_default', true)->first() ?: self::where('code', 'en')->first();
    }
}
