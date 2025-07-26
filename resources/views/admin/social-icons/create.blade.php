{{-- resources/views/admin/social-icons/create.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Add New Social Icon')
@section('page-title', 'Add New Social Icon')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.social-icons.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               name="name" value="{{ old('name') }}" required 
                               placeholder="Facebook, Twitter, Instagram">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="icon_class" class="form-label">Icon Class *</label>
                        <input type="text" class="form-control @error('icon_class') is-invalid @enderror" 
                               name="icon_class" value="{{ old('icon_class') }}" required 
                               placeholder="fab fa-facebook">
                        <small class="form-text text-muted">FontAwesome icon class (e.g., fab fa-facebook, fab fa-twitter)</small>
                        @error('icon_class')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="url" class="form-label">URL *</label>
                        <input type="url" class="form-control @error('url') is-invalid @enderror" 
                               name="url" value="{{ old('url') }}" required 
                               placeholder="https://facebook.com/yourpage">
                        @error('url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="color" class="form-label">Color *</label>
                        <input type="color" class="form-control form-control-color @error('color') is-invalid @enderror" 
                               name="color" value="{{ old('color', '#1877f2') }}" required>
                        @error('color')
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

            <!-- Icon Preview -->
            <div class="mb-3">
                <label class="form-label">Preview</label>
                <div class="border rounded p-3 text-center">
                    <i id="icon-preview" class="fab fa-facebook fa-3x" style="color: #1877f2;"></i>
                    <p class="mt-2 mb-0">Icon preview will appear here</p>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Create Social Icon</button>
                <a href="{{ route('admin.social-icons.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const iconClassInput = document.querySelector('input[name="icon_class"]');
    const colorInput = document.querySelector('input[name="color"]');
    const iconPreview = document.getElementById('icon-preview');
    
    function updatePreview() {
        const iconClass = iconClassInput.value || 'fab fa-facebook';
        const color = colorInput.value || '#1877f2';
        
        iconPreview.className = iconClass + ' fa-3x';
        iconPreview.style.color = color;
    }
    
    iconClassInput.addEventListener('input', updatePreview);
    colorInput.addEventListener('input', updatePreview);
    
    updatePreview();
});
</script>
@endpush
@endsection
