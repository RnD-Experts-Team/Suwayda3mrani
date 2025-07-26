<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use App\Models\Language;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    public function index(Request $request)
    {
        $group = $request->get('group', 'all');
        $query = Translation::query();
        
        if ($group !== 'all') {
            $query->where('group', $group);
        }
        
        $translations = $query->paginate(20);
        $groups = Translation::distinct()->pluck('group');
        $languages = Language::getActive();
        
        return view('admin.translations.index', compact('translations', 'groups', 'languages', 'group'));
    }

    public function create()
    {
        $languages = Language::getActive();
        $groups = ['general', 'navigation', 'buttons', 'messages', 'labels'];
        return view('admin.translations.create', compact('languages', 'groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|unique:translations',
            'group' => 'required',
        ]);

        $translations = [];
        $languages = Language::getActive();
        
        foreach ($languages as $language) {
            $translations[$language->code] = $request->input("translation_{$language->code}");
        }

        Translation::create([
            'key' => $request->key,
            'translations' => $translations,
            'group' => $request->group,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.translations.index')->with('success', 'Translation created successfully!');
    }

    public function edit(Translation $translation)
    {
        $languages = Language::getActive();
        $groups = ['general', 'navigation', 'buttons', 'messages', 'labels'];
        return view('admin.translations.edit', compact('translation', 'languages', 'groups'));
    }

    public function update(Request $request, Translation $translation)
    {
        $request->validate([
            'group' => 'required',
        ]);

        $translations = [];
        $languages = Language::getActive();
        
        foreach ($languages as $language) {
            $translations[$language->code] = $request->input("translation_{$language->code}");
        }

        $translation->update([
            'translations' => $translations,
            'group' => $request->group,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.translations.index')->with('success', 'Translation updated successfully!');
    }

    public function destroy(Translation $translation)
    {
        $translation->delete();
        return redirect()->route('admin.translations.index')->with('success', 'Translation deleted successfully!');
    }
}
