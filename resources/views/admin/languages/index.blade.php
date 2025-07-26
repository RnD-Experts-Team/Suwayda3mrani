{{-- resources/views/admin/languages/index.blade.php - REPLACE WITH THIS --}}
@extends('admin.layouts.app')

@section('title', 'Languages')
@section('page-title', 'Languages')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Available Languages</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Direction</th>
                                <th>Status</th>
                                <th>Default</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($languages as $language)
                                <tr>
                                    <td>{{ $language->code }}</td>
                                    <td>{{ $language->name }}</td>
                                    <td>{{ strtoupper($language->direction) }}</td>
                                    <td>
                                        @if($language->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($language->is_default)
                                            <span class="badge bg-primary">Default</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $language->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        @if(!$language->is_default)
                                            <form action="{{ route('admin.languages.destroy', $language) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal{{ $language->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.languages.update', $language) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Language</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Name</label>
                                                        <input type="text" class="form-control" name="name" value="{{ $language->name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="direction" class="form-label">Direction</label>
                                                        <select class="form-select" name="direction" required>
                                                            <option value="ltr" {{ $language->direction == 'ltr' ? 'selected' : '' }}>LTR</option>
                                                            <option value="rtl" {{ $language->direction == 'rtl' ? 'selected' : '' }}>RTL</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input type="checkbox" class="form-check-input" name="is_active" {{ $language->is_active ? 'checked' : '' }}>
                                                        <label class="form-check-label">Active</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="is_default" {{ $language->is_default ? 'checked' : '' }}>
                                                        <label class="form-check-label">Default Language</label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Add New Language</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.languages.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="code" class="form-label">Language Code</label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror" 
                               name="code" value="{{ old('code') }}" maxlength="2" required>
                        <small class="form-text text-muted">2-letter code (e.g., en, ar, fr)</small>
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Language Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="direction" class="form-label">Text Direction</label>
                        <select class="form-select @error('direction') is-invalid @enderror" name="direction" required>
                            <option value="ltr" {{ old('direction') == 'ltr' ? 'selected' : '' }}>Left to Right (LTR)</option>
                            <option value="rtl" {{ old('direction') == 'rtl' ? 'selected' : '' }}>Right to Left (RTL)</option>
                        </select>
                        @error('direction')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" name="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label">Active</label>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" name="is_default">
                        <label class="form-check-label">Set as Default</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Add Language</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
