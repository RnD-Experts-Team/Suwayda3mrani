{{-- resources/views/admin/media/edit.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Edit Media')
@section('page-title', 'Edit Media')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.media.update', $media) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="media_url" class="form-label">Media URL *</label>
                        <input type="url" class="form-control @error('media_url') is-invalid @enderror" 
                               name="media_url" value="{{ old('media_url', $media->media_url) }}" required>
                        @error('media_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="type" class="form-label">Type *</label>
                        <select class="form-select @error('type') is-invalid @enderror" name="type" required>
                            <option value="">Select Type</option>
                            <option value="image" {{ old('type', $media->type) == 'image' ? 'selected' : '' }}>Image</option>
                            <option value="video" {{ old('type', $media->type) == 'video' ? 'selected' : '' }}>Video</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', $media->sort_order) }}">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ old('is_active', $media->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>
            </div>

            <!-- Current Media Preview -->
            <div class="mb-4">
                <label class="form-label">Current Media</label>
                <div class="border rounded p-3">
                    @if($media->type === 'video')
                        <video src="{{ $media->media_url }}" class="img-fluid" style="max-height: 200px;" controls></video>
                    @else
                        <img src="{{ $media->media_url }}" alt="{{ $media->title_en }}" class="img-fluid" style="max-height: 200px;">
                    @endif
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
                                <label for="title_{{ $language->code }}" class="form-label">Title ({{ $language->name }})</label>
                                <input type="text" class="form-control" name="title_{{ $language->code }}" 
                                       value="{{ old('title_' . $language->code, $media->{'title_' . $language->code}) }}">
                            </div>
                            <div class="mb-3">
                                <label for="description_{{ $language->code }}" class="form-label">Description ({{ $language->name }})</label>
                                <textarea class="form-control" name="description_{{ $language->code }}" rows="3">{{ old('description_' . $language->code, $media->{'description_' . $language->code}) }}</textarea>
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
@endsection
