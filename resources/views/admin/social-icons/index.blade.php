{{-- resources/views/admin/social-icons/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Social Icons')
@section('page-title', 'Social Icons')

@section('page-actions')
<a href="{{ route('admin.social-icons.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-2"></i>Add New Social Icon
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Name</th>
                        <th>URL</th>
                        <th>Color</th>
                        <th>Sort Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($socialIcons as $icon)
                        <tr>
                            <td class="text-center">
                                <i class="{{ $icon->icon_class }} fa-2x" style="color: {{ $icon->color }};"></i>
                            </td>
                            <td>{{ $icon->name }}</td>
                            <td>
                                <a href="{{ $icon->url }}" target="_blank" class="text-decoration-none">
                                    {{ Str::limit($icon->url, 30) }}
                                    <i class="fas fa-external-link-alt ms-1"></i>
                                </a>
                            </td>
                            <td>
                                <span class="badge" style="background-color: {{ $icon->color }}; color: white;">
                                    {{ $icon->color }}
                                </span>
                            </td>
                            <td>{{ $icon->sort_order }}</td>
                            <td>
                                @if($icon->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.social-icons.edit', $icon) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.social-icons.destroy', $icon) }}" method="POST" class="d-inline">
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
                            <td colspan="7" class="text-center">No social icons found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $socialIcons->links() }}
        </div>
    </div>
</div>
@endsection
