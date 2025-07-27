{{-- resources/views/admin/media/edit.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Edit Media')
@section('page-title', 'Edit Media')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.media.update', $medium) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Current Media Preview -->
            <div class="row mb-4">
                <div class="col-12">
                    <label class="form-label">Current Media</label>
                    <div class="border rounded p-3 text-center bg-light">
                        @if($medium->type === 'image')
                            <img src="{{ $medium->media_url }}" alt="Current media" class="img-fluid" 
                                 style="max-height: 200px; cursor: pointer;"
                                 onclick="showPreview('{{ $medium->getTitle('en') }}', '{{ $medium->type }}', '{{ $medium->media_url }}')">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-dark text-white rounded" 
                                 style="height: 150px; cursor: pointer;"
                                 onclick="showPreview('{{ $medium->getTitle('en') }}', '{{ $medium->type }}', '{{ $medium->media_url }}')">
                                <i class="fas fa-video fa-3x"></i>
                            </div>
                        @endif
                        <p class="mt-2 mb-0 small text-muted">Click to preview</p>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="media_url" class="form-label">Media URL *</label>
                        <input type="url" class="form-control @error('media_url') is-invalid @enderror" 
                               name="media_url" value="{{ old('media_url', $medium->media_url) }}" required>
                        @error('media_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="type" class="form-label">Media Type *</label>
                        <select class="form-select @error('type') is-invalid @enderror" name="type" required>
                            <option value="">Select Type</option>
                            <option value="image" {{ old('type', $medium->type) == 'image' ? 'selected' : '' }}>Image</option>
                            <option value="video" {{ old('type', $medium->type) == 'video' ? 'selected' : '' }}>Video</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" 
                           {{ old('is_active', $medium->is_active) ? 'checked' : '' }}>
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
                                       value="{{ old('title_' . $language->code, $medium->{'title_' . $language->code}) }}" required>
                                @error('title_' . $language->code)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="description_{{ $language->code }}" class="form-label">Description ({{ $language->name }})</label>
                                <textarea class="form-control @error('description_' . $language->code) is-invalid @enderror" 
                                          name="description_{{ $language->code }}" rows="4">{{ old('description_' . $language->code, $medium->{'description_' . $language->code}) }}</textarea>
                                @error('description_' . $language->code)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Update Media</button>
                <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<!-- Media Preview Modal -->
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

{{-- Alternative robust script for resources/views/admin/media/edit.blade.php --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced preview function with error handling
    window.showPreview = function(title, type, url) {
        try {
            const modal = new bootstrap.Modal(document.getElementById('previewModal'));
            const modalTitle = document.querySelector('#previewModal .modal-title');
            const previewContent = document.getElementById('previewContent');
            
            if (!modalTitle || !previewContent) {
                console.error('Modal elements not found');
                return;
            }
            
            modalTitle.textContent = `Preview: ${title}`;
            
            if (type === 'image') {
                previewContent.innerHTML = `
                    <div class="text-center p-3">
                        <img src="${url}" class="img-fluid rounded" style="max-height: 70vh; max-width: 100%;" 
                             onerror="this.onerror=null; this.outerHTML='<div class=\\'alert alert-danger\\'>Failed to load image</div>';">
                    </div>
                `;
            } else if (type === 'video') {
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
            } else {
                previewContent.innerHTML = `
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Unknown media type: ${type}
                    </div>
                `;
            }
            
            modal.show();
            console.log('Preview shown for:', title, type);
            
        } catch (error) {
            console.error('Error showing preview:', error);
            alert('Error showing preview. Please check the console for details.');
        }
    };

    // Clean up function
    function cleanupModal() {
        const previewContent = document.getElementById('previewContent');
        if (previewContent) {
            const video = previewContent.querySelector('video');
            if (video) {
                video.pause();
                video.src = '';
                video.load();
            }
            previewContent.innerHTML = '';
        }
    }

    // Modal cleanup event
    const previewModal = document.getElementById('previewModal');
    if (previewModal) {
        previewModal.addEventListener('hidden.bs.modal', cleanupModal);
    }

    // Test function - you can call this in console to test
    window.testPreview = function() {
        showPreview('Test Image', 'image', 'https://via.placeholder.com/600x400?text=Test+Image');
    };
});
</script>
@endpush

