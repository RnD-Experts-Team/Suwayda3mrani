{{-- resources/views/admin/dashboard.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-brand text-uppercase mb-1">Site Contents</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['contents'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Media Items</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['media_items'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-images fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Stories</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['stories'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Partners</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['partners'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-handshake fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-brand">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <a href="{{ route('admin.contents.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-file-alt me-2"></i>Manage Site Content
                    </a>
                    <a href="{{ route('admin.media.create') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-plus me-2"></i>Add New Media
                    </a>
                    <a href="{{ route('admin.stories.create') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-plus me-2"></i>Add New Story
                    </a>
                    <a href="{{ route('admin.partners.create') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-plus me-2"></i>Add New Partner
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-brand">Recent Activity</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <p class="text-muted">Recent changes and updates will appear here.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
