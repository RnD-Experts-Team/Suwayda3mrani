<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Story;

class StoryController extends Controller
{
    public function show($id)
    {
        $story = Story::where('is_active', true)->findOrFail($id);
        $locale = app()->getLocale();
        
        return view('story', compact('story', 'locale'));
    }
}
