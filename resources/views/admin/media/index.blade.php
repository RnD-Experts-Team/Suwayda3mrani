{{-- resources/views/admin/media/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Media Gallery')
@section('page-title', 'Media Gallery')

@section('page-actions')
<a href="{{ route('admin.media.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-2"></i>Add New Media
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            @forelse($mediaItems as $media)
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="position-relative">
                            @if($media->type === 'video')
                                <video src="{{ $media->media_url }}" class="card-img-top" style="height: 200px; object-fit: cover;" muted></video>
                                <div class="position-absolute top-50 start-50 translate-middle">
                                    <i class="fas fa-play text-white fa-2x"></i>
                                </div>
                            @else
                                <img src="{{ $media->media_url }}" alt="{{ $media->title_en }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                            @endif
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-{{ $media->type === 'video' ? 'danger' : 'success' }}">
                                    {{ ucfirst($media->type) }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title">{{ $media->title_en }}</h6>
                            <p class="card-text small text-muted">{{ Str::limit($media->description_en, 50) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    @if($media->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </small>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.media.edit', $media) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.media.destroy', $media) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">No media items found</p>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center">
            {{ $mediaItems->links() }}
        </div>
    </div>
</div>
@endsection
