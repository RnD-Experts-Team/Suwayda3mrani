<?php
namespace App\Http\Controllers;

use App\Models\SiteContent;
use App\Models\MediaItem;
use App\Models\Story;
use App\Models\Partner;
use App\Models\Counter;

class HomeController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();
        
        $data = [
            'hero' => SiteContent::getContent('hero', $locale),
            'counters' => Counter::where('is_active', true)->orderBy('sort_order')->get(),
            'takeAction' => SiteContent::getContent('take_action', $locale),
            'mediaItems' => MediaItem::where('is_active', true)->inRandomOrder()->limit(8)->get(),
            'stories' => Story::where('is_active', true)->latest()->limit(6)->get(),
            'partners' => Partner::where('is_active', true)->orderBy('sort_order')->get(),
        ];

        return view('home', compact('data', 'locale'));
    }
}