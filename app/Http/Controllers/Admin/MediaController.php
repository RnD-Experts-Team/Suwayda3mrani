<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaItem;
use App\Models\Language;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index()
    {
        $mediaItems = MediaItem::latest()->paginate(20);
        return view('admin.media.index', compact('mediaItems'));
    }

    public function create()
    {
        $languages = Language::getActive();
        return view('admin.media.create', compact('languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'media_url' => 'required|url',
            'type' => 'required|in:image,video',
        ]);

        $data = $request->only(['media_url', 'type', 'sort_order']);
        $data['is_active'] = $request->has('is_active');
        
        // Handle multilingual titles and descriptions
        $languages = Language::getActive();
        foreach ($languages as $language) {
            $data["title_{$language->code}"] = $request->input("title_{$language->code}");
            $data["description_{$language->code}"] = $request->input("description_{$language->code}");
        }

        MediaItem::create($data);

        return redirect()->route('admin.media.index')->with('success', 'Media item created successfully!');
    }

    public function edit(MediaItem $media)
    {
        $languages = Language::getActive();
        return view('admin.media.edit', compact('media', 'languages'));
    }

    public function update(Request $request, MediaItem $media)
    {
        $request->validate([
            'media_url' => 'required|url',
            'type' => 'required|in:image,video',
        ]);

        $data = $request->only(['media_url', 'type', 'sort_order']);
        $data['is_active'] = $request->has('is_active');
        
        // Handle multilingual titles and descriptions
        $languages = Language::getActive();
        foreach ($languages as $language) {
            $data["title_{$language->code}"] = $request->input("title_{$language->code}");
            $data["description_{$language->code}"] = $request->input("description_{$language->code}");
        }

        $media->update($data);

        return redirect()->route('admin.media.index')->with('success', 'Media item updated successfully!');
    }

    public function destroy(MediaItem $media)
    {
        $media->delete();
        return redirect()->route('admin.media.index')->with('success', 'Media item deleted successfully!');
    }
}
