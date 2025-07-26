{{-- resources/views/admin/translations/create.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Add New Translation')
@section('page-title', 'Add New Translation')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.translations.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="key" class="form-label">Translation Key *</label>
                        <input type="text" class="form-control @error('key') is-invalid @enderror" 
                               name="key" value="{{ old('key') }}" required 
                               placeholder="e.g., nav.home, button.read_more">
                        <small class="form-text text-muted">Use dot notation for organization (group.key)</small>
                        @error('key')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="group" class="form-label">Group *</label>
                        <select class="form-select @error('group') is-invalid @enderror" name="group" required>
                            <option value="">Select Group</option>
                            @foreach($groups as $group)
                                <option value="{{ $group }}" {{ old('group') == $group ? 'selected' : '' }}>
                                    {{ ucfirst($group) }}
                                </option>
                            @endforeach
                        </select>
                        @error('group')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
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
                                <label for="translation_{{ $language->code }}" class="form-label">Translation ({{ $language->name }}) *</label>
                                <input type="text" class="form-control" name="translation_{{ $language->code }}" 
                                       value="{{ old('translation_' . $language->code) }}" required>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Create Translation</button>
                <a href="{{ route('admin.translations.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
