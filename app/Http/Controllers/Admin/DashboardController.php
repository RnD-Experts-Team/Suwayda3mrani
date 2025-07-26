<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteContent;
use App\Models\MediaItem;
use App\Models\Story;
use App\Models\Partner;
use App\Models\Counter;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'contents' => SiteContent::count(),
            'media_items' => MediaItem::count(),
            'stories' => Story::count(),
            'partners' => Partner::count(),
            'counters' => Counter::count(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    }
}
