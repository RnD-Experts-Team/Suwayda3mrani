{{-- resources/views/admin/partners/create.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Add New Partner')
@section('page-title', 'Add New Partner')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.partners.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="logo_url" class="form-label">Logo URL *</label>
                        <input type="url" class="form-control @error('logo_url') is-invalid @enderror" 
                               name="logo_url" value="{{ old('logo_url') }}" required>
                        @error('logo_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="website_url" class="form-label">Website URL</label>
                        <input type="url" class="form-control @error('website_url') is-invalid @enderror" 
                               name="website_url" value="{{ old('website_url') }}">
                        @error('website_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', 0) }}">
                    </div>
                </div>
                <div class="col-md-6">
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
                        <div class="p-3">
                            <div class="mb-3">
                                <label for="name_{{ $language->code }}" class="form-label">Partner Name ({{ $language->name }}) *</label>
                                <input type="text" class="form-control" name="name_{{ $language->code }}" 
                                       value="{{ old('name_' . $language->code) }}" required>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Create Partner</button>
                <a href="{{ route('admin.partners.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
