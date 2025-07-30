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
            <table class="table  rounded">
                <thead>
                    <tr>
                        <th class="text-center">Icon</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">URL</th>
                        <th class="text-center">Color</th>
                        <th class="text-center">Sort Order</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($socialIcons as $icon)
                        <tr>
                            <td class="text-center">
                                <i class="{{ $icon->icon_class }} fa-2x" style="color: {{ $icon->color }};"></i>
                            </td>
                            <td class="text-center">{{ $icon->name }}</td>
                            <td class="text-center">
                                <a href="{{ $icon->url }}" target="_blank" class="text-decoration-none">
                                    {{ Str::limit($icon->url, 30) }}
                                    <i class="fas fa-external-link-alt ms-1"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <span class="badge" style="background-color: {{ $icon->color }}; color: white;">
                                    {{ $icon->color }}
                                </span>
                            </td>
                            <td class="text-center">{{ $icon->sort_order }}</td>
                            <td class="text-center">
                                @if($icon->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.social-icons.edit', $icon) }}" class="btn btn-sm btn-primary me-2">
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
