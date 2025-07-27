{{-- resources/views/admin/media/index.blade.php --}}
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
                        <th>URL</th>
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
                                         class="img-thumbnail" 
                                         style="max-width: 60px; max-height: 60px; object-fit: cover;"
                                         onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjYwIiBoZWlnaHQ9IjYwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0yMCAyMEg0MFY0MEgyMFYyMFoiIGZpbGw9IiM5Q0EzQUYiLz4KPC9zdmc+';">
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-dark text-white rounded" style="width: 60px; height: 60px;">
                                        <i class="fas fa-video fa-lg"></i>
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
                            </td>
                            <td>
                                <a href="{{ $item->media_url }}" target="_blank" class="text-decoration-none">
                                    {{ Str::limit($item->media_url, 40) }}
                                    <i class="fas fa-external-link-alt fa-xs ms-1"></i>
                                </a>
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
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Media Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center" id="previewContent">
                <!-- Preview content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add click handler for media previews
    document.querySelectorAll('img, .bg-dark').forEach(element => {
        if (element.closest('td')) {
            element.style.cursor = 'pointer';
            element.addEventListener('click', function() {
                const row = this.closest('tr');
                const titleCell = row.querySelector('td:nth-child(2) strong');
                const typeCell = row.querySelector('td:nth-child(3) .badge');
                const urlCell = row.querySelector('td:nth-child(4) a');
                
                if (titleCell && typeCell && urlCell) {
                    const title = titleCell.textContent;
                    const type = typeCell.textContent.toLowerCase().includes('image') ? 'image' : 'video';
                    const url = urlCell.href;
                    
                    showPreview(title, type, url);
                }
            });
        }
    });
    
    function showPreview(title, type, url) {
        const modal = new bootstrap.Modal(document.getElementById('previewModal'));
        const modalTitle = document.querySelector('#previewModal .modal-title');
        const previewContent = document.getElementById('previewContent');
        
        modalTitle.textContent = `Preview: ${title}`;
        
        if (type === 'image') {
            previewContent.innerHTML = `
                <img src="${url}" class="img-fluid" style="max-height: 70vh;" 
                     onerror="this.onerror=null; this.outerHTML='<div class=\\'text-danger\\'>Failed to load image</div>';">
            `;
        } else {
            previewContent.innerHTML = `
                <video controls class="w-100" style="max-height: 70vh;" preload="metadata">
                    <source src="${url}" type="video/mp4">
                    <source src="${url}" type="video/webm">
                    <p class="text-danger">Your browser doesn't support video playback.</p>
                </video>
            `;
        }
        
        modal.show();
    }
});
</script>
@endpush
