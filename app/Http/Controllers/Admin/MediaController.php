<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaItem;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = MediaItem::query();
        
        // Filter by type if requested
        if ($request->has('type') && in_array($request->type, ['image', 'video'])) {
            $query->where('type', $request->type);
        }
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title_en', 'like', "%{$search}%")
                  ->orWhere('title_ar', 'like', "%{$search}%")
                  ->orWhere('description_en', 'like', "%{$search}%")
                  ->orWhere('description_ar', 'like', "%{$search}%");
            });
        }
        
        $media = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.media.index', compact('media'));
    }

    public function create()
    {
        $languages = Language::getActive();
        return view('admin.media.create', compact('languages'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:image,video',
            'media_url' => 'required|url',
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
        ]);

        // Custom validation for media URL based on type
        $validator->after(function ($validator) use ($request) {
            if ($request->type && $request->media_url) {
                $url = $request->media_url;
                $parsedUrl = parse_url($url);
                
                if (isset($parsedUrl['path'])) {
                    $extension = strtolower(pathinfo($parsedUrl['path'], PATHINFO_EXTENSION));
                    
                    if ($request->type === 'image') {
                        $validImageExts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
                        if (!in_array($extension, $validImageExts)) {
                            $validator->errors()->add('media_url', 'Image URL must have a valid image extension (.jpg, .png, .gif, .webp, .svg)');
                        }
                    } elseif ($request->type === 'video') {
                        $validVideoExts = ['mp4', 'webm', 'ogg', 'avi', 'mov'];
                        if (!in_array($extension, $validVideoExts)) {
                            $validator->errors()->add('media_url', 'Video URL must have a valid video extension (.mp4, .webm, .ogg, .avi, .mov)');
                        }
                    }
                }
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        MediaItem::create([
            'type' => $request->type,
            'media_url' => $request->media_url,
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.media.index')
            ->with('success', 'Media item created successfully!');
    }

    public function show(MediaItem $medium)
    {
        return view('admin.media.show', compact('medium'));
    }

    public function edit(MediaItem $medium)
    {
        $languages = Language::getActive();
        return view('admin.media.edit', compact('medium', 'languages'));
    }

    public function update(Request $request, MediaItem $medium)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:image,video',
            'media_url' => 'required|url',
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
        ]);

        // Custom validation for media URL based on type
        $validator->after(function ($validator) use ($request) {
            if ($request->type && $request->media_url) {
                $url = $request->media_url;
                $parsedUrl = parse_url($url);
                
                if (isset($parsedUrl['path'])) {
                    $extension = strtolower(pathinfo($parsedUrl['path'], PATHINFO_EXTENSION));
                    
                    if ($request->type === 'image') {
                        $validImageExts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
                        if (!in_array($extension, $validImageExts)) {
                            $validator->errors()->add('media_url', 'Image URL must have a valid image extension');
                        }
                    } elseif ($request->type === 'video') {
                        $validVideoExts = ['mp4', 'webm', 'ogg', 'avi', 'mov'];
                        if (!in_array($extension, $validVideoExts)) {
                            $validator->errors()->add('media_url', 'Video URL must have a valid video extension');
                        }
                    }
                }
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $medium->update([
            'type' => $request->type,
            'media_url' => $request->media_url,
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.media.index')
            ->with('success', 'Media item updated successfully!');
    }

    public function destroy(MediaItem $medium)
    {
        $medium->delete();
        
        return redirect()->route('admin.media.index')
            ->with('success', 'Media item deleted successfully!');
    }
}
