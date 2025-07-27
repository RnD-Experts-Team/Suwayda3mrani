{{-- resources/views/admin/contents/edit.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Edit Content')
@section('page-title', 'Edit Content: ' . $content->key)

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.contents.update', $content) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-12">
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ $content->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
            </div>

            <!-- Language Tabs -->
            <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                @foreach($languages as $index => $language)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $index === 0 ? 'active' : '' }}" id="{{ $language->code }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $language->code }}" type="button" role="tab">
                            {{ $language->name }}
                        </button>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content" id="languageTabsContent">
                @foreach($languages as $index => $language)
                    <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="{{ $language->code }}" role="tabpanel">
                        <div class="p-3">
                            @if(in_array($content->key, ['hero', 'take_action']))
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="title_{{ $language->code }}" class="form-label">Title</label>
                                            <input type="text" class="form-control" name="content_{{ $language->code }}[title]" 
                                                   value="{{ $content->{'content_' . $language->code}['title'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="subtitle_{{ $language->code }}" class="form-label">Subtitle</label>
                                            <input type="text" class="form-control" name="content_{{ $language->code }}[subtitle]" 
                                                   value="{{ $content->{'content_' . $language->code}['subtitle'] ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                
                                @if($content->key === 'hero')
                                    <div class="mb-3">
                                        <label for="background_image_{{ $language->code }}" class="form-label">Background Image URL</label>
                                        <input type="url" class="form-control" name="content_{{ $language->code }}[background_image]" 
                                               value="{{ $content->{'content_' . $language->code}['background_image'] ?? '' }}">
                                    </div>
                                @endif
                                
                                @if($content->key === 'take_action')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="image_{{ $language->code }}" class="form-label">Image URL</label>
                                                <input type="url" class="form-control" name="content_{{ $language->code }}[image]" 
                                                       value="{{ $content->{'content_' . $language->code}['image'] ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="button_url_{{ $language->code }}" class="form-label">Button URL</label>
                                                <input type="url" class="form-control" name="content_{{ $language->code }}[button_url]" 
                                                       value="{{ $content->{'content_' . $language->code}['button_url'] ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="button_text_{{ $language->code }}" class="form-label">Button Text</label>
                                        <input type="text" class="form-control" name="content_{{ $language->code }}[button_text]" 
                                               value="{{ $content->{'content_' . $language->code}['button_text'] ?? '' }}">
                                    </div>
                                @endif
                                
                            @elseif($content->key === 'page_headers')
                                {{-- Page Headers Form --}}
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="mb-4">Page Header Backgrounds</h5>
                                    </div>
                                </div>
                                
                                {{-- Media Gallery Header --}}
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">Media Gallery Page Header</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="media_gallery_bg_{{ $language->code }}" class="form-label">Background Image URL</label>
                                            <input type="url" class="form-control" 
                                                   name="content_{{ $language->code }}[media_gallery][background_image]" 
                                                   value="{{ $content->{'content_' . $language->code}['media_gallery']['background_image'] ?? '' }}"
                                                   placeholder="https://example.com/image.jpg">
                                            <small class="form-text text-muted">Leave empty to use default gradient background</small>
                                        </div>
                                        
                                        @if(isset($content->{'content_' . $language->code}['media_gallery']['background_image']) && !empty($content->{'content_' . $language->code}['media_gallery']['background_image']))
                                            <div class="mb-3">
                                                <label class="form-label">Current Background</label>
                                                <div class="border rounded p-2">
                                                    <img src="{{ $content->{'content_' . $language->code}['media_gallery']['background_image'] }}" 
                                                         alt="Media Gallery Background" class="img-fluid" style="max-height: 150px;">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                {{-- About Us Header --}}
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">About Us Page Header</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="about_us_bg_{{ $language->code }}" class="form-label">Background Image URL</label>
                                            <input type="url" class="form-control" 
                                                   name="content_{{ $language->code }}[about_us][background_image]" 
                                                   value="{{ $content->{'content_' . $language->code}['about_us']['background_image'] ?? '' }}"
                                                   placeholder="https://example.com/image.jpg">
                                            <small class="form-text text-muted">Leave empty to use default gradient background</small>
                                        </div>
                                        
                                        @if(isset($content->{'content_' . $language->code}['about_us']['background_image']) && !empty($content->{'content_' . $language->code}['about_us']['background_image']))
                                            <div class="mb-3">
                                                <label class="form-label">Current Background</label>
                                                <div class="border rounded p-2">
                                                    <img src="{{ $content->{'content_' . $language->code}['about_us']['background_image'] }}" 
                                                         alt="About Us Background" class="img-fluid" style="max-height: 150px;">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                            @elseif(in_array($content->key, ['about_us', 'our_vision']))
                                <div class="mb-3">
                                    <label for="title_{{ $language->code }}" class="form-label">Title</label>
                                    <input type="text" class="form-control" name="content_{{ $language->code }}[title]" 
                                           value="{{ $content->{'content_' . $language->code}['title'] ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="content_{{ $language->code }}" class="form-label">Content</label>
                                    <textarea class="form-control summernote" name="content_{{ $language->code }}[content]" rows="10">{{ $content->{'content_' . $language->code}['content'] ?? '' }}</textarea>
                                </div>
                                
                            @elseif($content->key === 'contact_us')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="title_{{ $language->code }}" class="form-label">Title</label>
                                            <input type="text" class="form-control" name="content_{{ $language->code }}[title]" 
                                                   value="{{ $content->{'content_' . $language->code}['title'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone_{{ $language->code }}" class="form-label">Phone</label>
                                            <input type="text" class="form-control" name="content_{{ $language->code }}[phone]" 
                                                   value="{{ $content->{'content_' . $language->code}['phone'] ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="whatsapp_{{ $language->code }}" class="form-label">WhatsApp</label>
                                            <input type="text" class="form-control" name="content_{{ $language->code }}[whatsapp]" 
                                                   value="{{ $content->{'content_' . $language->code}['whatsapp'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email_{{ $language->code }}" class="form-label">Email</label>
                                            <input type="email" class="form-control" name="content_{{ $language->code }}[email]" 
                                                   value="{{ $content->{'content_' . $language->code}['email'] ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="address_{{ $language->code }}" class="form-label">Address</label>
                                    <textarea class="form-control" name="content_{{ $language->code }}[address]" rows="3">{{ $content->{'content_' . $language->code}['address'] ?? '' }}</textarea>
                                </div>
                                
                            {{-- Add this case in resources/views/admin/contents/edit.blade.php --}}
@elseif($content->key === 'site_logo')
    <div class="mb-3">
        <label for="logo_url_{{ $language->code }}" class="form-label">Logo URL</label>
        <input type="url" class="form-control" name="content_{{ $language->code }}[logo_url]" 
               value="{{ $content->{'content_' . $language->code}['logo_url'] ?? '' }}"
               placeholder="https://example.com/logo.png">
    </div>
    
    <div class="mb-3">
        <label for="alt_text_{{ $language->code }}" class="form-label">Alt Text ({{ $language->name }})</label>
        <input type="text" class="form-control" name="content_{{ $language->code }}[alt_text]" 
               value="{{ $content->{'content_' . $language->code}['alt_text'] ?? '' }}"
               placeholder="Site Logo">
    </div>
    
    @if(isset($content->{'content_' . $language->code}['logo_url']) && !empty($content->{'content_' . $language->code}['logo_url']))
        <div class="mb-3">
            <label class="form-label">Current Logo</label>
            <div class="border rounded p-3 text-center">
                <img src="{{ $content->{'content_' . $language->code}['logo_url'] }}" 
                     alt="{{ $content->{'content_' . $language->code}['alt_text'] ?? 'Logo' }}" 
                     class="img-fluid" style="max-height: 100px;">
            </div>
        </div>
    @endif
    
                            @else
                                {{-- Generic form for other content types --}}
                                <div class="mb-3">
                                    <label for="title_{{ $language->code }}" class="form-label">Title</label>
                                    <input type="text" class="form-control" name="content_{{ $language->code }}[title]" 
                                           value="{{ $content->{'content_' . $language->code}['title'] ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="content_{{ $language->code }}" class="form-label">Content</label>
                                    <textarea class="form-control summernote" name="content_{{ $language->code }}[content]" rows="10">{{ $content->{'content_' . $language->code}['content'] ?? '' }}</textarea>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Update Content</button>
                <a href="{{ route('admin.contents.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

