<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Story;
use App\Models\Language;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function index()
    {
        $stories = Story::latest()->paginate(20);
        return view('admin.stories.index', compact('stories'));
    }

    public function create()
    {
        $languages = Language::getActive();
        return view('admin.stories.create', compact('languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image_url' => 'required|url',
        ]);

        $data = $request->only(['image_url']);
        $data['is_active'] = $request->has('is_active');
        
        // Handle multilingual titles and content
        $languages = Language::getActive();
        foreach ($languages as $language) {
            $data["title_{$language->code}"] = $request->input("title_{$language->code}");
            $data["content_{$language->code}"] = $request->input("content_{$language->code}");
        }

        Story::create($data);

        return redirect()->route('admin.stories.index')->with('success', 'Story created successfully!');
    }

    public function edit(Story $story)
    {
        $languages = Language::getActive();
        return view('admin.stories.edit', compact('story', 'languages'));
    }

    public function update(Request $request, Story $story)
    {
        $request->validate([
            'image_url' => 'required|url',
        ]);

        $data = $request->only(['image_url']);
        $data['is_active'] = $request->has('is_active');
        
        // Handle multilingual titles and content
        $languages = Language::getActive();
        foreach ($languages as $language) {
            $data["title_{$language->code}"] = $request->input("title_{$language->code}");
            $data["content_{$language->code}"] = $request->input("content_{$language->code}");
        }

        $story->update($data);

        return redirect()->route('admin.stories.index')->with('success', 'Story updated successfully!');
    }

    public function destroy(Story $story)
    {
        $story->delete();
        return redirect()->route('admin.stories.index')->with('success', 'Story deleted successfully!');
    }
}
