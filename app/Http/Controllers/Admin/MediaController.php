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
            'media_url' => 'required|string',
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
        ]);

        // Custom validation for media URL based on type
        $validator->after(function ($validator) use ($request) {
            if ($request->type && $request->media_url) {
                $url = $request->media_url;
                
                if ($request->type === 'image') {
                    // For images, must be a valid URL with image extension
                    if (!filter_var($url, FILTER_VALIDATE_URL)) {
                        $validator->errors()->add('media_url', 'Image must be a valid URL');
                        return;
                    }
                    
                    $parsedUrl = parse_url($url);
                    if (isset($parsedUrl['path'])) {
                        $extension = strtolower(pathinfo($parsedUrl['path'], PATHINFO_EXTENSION));
                        $validImageExts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
                        if (!in_array($extension, $validImageExts)) {
                            $validator->errors()->add('media_url', 'Image URL must have a valid image extension (.jpg, .png, .gif, .webp, .svg)');
                        }
                    }
                    
                } elseif ($request->type === 'video') {
                    // For videos, can be either Google Drive ID or video URL
                    if ($this->isGoogleDriveId($url)) {
                        // It's a Google Drive ID - valid
                        return;
                    } elseif (filter_var($url, FILTER_VALIDATE_URL)) {
                        // It's a URL - check for video extension
                        $parsedUrl = parse_url($url);
                        if (isset($parsedUrl['path'])) {
                            $extension = strtolower(pathinfo($parsedUrl['path'], PATHINFO_EXTENSION));
                            $validVideoExts = ['mp4', 'webm', 'ogg', 'avi', 'mov'];
                            if (!in_array($extension, $validVideoExts)) {
                                $validator->errors()->add('media_url', 'Video must be either a Google Drive file ID or a valid video URL (.mp4, .webm, .ogg, .avi, .mov)');
                            }
                        }
                    } else {
                        $validator->errors()->add('media_url', 'Video must be either a Google Drive file ID (25-44 characters) or a valid video URL');
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
            'sort_order' => $request->sort_order ?? 0,
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
            'media_url' => 'required|string',
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
        ]);

        // Custom validation for media URL based on type (same as store method)
        $validator->after(function ($validator) use ($request) {
            if ($request->type && $request->media_url) {
                $url = $request->media_url;
                
                if ($request->type === 'image') {
                    // For images, must be a valid URL with image extension
                    if (!filter_var($url, FILTER_VALIDATE_URL)) {
                        $validator->errors()->add('media_url', 'Image must be a valid URL');
                        return;
                    }
                    
                    $parsedUrl = parse_url($url);
                    if (isset($parsedUrl['path'])) {
                        $extension = strtolower(pathinfo($parsedUrl['path'], PATHINFO_EXTENSION));
                        $validImageExts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
                        if (!in_array($extension, $validImageExts)) {
                            $validator->errors()->add('media_url', 'Image URL must have a valid image extension');
                        }
                    }
                    
                } elseif ($request->type === 'video') {
                    // For videos, can be either Google Drive ID or video URL
                    if ($this->isGoogleDriveId($url)) {
                        // It's a Google Drive ID - valid
                        return;
                    } elseif (filter_var($url, FILTER_VALIDATE_URL)) {
                        // It's a URL - check for video extension
                        $parsedUrl = parse_url($url);
                        if (isset($parsedUrl['path'])) {
                            $extension = strtolower(pathinfo($parsedUrl['path'], PATHINFO_EXTENSION));
                            $validVideoExts = ['mp4', 'webm', 'ogg', 'avi', 'mov'];
                            if (!in_array($extension, $validVideoExts)) {
                                $validator->errors()->add('media_url', 'Video must be either a Google Drive file ID or a valid video URL');
                            }
                        }
                    } else {
                        $validator->errors()->add('media_url', 'Video must be either a Google Drive file ID or a valid video URL');
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
            'sort_order' => $request->sort_order ?? $medium->sort_order,
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

    /**
     * Check if a string is a Google Drive file ID
     */
    private function isGoogleDriveId($string)
    {
        // Google Drive IDs are typically 25-44 characters long and contain only alphanumeric, dashes, and underscores
        return preg_match('/^[a-zA-Z0-9_-]{25,44}$/', $string) && !str_contains($string, '/') && !str_contains($string, '.');
    }

    /**
     * Preview video for admin
     */
    public function previewVideo(Request $request)
    {
        $request->validate([
            'media_url' => 'required|string'
        ]);

        $url = $request->media_url;
        
        if ($this->isGoogleDriveId($url)) {
            return response()->json([
                'success' => true,
                'type' => 'google_drive',
                'embed_url' => "https://drive.google.com/file/d/{$url}/preview"
            ]);
        } else {
            return response()->json([
                'success' => true,
                'type' => 'direct_url',
                'video_url' => $url
            ]);
        }
    }
}
