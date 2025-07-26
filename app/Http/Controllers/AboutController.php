<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteContent;

class AboutController extends Controller
{
     public function index()
    {
        $locale = app()->getLocale();
        
        $data = [
            'about' => SiteContent::getContent('about_us', $locale),
            'vision' => SiteContent::getContent('our_vision', $locale),
            'contact' => SiteContent::getContent('contact_us', $locale),
        ];

        return view('about', compact('data', 'locale'));
    }
}
