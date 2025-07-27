<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use App\Models\Language;
use Illuminate\Http\Request;

class CounterController extends Controller
{
    public function index()
    {
        $counters = Counter::orderBy('sort_order')->paginate(20);
        return view('admin.counters.index', compact('counters'));
    }

    public function create()
    {
        $languages = Language::getActive();
        return view('admin.counters.create', compact('languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'count' => 'required|integer|min:0',
            'type' => 'required|in:icon,image',
            'icon' => 'required_if:type,icon',
            'image_url' => 'required_if:type,image|url',
        ]);

        $data = $request->only(['count', 'icon', 'image_url', 'type', 'sort_order']);
        $data['is_active'] = $request->has('is_active');
        
        // Handle multilingual titles
        $languages = Language::getActive();
        foreach ($languages as $language) {
            $data["title_{$language->code}"] = $request->input("title_{$language->code}");
        }

        Counter::create($data);

        return redirect()->route('admin.counters.index')->with('success', 'Counter created successfully!');
    }

    public function edit(Counter $counter)
    {
        $languages = Language::getActive();
        return view('admin.counters.edit', compact('counter', 'languages'));
    }

    public function update(Request $request, Counter $counter)
    {
        $request->validate([
            'count' => 'required|integer|min:0',
            'type' => 'required|in:icon,image',
            'icon' => 'required_if:type,icon',
            'image_url' => 'required_if:type,image|url',
        ]);

        $data = $request->only(['count', 'icon', 'image_url', 'type', 'sort_order']);
        $data['is_active'] = $request->has('is_active');
        
        // Handle multilingual titles
        $languages = Language::getActive();
        foreach ($languages as $language) {
            $data["title_{$language->code}"] = $request->input("title_{$language->code}");
        }

        $counter->update($data);

        return redirect()->route('admin.counters.index')->with('success', 'Counter updated successfully!');
    }

    public function destroy(Counter $counter)
    {
        $counter->delete();
        return redirect()->route('admin.counters.index')->with('success', 'Counter deleted successfully!');
    }
}
