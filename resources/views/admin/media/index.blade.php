@extends('admin.layouts.app')

@section('title', 'Media Management')
@section('page-title', 'Media Management')

@section('page-actions')
<a href="{{ route('admin.media.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-2"></i>Add New Media
</a>
@endsection

@section('content')
<!-- Filters -->
<div class="row mb-4">
    <div class="col-md-8">
        <form method="GET" action="{{ route('admin.media.index') }}" class="d-flex">
            <div class="input-group me-3">
                <input type="text" class="form-control" name="search" 
                       value="{{ request('search') }}" placeholder="Search media...">
                <button type="submit" class="btn btn-outline-secondary">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <select name="type" class="form-select me-2" style="max-width: 150px;">
                <option value="">All Types</option>
                <option value="image" {{ request('type') === 'image' ? 'selected' : '' }}>Images</option>
                <option value="video" {{ request('type') === 'video' ? 'selected' : '' }}>Videos</option>
            </select>
            <button type="submit" class="btn btn-outline-primary">Filter</button>
        </form>
    </div>
    <div class="col-md-4 text-end">
        @if(request()->hasAny(['search', 'type']))
            <a href="{{ route('admin.media.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-times me-1"></i>Clear Filters
            </a>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="80">Preview</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>URL/ID</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($media as $item)
                        <tr>
                            <td class="text-center">
                                @if($item->type === 'image')
                                    <img src="{{ $item->media_url }}" 
                                         alt="{{ $item->title_en }}" 
                                         class="img-thumbnail preview-trigger" 
                                         style="max-width: 60px; max-height: 60px; object-fit: cover; cursor: pointer;"
                                         data-title="{{ $item->title_en }}"
                                         data-type="image"
                                         data-url="{{ $item->media_url }}"
                                         onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjYwIiBoZWlnaHQ9IjYwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0yMCAyMEg0MFY0MEgyMFYyMFoiIGZpbGw9IiM5Q0EzQUYiLz4KPC9zdmc+';">
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-dark text-white rounded preview-trigger" 
                                         style="width: 60px; height: 60px; cursor: pointer;"
                                         data-title="{{ $item->title_en }}"
                                         data-type="video"
                                         data-url="{{ $item->media_url }}">
                                        @if(preg_match('/^[a-zA-Z0-9_-]{25,44}$/', $item->media_url) && !str_contains($item->media_url, '/') && !str_contains($item->media_url, '.'))
                                            {{-- It's a Google Drive ID --}}
                                            <i class="fab fa-google-drive fa-lg" title="Google Drive Video"></i>
                                        @else
                                            {{-- It's a regular video URL --}}
                                            <i class="fas fa-video fa-lg" title="Video File"></i>
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $item->title_en }}</strong>
                                @if($item->title_ar)
                                    <br><small class="text-muted">{{ $item->title_ar }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $item->type === 'image' ? 'success' : 'danger' }}">
                                    <i class="fas fa-{{ $item->type === 'image' ? 'image' : 'video' }} me-1"></i>
                                    {{ ucfirst($item->type) }}
                                </span>
                                @if($item->type === 'video' && preg_match('/^[a-zA-Z0-9_-]{25,44}$/', $item->media_url) && !str_contains($item->media_url, '/') && !str_contains($item->media_url, '.'))
                                    <br><small class="badge bg-info mt-1">Google Drive</small>
                                @endif
                            </td>
                            <td>
                                @if($item->type === 'video' && preg_match('/^[a-zA-Z0-9_-]{25,44}$/', $item->media_url) && !str_contains($item->media_url, '/') && !str_contains($item->media_url, '.'))
                                    {{-- It's a Google Drive ID --}}
                                    <div class="d-flex align-items-center">
                                        <code class="text-muted small">{{ Str::limit($item->media_url, 20) }}</code>
                                        <button class="btn btn-outline-secondary btn-xs ms-2" 
                                                onclick="copyToClipboard('{{ $item->media_url }}')" 
                                                title="Copy Google Drive ID">
                                            <i class="fas fa-copy fa-xs"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted d-block">Google Drive ID</small>
                                @else
                                    {{-- It's a regular URL --}}
                                    <a href="{{ $item->media_url }}" target="_blank" class="text-decoration-none">
                                        {{ Str::limit($item->media_url, 40) }}
                                        <i class="fas fa-external-link-alt fa-xs ms-1"></i>
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if($item->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $item->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-outline-info preview-btn" 
                                            data-title="{{ $item->title_en }}"
                                            data-type="{{ $item->type }}"
                                            data-url="{{ $item->media_url }}"
                                            title="Preview">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="{{ route('admin.media.edit', $item) }}" 
                                       class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.media.destroy', $item) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Are you sure you want to delete this media item?')"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-images fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No media items found</p>
                                <a href="{{ route('admin.media.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Add First Media Item
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($media->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $media->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Media Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
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

<!-- Toast Container for Copy Notifications -->
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1060;">
    <div id="copyToast" class="toast" role="alert">
        <div class="toast-header">
            <i class="fas fa-copy text-success me-2"></i>
            <strong class="me-auto">Copied!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
            Google Drive ID copied to clipboard
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Helper function to detect Google Drive ID
    function isGoogleDriveId(url) {
        const driveIdPattern = /^[a-zA-Z0-9_-]{25,44}$/;
        return driveIdPattern.test(url) && !url.includes('/') && !url.includes('.');
    }
    
    // Preview function with Google Drive support
    function showPreview(title, type, url) {
        const modal = new bootstrap.Modal(document.getElementById('previewModal'));
        const modalTitle = document.querySelector('#previewModal .modal-title');
        const previewContent = document.getElementById('previewContent');
        
        modalTitle.textContent = `Preview: ${title}`;
        
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
                            height="600"
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
    }
    
    // Add click handlers for preview triggers
    document.querySelectorAll('.preview-trigger, .preview-btn').forEach(element => {
        element.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const title = this.getAttribute('data-title');
            const type = this.getAttribute('data-type');
            const url = this.getAttribute('data-url');
            
            if (title && type && url) {
                showPreview(title, type, url);
            }
        });
    });
    
    // Copy to clipboard function
    window.copyToClipboard = function(text) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(function() {
                showCopyToast();
            }).catch(function() {
                fallbackCopyText(text);
            });
        } else {
            fallbackCopyText(text);
        }
    };
    
    // Fallback copy method
    function fallbackCopyText(text) {
        const textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.top = "0";
        textArea.style.left = "0";
        textArea.style.position = "fixed";
        
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            document.execCommand('copy');
            showCopyToast();
        } catch (err) {
            console.error('Copy failed:', err);
        }
        
        document.body.removeChild(textArea);
    }
    
    // Show copy toast notification
    function showCopyToast() {
        const toast = new bootstrap.Toast(document.getElementById('copyToast'));
        toast.show();
    }
    
    // Clean up modal content when closed
    const previewModal = document.getElementById('previewModal');
    if (previewModal) {
        previewModal.addEventListener('hidden.bs.modal', function() {
            const previewContent = document.getElementById('previewContent');
            if (previewContent) {
                const iframe = previewContent.querySelector('iframe');
                const video = previewContent.querySelector('video');
                
                if (iframe) {
                    iframe.src = '';
                }
                if (video) {
                    video.pause();
                    video.src = '';
                    video.load();
                }
                
                previewContent.innerHTML = '<div class="d-flex align-items-center justify-content-center h-100"><div class="spinner-border text-brand" role="status"></div></div>';
            }
        });
    }
});
</script>

<style>
.btn-xs {
    padding: 0.25rem 0.4rem;
    font-size: 0.75rem;
    line-height: 1.5;
    border-radius: 0.2rem;
}

.preview-trigger:hover {
    opacity: 0.8;
    transform: scale(1.05);
    transition: all 0.2s ease;
}

.table td {
    vertical-align: middle;
}

.toast-container {
    z-index: 1060;
}

code {
    font-size: 0.8rem;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
}
</style>
@endpush
