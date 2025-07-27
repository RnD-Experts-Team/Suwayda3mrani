{{-- resources/views/admin/counters/create.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Add New Counter')
@section('page-title', 'Add New Counter')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.counters.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="count" class="form-label">Count *</label>
                        <input type="number" class="form-control @error('count') is-invalid @enderror" 
                               name="count" value="{{ old('count', 0) }}" min="0" required>
                        @error('count')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="type" class="form-label">Display Type *</label>
                        <select class="form-select @error('type') is-invalid @enderror" name="type" id="counterType" required>
                            <option value="">Choose Type</option>
                            <option value="icon" {{ old('type') == 'icon' ? 'selected' : '' }}>FontAwesome Icon</option>
                            <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>Custom Image</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', 0) }}">
                    </div>
                </div>
            </div>

            <!-- Icon Option -->
            <div id="iconOption" class="icon-image-option" style="display: none;">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="icon" class="form-label">FontAwesome Icon Class</label>
                            <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                                   name="icon" value="{{ old('icon') }}" 
                                   placeholder="fas fa-users">
                            <small class="form-text text-muted">Example: fas fa-users, fas fa-heart, fas fa-star</small>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Icon Preview</label>
                            <div class="border rounded p-3 text-center bg-light">
                                <i id="iconPreview" class="fas fa-users fa-3x text-primary"></i>
                                <p class="mt-2 mb-0 small">Preview will appear here</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image Option -->
            <div id="imageOption" class="icon-image-option" style="display: none;">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="image_url" class="form-label">Image URL</label>
                            <input type="url" class="form-control @error('image_url') is-invalid @enderror" 
                                   name="image_url" value="{{ old('image_url') }}" 
                                   placeholder="https://example.com/counter-icon.png">
                            <small class="form-text text-muted">Recommended: 100x100px PNG with transparent background</small>
                            @error('image_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Image Preview</label>
                            <div class="border rounded p-3 text-center bg-light">
                                <img id="imagePreview" src="" alt="Preview" class="img-fluid" 
                                     style="max-width: 80px; max-height: 80px; display: none;">
                                <p id="imagePreviewText" class="mt-2 mb-0 small">Preview will appear here</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Active</label>
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
                        <div class="p-3">
                            <div class="mb-3">
                                <label for="title_{{ $language->code }}" class="form-label">Title ({{ $language->name }}) *</label>
                                <input type="text" class="form-control" name="title_{{ $language->code }}" 
                                       value="{{ old('title_' . $language->code) }}" required>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Create Counter</button>
                <a href="{{ route('admin.counters.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const counterType = document.getElementById('counterType');
    const iconOption = document.getElementById('iconOption');
    const imageOption = document.getElementById('imageOption');
    const iconInput = document.querySelector('input[name="icon"]');
    const imageInput = document.querySelector('input[name="image_url"]');
    const iconPreview = document.getElementById('iconPreview');
    const imagePreview = document.getElementById('imagePreview');
    const imagePreviewText = document.getElementById('imagePreviewText');
    
    // Handle type selection
    counterType.addEventListener('change', function() {
        const selectedType = this.value;
        
        // Hide all options first
        document.querySelectorAll('.icon-image-option').forEach(option => {
            option.style.display = 'none';
        });
        
        // Clear previous requirements
        iconInput.removeAttribute('required');
        imageInput.removeAttribute('required');
        
        // Show selected option
        if (selectedType === 'icon') {
            iconOption.style.display = 'block';
            iconInput.setAttribute('required', 'required');
        } else if (selectedType === 'image') {
            imageOption.style.display = 'block';
            imageInput.setAttribute('required', 'required');
        }
    });
    
    // Icon preview
    iconInput.addEventListener('input', function() {
        const iconClass = this.value || 'fas fa-users';
        iconPreview.className = iconClass + ' fa-3x text-primary';
    });
    
    // Image preview
    imageInput.addEventListener('input', function() {
        const imageUrl = this.value;
        
        if (imageUrl) {
            // Test if image loads
            const testImg = new Image();
            testImg.onload = function() {
                imagePreview.src = imageUrl;
                imagePreview.style.display = 'block';
                imagePreviewText.style.display = 'none';
            };
            testImg.onerror = function() {
                imagePreview.style.display = 'none';
                imagePreviewText.style.display = 'block';
                imagePreviewText.textContent = 'Invalid image URL';
                imagePreviewText.className = 'mt-2 mb-0 small text-danger';
            };
            testImg.src = imageUrl;
        } else {
            imagePreview.style.display = 'none';
            imagePreviewText.style.display = 'block';
            imagePreviewText.textContent = 'Preview will appear here';
            imagePreviewText.className = 'mt-2 mb-0 small';
        }
    });
    
    // Initialize based on old value
    if (counterType.value) {
        counterType.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush
@endsection
