<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialIcon;
use Illuminate\Http\Request;

class SocialIconController extends Controller
{
    public function index()
    {
        $socialIcons = SocialIcon::orderBy('sort_order')->paginate(20);
        return view('admin.social-icons.index', compact('socialIcons'));
    }

    public function create()
    {
        return view('admin.social-icons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'icon_class' => 'required',
            'url' => 'required|url',
            'color' => 'required',
        ]);

        SocialIcon::create($request->all());

        return redirect()->route('admin.social-icons.index')->with('success', 'Social icon created successfully!');
    }

    public function edit(SocialIcon $socialIcon)
    {
        return view('admin.social-icons.edit', compact('socialIcon'));
    }

    public function update(Request $request, SocialIcon $socialIcon)
    {
        $request->validate([
            'name' => 'required',
            'icon_class' => 'required',
            'url' => 'required|url',
            'color' => 'required',
        ]);

        $socialIcon->update($request->all());

        return redirect()->route('admin.social-icons.index')->with('success', 'Social icon updated successfully!');
    }

    public function destroy(SocialIcon $socialIcon)
    {
        $socialIcon->delete();
        return redirect()->route('admin.social-icons.index')->with('success', 'Social icon deleted successfully!');
    }
}
