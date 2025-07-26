<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MediaItem;

class MediaController extends Controller
{
    public function index()
    {
        $mediaItems = MediaItem::where('is_active', true)
            ->orderBy('sort_order')
            ->paginate(12);
        
        return view('media', compact('mediaItems'));
    }
}
