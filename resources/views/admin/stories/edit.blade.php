{{-- resources/views/admin/stories/edit.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Edit Story')
@section('page-title', 'Edit Story')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.stories.update', $story) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="image_url" class="form-label">Image URL *</label>
                        <input type="url" class="form-control @error('image_url') is-invalid @enderror" 
                               name="image_url" value="{{ old('image_url', $story->image_url) }}" required>
                        @error('image_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ old('is_active', $story->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Image Preview -->
            <div class="mb-4">
                <label class="form-label">Current Image</label>
                <div class="border rounded p-3">
                    <img src="{{ $story->image_url }}" alt="{{ $story->title_en }}" class="img-fluid" style="max-height: 200px;">
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
                                       value="{{ old('title_' . $language->code, $story->{'title_' . $language->code}) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="content_{{ $language->code }}" class="form-label">Content ({{ $language->name }}) *</label>
                                <textarea class="form-control summernote" name="content_{{ $language->code }}" rows="10" required>{{ old('content_' . $language->code, $story->{'content_' . $language->code}) }}</textarea>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Update Story</button>
                <a href="{{ route('admin.stories.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
