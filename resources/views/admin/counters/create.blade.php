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
                        <label for="icon" class="form-label">Icon (FontAwesome class)</label>
                        <input type="text" class="form-control" name="icon" value="{{ old('icon') }}" 
                               placeholder="fas fa-users">
                        <small class="form-text text-muted">Example: fas fa-users, fas fa-heart, fas fa-star</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', 0) }}">
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
@endsection
