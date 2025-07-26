<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Models\Language;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = Session::get('locale');
        
        if (!$locale) {
            $defaultLang = Language::getDefault();
            $locale = $defaultLang ? $defaultLang->code : 'en';
            Session::put('locale', $locale);
            Session::put('direction', $defaultLang ? $defaultLang->direction : 'ltr');
        }
        
        App::setLocale($locale);
        
        return $next($request);
    }
}
