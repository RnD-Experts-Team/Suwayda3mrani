<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteContent;
use App\Models\Language;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index()
    {
        $contents = SiteContent::all();
        return view('admin.contents.index', compact('contents'));
    }

    public function create()
    {
        $languages = Language::getActive();
        return view('admin.contents.create', compact('languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|unique:site_contents',
        ]);

        $contentData = [];
        $languages = Language::getActive();
        
        foreach ($languages as $language) {
            $contentData["content_{$language->code}"] = $request->input("content_{$language->code}", []);
        }

        SiteContent::create([
            'key' => $request->key,
            'content_en' => $contentData['content_en'] ?? [],
            'content_ar' => $contentData['content_ar'] ?? [],
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.contents.index')->with('success', 'Content created successfully!');
    }

    public function edit(SiteContent $content)
    {
        $languages = Language::getActive();
        return view('admin.contents.edit', compact('content', 'languages'));
    }

    public function update(Request $request, SiteContent $content)
    {
        $contentData = [];
        $languages = Language::getActive();
        
        foreach ($languages as $language) {
            $contentData["content_{$language->code}"] = $request->input("content_{$language->code}", []);
        }

        $content->update([
            'content_en' => $contentData['content_en'] ?? [],
            'content_ar' => $contentData['content_ar'] ?? [],
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.contents.index')->with('success', 'Content updated successfully!');
    }

    public function destroy(SiteContent $content)
    {
        $content->delete();
        return redirect()->route('admin.contents.index')->with('success', 'Content deleted successfully!');
    }
}
