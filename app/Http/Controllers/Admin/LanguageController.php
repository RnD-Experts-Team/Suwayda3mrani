<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = Language::all();
        return view('admin.languages.index', compact('languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|size:2|unique:languages',
            'name' => 'required',
            'direction' => 'required|in:ltr,rtl',
        ]);

        // If this is set as default, unset others
        if ($request->has('is_default')) {
            Language::where('is_default', true)->update(['is_default' => false]);
        }

        Language::create([
            'code' => $request->code,
            'name' => $request->name,
            'direction' => $request->direction,
            'is_active' => $request->has('is_active'),
            'is_default' => $request->has('is_default'),
        ]);

        return redirect()->route('admin.languages.index')->with('success', 'Language added successfully!');
    }

    public function update(Request $request, Language $language)
    {
        $request->validate([
            'name' => 'required',
            'direction' => 'required|in:ltr,rtl',
        ]);

        // If this is set as default, unset others
        if ($request->has('is_default')) {
            Language::where('is_default', true)->update(['is_default' => false]);
        }

        $language->update([
            'name' => $request->name,
            'direction' => $request->direction,
            'is_active' => $request->has('is_active'),
            'is_default' => $request->has('is_default'),
        ]);

        return redirect()->route('admin.languages.index')->with('success', 'Language updated successfully!');
    }

    public function destroy(Language $language)
    {
        if ($language->is_default) {
            return redirect()->route('admin.languages.index')->with('error', 'Cannot delete default language!');
        }

        $language->delete();
        return redirect()->route('admin.languages.index')->with('success', 'Language deleted successfully!');
    }
}
