{{-- resources/views/admin/partners/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Partners')
@section('page-title', 'Partners')

@section('page-actions')
<a href="{{ route('admin.partners.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-2"></i>Add New Partner
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            @forelse($partners as $partner)
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="text-center p-3">
                            <img src="{{ $partner->logo_url }}" alt="{{ $partner->name_en }}" 
                                 class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                        </div>
                        <div class="card-body text-center">
                            <h6 class="card-title">{{ $partner->name_en }}</h6>
                            @if($partner->website_url)
                                <p class="card-text small text-muted">
                                    <a href="{{ $partner->website_url }}" target="_blank" class="text-decoration-none">
                                        <i class="fas fa-external-link-alt me-1"></i>Visit Website
                                    </a>
                                </p>
                            @endif
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    @if($partner->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </small>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.partners.edit', $partner) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.partners.destroy', $partner) }}" method="POST" class="d-inline">
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
                    <p class="text-muted">No partners found</p>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center">
            {{ $partners->links() }}
        </div>
    </div>
</div>
@endsection
