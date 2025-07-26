<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\Language;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::orderBy('sort_order')->paginate(20);
        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        $languages = Language::getActive();
        return view('admin.partners.create', compact('languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'logo_url' => 'required|url',
            'website_url' => 'nullable|url',
        ]);

        $data = $request->only(['logo_url', 'website_url', 'sort_order']);
        $data['is_active'] = $request->has('is_active');
        
        // Handle multilingual names
        $languages = Language::getActive();
        foreach ($languages as $language) {
            $data["name_{$language->code}"] = $request->input("name_{$language->code}");
        }

        Partner::create($data);

        return redirect()->route('admin.partners.index')->with('success', 'Partner created successfully!');
    }

    public function edit(Partner $partner)
    {
        $languages = Language::getActive();
        return view('admin.partners.edit', compact('partner', 'languages'));
    }

    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'logo_url' => 'required|url',
            'website_url' => 'nullable|url',
        ]);

        $data = $request->only(['logo_url', 'website_url', 'sort_order']);
        $data['is_active'] = $request->has('is_active');
        
        // Handle multilingual names
        $languages = Language::getActive();
        foreach ($languages as $language) {
            $data["name_{$language->code}"] = $request->input("name_{$language->code}");
        }

        $partner->update($data);

        return redirect()->route('admin.partners.index')->with('success', 'Partner updated successfully!');
    }

    public function destroy(Partner $partner)
    {
        $partner->delete();
        return redirect()->route('admin.partners.index')->with('success', 'Partner deleted successfully!');
    }
}
