{{-- resources/views/admin/media/create.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Add New Media')
@section('page-title', 'Add New Media')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.media.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="media_url" class="form-label">Media URL *</label>
                        <input type="text" class="form-control @error('media_url') is-invalid @enderror" 
                               name="media_url" value="{{ old('media_url') }}" required
                               placeholder="Enter URL or Google Drive ID">
                        <div class="form-text">
                            <strong>For Images:</strong> Enter full image URL (e.g., https://example.com/image.jpg)<br>
                            <strong>For Videos:</strong> Enter either:<br>
                            • Google Drive file ID (e.g., 1hI663i2WqTqKf74TgqmZnOAh75EY-gft)<br>
                            • Full video URL (e.g., https://example.com/video.mp4)
                        </div>
                        @error('media_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="type" class="form-label">Type *</label>
                        <select class="form-select @error('type') is-invalid @enderror" name="type" required id="mediaType">
                            <option value="">Select Type</option>
                            <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>Image</option>
                            <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>Video</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', 0) }}">
                    </div>
                </div>
            </div>

            <!-- Preview Button -->
            <div class="row mb-3">
                <div class="col-12">
                    <button type="button" class="btn btn-outline-info" id="previewBtn" disabled>
                        <i class="fas fa-eye me-2"></i>Preview Media
                    </button>
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
                                <input type="text" class="form-control @error('title_' . $language->code) is-invalid @enderror" 
                                       name="title_{{ $language->code }}" 
                                       value="{{ old('title_' . $language->code) }}" required>
                                @error('title_' . $language->code)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description_{{ $language->code }}" class="form-label">Description ({{ $language->name }})</label>
                                <textarea class="form-control @error('description_' . $language->code) is-invalid @enderror" 
                                          name="description_{{ $language->code }}" rows="3">{{ old('description_' . $language->code) }}</textarea>
                                @error('description_' . $language->code)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Create Media</button>
                <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-white">
            <div class="modal-header border-bottom">
                <h5 class="modal-title text-dark">Media Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center bg-white" id="previewContent">
                <!-- Preview content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mediaUrlInput = document.querySelector('input[name="media_url"]');
    const mediaTypeSelect = document.getElementById('mediaType');
    const previewBtn = document.getElementById('previewBtn');
    
    // Enable/disable preview button
    function updatePreviewButton() {
        const hasUrl = mediaUrlInput.value.trim() !== '';
        const hasType = mediaTypeSelect.value !== '';
        previewBtn.disabled = !(hasUrl && hasType);
    }
    
    mediaUrlInput.addEventListener('input', updatePreviewButton);
    mediaTypeSelect.addEventListener('change', updatePreviewButton);
    
    // Preview functionality
    previewBtn.addEventListener('click', function() {
        const url = mediaUrlInput.value.trim();
        const type = mediaTypeSelect.value;
        
        if (!url || !type) return;
        
        const modal = new bootstrap.Modal(document.getElementById('previewModal'));
        const previewContent = document.getElementById('previewContent');
        
        if (type === 'image') {
            previewContent.innerHTML = `
                <div class="text-center p-3">
                    <img src="${url}" class="img-fluid rounded" style="max-height: 70vh; max-width: 100%;" 
                         onerror="this.onerror=null; this.outerHTML='<div class=\\'alert alert-danger\\'>Failed to load image</div>';">
                </div>
            `;
        } else if (type === 'video') {
            // Check if it's a Google Drive ID
            if (isGoogleDriveId(url)) {
                previewContent.innerHTML = `
                    <div class="text-center p-3">
                        <iframe 
                            src="https://drive.google.com/file/d/${url}/preview"
                            width="100%"
                            height="500"
                            style="border: none; border-radius: 8px;"
                            allow="autoplay">
                        </iframe>
                    </div>
                `;
            } else {
                previewContent.innerHTML = `
                    <div class="text-center p-3">
                        <video controls class="rounded" style="max-height: 70vh; max-width: 100%;" preload="metadata">
                            <source src="${url}" type="video/mp4">
                            <source src="${url}" type="video/webm">
                            <source src="${url}" type="video/ogg">
                            <p class="text-danger">Your browser doesn't support video playback.</p>
                        </video>
                    </div>
                `;
            }
        }
        
        modal.show();
    });
    
    // Helper function to detect Google Drive ID
    function isGoogleDriveId(url) {
        const driveIdPattern = /^[a-zA-Z0-9_-]{25,44}$/;
        return driveIdPattern.test(url) && !url.includes('/') && !url.includes('.');
    }
});
</script>
@endpush
