{{-- resources/views/admin/contents/create.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Add New Content')
@section('page-title', 'Add New Content')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.contents.store') }}" method="POST" id="contentForm">
            @csrf
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="key" class="form-label">Content Key *</label>
                        <select class="form-select @error('key') is-invalid @enderror" name="key" id="contentKey" required>
                            <option value="">Select Content Type</option>
                            <option value="hero" {{ old('key') == 'hero' ? 'selected' : '' }}>Hero Section</option>
                            <option value="take_action" {{ old('key') == 'take_action' ? 'selected' : '' }}>Take Action Section</option>
                            <option value="about_us" {{ old('key') == 'about_us' ? 'selected' : '' }}>About Us</option>
                            <option value="our_vision" {{ old('key') == 'our_vision' ? 'selected' : '' }}>Our Vision</option>
                            <option value="contact_us" {{ old('key') == 'contact_us' ? 'selected' : '' }}>Contact Us</option>
                            <option value="page_headers" {{ old('key') == 'page_headers' ? 'selected' : '' }}>Page Headers</option>
                            <option value="custom" {{ old('key') == 'custom' ? 'selected' : '' }}>Custom Content</option>
                        </select>
                        <small class="form-text text-muted">Choose a predefined content type or select "Custom Content" to enter your own key</small>
                        @error('key')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Custom Key Input (hidden by default) -->
                    <div class="mb-3" id="customKeyInput" style="display: none;">
                        <label for="custom_key" class="form-label">Custom Content Key *</label>
                        <input type="text" class="form-control" id="customKey" name="custom_key" 
                               value="{{ old('custom_key') }}" 
                               placeholder="e.g., hero, about_us, contact_us">
                        <small class="form-text text-muted">Use underscore for spaces (e.g., about_us, contact_us)</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Language Tabs -->
            <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                @foreach($languages as $index => $language)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $index === 0 ? 'active' : '' }}" id="{{ $language->code }}-tab" 
                                data-bs-toggle="tab" data-bs-target="#{{ $language->code }}" type="button" role="tab">
                            {{ $language->name }}
                        </button>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content" id="languageTabsContent">
                @foreach($languages as $index => $language)
                    <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="{{ $language->code }}" role="tabpanel">
                        <!-- Content will be dynamically loaded based on selected content type -->
                        <div class="content-form-container p-3" data-language="{{ $language->code }}">
                            
                            <!-- Default/Generic Form (shown by default) -->
                            <div class="content-form" data-type="default">
                                <div class="mb-3">
                                    <label for="title_{{ $language->code }}" class="form-label">Title ({{ $language->name }})</label>
                                    <input type="text" class="form-control" name="content_{{ $language->code }}[title]" 
                                           value="{{ old('content_' . $language->code . '.title') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="content_{{ $language->code }}" class="form-label">Content ({{ $language->name }})</label>
                                    <textarea class="form-control summernote" name="content_{{ $language->code }}[content]" rows="10">{{ old('content_' . $language->code . '.content') }}</textarea>
                                </div>
                            </div>

                            <!-- Hero Section Form -->
                            <div class="content-form" data-type="hero" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="hero_title_{{ $language->code }}" class="form-label">Hero Title ({{ $language->name }}) *</label>
                                            <input type="text" class="form-control" name="content_{{ $language->code }}[title]" 
                                                   value="{{ old('content_' . $language->code . '.title') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="hero_subtitle_{{ $language->code }}" class="form-label">Hero Subtitle ({{ $language->name }})</label>
                                            <input type="text" class="form-control" name="content_{{ $language->code }}[subtitle]" 
                                                   value="{{ old('content_' . $language->code . '.subtitle') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="hero_bg_{{ $language->code }}" class="form-label">Background Image URL</label>
                                    <input type="url" class="form-control" name="content_{{ $language->code }}[background_image]" 
                                           value="{{ old('content_' . $language->code . '.background_image') }}"
                                           placeholder="https://example.com/hero-background.jpg">
                                </div>
                            </div>

                            <!-- Take Action Section Form -->
                            <div class="content-form" data-type="take_action" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="action_title_{{ $language->code }}" class="form-label">Title ({{ $language->name }}) *</label>
                                            <input type="text" class="form-control" name="content_{{ $language->code }}[title]" 
                                                   value="{{ old('content_' . $language->code . '.title') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="action_subtitle_{{ $language->code }}" class="form-label">Subtitle ({{ $language->name }})</label>
                                            <input type="text" class="form-control" name="content_{{ $language->code }}[subtitle]" 
                                                   value="{{ old('content_' . $language->code . '.subtitle') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="action_image_{{ $language->code }}" class="form-label">Image URL</label>
                                            <input type="url" class="form-control" name="content_{{ $language->code }}[image]" 
                                                   value="{{ old('content_' . $language->code . '.image') }}"
                                                   placeholder="https://example.com/action-image.jpg">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="action_button_url_{{ $language->code }}" class="form-label">Button URL</label>
                                            <input type="url" class="form-control" name="content_{{ $language->code }}[button_url]" 
                                                   value="{{ old('content_' . $language->code . '.button_url') }}"
                                                   placeholder="https://example.com/action-page">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="action_button_text_{{ $language->code }}" class="form-label">Button Text ({{ $language->name }})</label>
                                    <input type="text" class="form-control" name="content_{{ $language->code }}[button_text]" 
                                           value="{{ old('content_' . $language->code . '.button_text') }}"
                                           placeholder="Learn More">
                                </div>
                            </div>

                            <!-- About Us / Our Vision Form -->
                            <div class="content-form" data-type="about_us our_vision" style="display: none;">
                                <div class="mb-3">
                                    <label for="section_title_{{ $language->code }}" class="form-label">Title ({{ $language->name }}) *</label>
                                    <input type="text" class="form-control" name="content_{{ $language->code }}[title]" 
                                           value="{{ old('content_' . $language->code . '.title') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="section_content_{{ $language->code }}" class="form-label">Content ({{ $language->name }}) *</label>
                                    <textarea class="form-control summernote" name="content_{{ $language->code }}[content]" rows="10" required>{{ old('content_' . $language->code . '.content') }}</textarea>
                                </div>
                            </div>

                            <!-- Contact Us Form -->
                            <div class="content-form" data-type="contact_us" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="contact_title_{{ $language->code }}" class="form-label">Title ({{ $language->name }}) *</label>
                                            <input type="text" class="form-control" name="content_{{ $language->code }}[title]" 
                                                   value="{{ old('content_' . $language->code . '.title') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="contact_phone_{{ $language->code }}" class="form-label">Phone</label>
                                            <input type="text" class="form-control" name="content_{{ $language->code }}[phone]" 
                                                   value="{{ old('content_' . $language->code . '.phone') }}"
                                                   placeholder="+1234567890">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="contact_whatsapp_{{ $language->code }}" class="form-label">WhatsApp</label>
                                            <input type="text" class="form-control" name="content_{{ $language->code }}[whatsapp]" 
                                                   value="{{ old('content_' . $language->code . '.whatsapp') }}"
                                                   placeholder="+1234567890">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="contact_email_{{ $language->code }}" class="form-label">Email</label>
                                            <input type="email" class="form-control" name="content_{{ $language->code }}[email]" 
                                                   value="{{ old('content_' . $language->code . '.email') }}"
                                                   placeholder="info@example.com">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="contact_address_{{ $language->code }}" class="form-label">Address ({{ $language->name }})</label>
                                    <textarea class="form-control" name="content_{{ $language->code }}[address]" rows="3">{{ old('content_' . $language->code . '.address') }}</textarea>
                                </div>
                            </div>

                            <!-- Page Headers Form -->
                            <div class="content-form" data-type="page_headers" style="display: none;">
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="mb-4">Page Header Backgrounds ({{ $language->name }})</h5>
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
                                                   value="{{ old('content_' . $language->code . '.media_gallery.background_image') }}"
                                                   placeholder="https://example.com/media-gallery-bg.jpg">
                                            <small class="form-text text-muted">Leave empty to use default gradient background</small>
                                        </div>
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
                                                   value="{{ old('content_' . $language->code . '.about_us.background_image') }}"
                                                   placeholder="https://example.com/about-us-bg.jpg">
                                            <small class="form-text text-muted">Leave empty to use default gradient background</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Create Content</button>
                <a href="{{ route('admin.contents.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const contentKeySelect = document.getElementById('contentKey');
    const customKeyInput = document.getElementById('customKeyInput');
    const customKeyField = document.getElementById('customKey');
    const contentForms = document.querySelectorAll('.content-form');
    
    function showContentForm(contentType) {
        // Hide all forms first
        contentForms.forEach(form => {
            form.style.display = 'none';
        });
        
        // Show the appropriate form based on content type
        contentForms.forEach(form => {
            const formTypes = form.dataset.type.split(' ');
            if (formTypes.includes(contentType) || (contentType === 'custom' && formTypes.includes('default'))) {
                form.style.display = 'block';
            }
        });
    }
    
    function toggleCustomKeyInput() {
        const selectedValue = contentKeySelect.value;
        
        if (selectedValue === 'custom') {
            customKeyInput.style.display = 'block';
            customKeyField.required = true;
            // Update the form action to use custom key
            contentKeySelect.name = '';
            customKeyField.name = 'key';
        } else {
            customKeyInput.style.display = 'none';
            customKeyField.required = false;
            // Reset to use select value
            contentKeySelect.name = 'key';
            customKeyField.name = 'custom_key';
        }
        
        // Show appropriate content form
        if (selectedValue && selectedValue !== 'custom') {
            showContentForm(selectedValue);
        } else if (selectedValue === 'custom') {
            showContentForm('default');
        }
    }
    
    // Initialize on page load
    toggleCustomKeyInput();
    
    // Handle content type selection change
    contentKeySelect.addEventListener('change', toggleCustomKeyInput);
    
    // Auto-fill some default values based on content type
    contentKeySelect.addEventListener('change', function() {
        const selectedValue = this.value;
        
        // Auto-fill some default values for specific content types
        if (selectedValue === 'hero') {
            // Set default hero values if needed
            document.querySelectorAll('input[name*="[title]"]').forEach(input => {
                if (input.value === '') {
                    const lang = input.name.includes('content_en') ? 'en' : 'ar';
                    input.value = lang === 'en' ? 'Welcome to Our Website' : 'مرحباً بكم في موقعنا';
                }
            });
        } else if (selectedValue === 'contact_us') {
            // Set default contact title
            document.querySelectorAll('input[name*="[title]"]').forEach(input => {
                if (input.value === '') {
                    const lang = input.name.includes('content_en') ? 'en' : 'ar';
                    input.value = lang === 'en' ? 'Contact Us' : 'تواصل معنا';
                }
            });
        }
    });
    
    // Initialize Summernote on visible textareas
    function initializeSummernote() {
        $('.summernote').summernote('destroy'); // Destroy existing instances
        $('.content-form:visible .summernote').summernote({
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    }
    
    // Re-initialize Summernote when content type changes
    contentKeySelect.addEventListener('change', function() {
        setTimeout(initializeSummernote, 100);
    });
    
    // Initialize Summernote on page load
    setTimeout(initializeSummernote, 100);
});
</script>
@endpush
@endsection
