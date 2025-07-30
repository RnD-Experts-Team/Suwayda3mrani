{{-- resources/views/admin/contents/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Site Contents')
@section('page-title', 'Site Contents')

@section('page-actions')
<a href="{{ route('admin.contents.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-2"></i>Add New Content
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Key</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
    @forelse($contents as $content)
        <tr>
            <td class="text-center">
                {{ $content->key }}
                @if($content->key === 'page_headers')
                    <br><small class="text-muted">Controls page header backgrounds</small>
                @endif
            </td>
            <td class="text-center">
                @if($content->is_active)
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-danger">Inactive</span>
                @endif
            </td>
            <td class="text-center">
                <a href="{{ route('admin.contents.edit', $content) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('admin.contents.destroy', $content) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="3" class="text-center">No content found</td>
        </tr>
    @endforelse
</tbody>
            </table>
        </div>
    </div>
</div>
@endsection
