<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Language;

class LanguageController extends Controller
{
    public function switch($code)
    {
        $language = Language::where('code', $code)->where('is_active', true)->first();
        
        if ($language) {
            Session::put('locale', $code);
            Session::put('direction', $language->direction);
        }
        
        return redirect()->back();
    }
}
